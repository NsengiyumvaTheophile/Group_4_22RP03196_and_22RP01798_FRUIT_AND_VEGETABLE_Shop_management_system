@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Order Items</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
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
                                                <small class="text-muted">{{ ucfirst($item->product->category) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td class="text-end"><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Order Timeline</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-point bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Order Placed</h6>
                            <p class="mb-0 text-muted">{{ $order->created_at->format('F j, Y, g:i a') }}</p>
                        </div>
                    </div>

                    @if($order->status !== 'pending')
                        <div class="timeline-item">
                            <div class="timeline-point bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Status Updated to {{ ucfirst($order->status) }}</h6>
                                <p class="mb-0 text-muted">{{ $order->updated_at->format('F j, Y, g:i a') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Order Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Order Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted">Order ID</label>
                    <p class="mb-0">#{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted">Order Date</label>
                    <p class="mb-0">{{ $order->created_at->format('F j, Y, g:i a') }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted">Status</label>
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Customer Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted">Name</label>
                    <p class="mb-0">{{ $order->user->name }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted">Email</label>
                    <p class="mb-0">{{ $order->user->email }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted">Contact Number</label>
                    <p class="mb-0">{{ $order->contact_number }}</p>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Shipping Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted">Shipping Address</label>
                    <p class="mb-0">{{ $order->shipping_address }}</p>
                </div>
                @if($order->notes)
                    <div class="mb-0">
                        <label class="text-muted">Order Notes</label>
                        <p class="mb-0">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to Orders
    </a>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-point {
    position: absolute;
    left: -30px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline-item:after {
    content: '';
    position: absolute;
    left: -25px;
    top: 12px;
    width: 2px;
    height: calc(100% - 12px);
    background-color: #e9ecef;
}

.timeline-item:last-child:after {
    display: none;
}

.timeline-content {
    padding-bottom: 1rem;
}
</style>
@endsection
