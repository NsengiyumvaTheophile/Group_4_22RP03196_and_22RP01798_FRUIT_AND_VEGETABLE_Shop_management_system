@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3">Our Products</h1>
        </div>
        <div class="col-md-6 text-end">
            @if(Auth::check() && Auth::user()->is_admin)
                <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add New Product
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top product-image" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">${{ number_format($product->price, 2) }}</span>
                            @auth
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-success btn-sm">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No products found.
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
