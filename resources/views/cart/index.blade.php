@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Shopping Cart</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(empty($products))
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5>Your cart is empty</h5>
                            <p class="text-muted">Add some products to your cart to continue shopping</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag"></i> Continue Shopping
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item['product']->image)
                                                        <img src="{{ asset('storage/' . $item['product']->image) }}"
                                                            class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;"
                                                            alt="{{ $item['product']->name }}">
                                                    @else
                                                        <img src="{{ asset('images/no-image.png') }}"
                                                            class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;"
                                                            alt="No image">
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $item['product']->name }}</h6>
                                                        <small class="text-muted">{{ ucfirst($item['product']->category) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>${{ number_format($item['product']->price, 2) }}</td>
                                            <td>
                                                <form action="{{ route('cart.update', $item['product']) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="number" name="quantity" class="form-control form-control-sm"
                                                        value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->quantity }}"
                                                        onchange="this.form.submit()">
                                                </form>
                                            </td>
                                            <td>${{ number_format($item['product']->price * $item['quantity'], 2) }}</td>
                                            <td>
                                                <form action="{{ route('cart.remove', $item['product']) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if(!empty($products))
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        @php
                            $tax = $total * 0.1; // 10% tax
                        @endphp
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax (10%)</span>
                            <span>${{ number_format($tax, 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total</strong>
                            <strong>${{ number_format($total + $tax, 2) }}</strong>
                        </div>
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            @foreach($products as $item)
                                <input type="hidden" name="items[{{ $loop->index }}][product_id]" value="{{ $item['product']->id }}">
                                <input type="hidden" name="items[{{ $loop->index }}][quantity]" value="{{ $item['quantity'] }}">
                            @endforeach
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Shipping Address</label>
                                <textarea class="form-control @error('shipping_address') is-invalid @enderror"
                                    id="shipping_address" name="shipping_address" rows="3" required>{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input type="text" class="form-control @error('contact_number') is-invalid @enderror"
                                    id="contact_number" name="contact_number" value="{{ old('contact_number') }}" required>
                                @error('contact_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Order Notes (Optional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-check"></i> Place Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
