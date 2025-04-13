@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Order #{{ $order->id }}</h5>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Order Items</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->items as $item)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @if($item->product->image)
                                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                                        class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;"
                                                                        alt="{{ $item->product->name }}">
                                                                @else
                                                                    <img src="{{ asset('images/default-product.jpg') }}"
                                                                        class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;"
                                                                        alt="{{ $item->product->name }}">
                                                                @endif
                                                                <div>
                                                                    <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                                    <small class="text-muted">
                                                                        @if($item->product->category)
                                                                            {{ $item->product->category->name }}
                                                                        @else
                                                                            Uncategorized
                                                                        @endif
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>${{ number_format($item->price, 2) }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-end"><strong>Tax:</strong></td>
                                                    <td>${{ number_format($order->tax_amount, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                                    <td>${{ number_format($order->total_amount + $order->tax_amount, 2) }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Order Timeline</h6>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <div class="timeline-point"></div>
                                            <div class="timeline-content">
                                                <h6 class="mb-0">Order Placed</h6>
                                                <small class="text-muted">{{ $order->created_at->format('M d, Y g:i A') }}</small>
                                            </div>
                                        </div>
                                        @foreach($order->statusUpdates as $update)
                                            <div class="timeline-item">
                                                <div class="timeline-point"></div>
                                                <div class="timeline-content">
                                                    <h6 class="mb-0">Status Updated to {{ ucfirst($update->status) }}</h6>
                                                    <small class="text-muted">{{ $update->created_at->format('M d, Y g:i A') }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Order Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Order Date:</strong><br>
                                        {{ $order->created_at->format('F j, Y, g:i A') }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Status:</strong><br>
                                        <span class="badge bg-{{ $order->status_color }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <strong>Approval Status:</strong><br>
                                        <span class="badge bg-{{ $order->approval_status_color }} fs-6">
                                            {{ ucfirst($order->approval_status) }}
                                        </span>
                                        @if($order->isApprovalPending())
                                            <p class="text-muted mt-2 mb-0">
                                                <i class="fas fa-info-circle"></i> Your order is waiting for admin approval
                                            </p>
                                        @elseif($order->isApproved())
                                            <p class="text-success mt-2 mb-0">
                                                <i class="fas fa-check-circle"></i> Your order has been approved
                                            </p>
                                        @elseif($order->isRejected())
                                            <p class="text-danger mt-2 mb-0">
                                                <i class="fas fa-times-circle"></i> Your order has been rejected
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Shipping Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Shipping Address:</strong><br>
                                        {{ $order->shipping_address }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Contact Number:</strong><br>
                                        {{ $order->contact_number }}
                                    </div>
                                    @if($order->notes)
                                        <div>
                                            <strong>Order Notes:</strong><br>
                                            {{ $order->notes }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-point {
    position: absolute;
    left: -30px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #0d6efd;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #0d6efd;
}

.timeline-content {
    padding-left: 20px;
    border-left: 2px solid #e9ecef;
}

.timeline-item:last-child .timeline-content {
    border-left: none;
}
</style>
@endsection
