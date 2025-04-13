@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" class="img-fluid rounded" alt="No image">
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">{{ $product->name }}</h2>
                    <p class="text-muted">{{ ucfirst($product->category) }}</p>
                    <p class="card-text">{{ $product->description }}</p>

                    <div class="mb-3">
                        <h4 class="text-primary">${{ number_format($product->price, 2) }}</h4>
                        <p class="text-{{ $product->quantity > 0 ? 'success' : 'danger' }}">
                            {{ $product->quantity > 0 ? $product->quantity . ' in stock' : 'Out of stock' }}
                        </p>
                    </div>

                    @auth
                        @if($product->quantity > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <div class="row g-3 align-items-center mb-3">
                                    <div class="col-auto">
                                        <label for="quantity" class="col-form-label">Quantity:</label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="number" id="quantity" name="quantity" class="form-control"
                                            min="1" max="{{ $product->quantity }}" value="1" required>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-cart-plus"></i> Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <button class="btn btn-secondary" disabled>
                                <i class="fas fa-times-circle"></i> Out of Stock
                            </button>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Please <a href="{{ route('login') }}">login</a> to order this product.
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('quantity').addEventListener('change', function(e) {
    const max = parseInt(e.target.max);
    const value = parseInt(e.target.value);
    if (value > max) {
        e.target.value = max;
    }
});
</script>
@endpush
