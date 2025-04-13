<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        if (Auth::user()->is_admin) {
            $orders = Order::with('user')
                ->when(request('status'), function ($query) {
                    return $query->where('status', request('status'));
                })
                ->when(request('approval_status'), function ($query) {
                    return $query->where('approval_status', request('approval_status'));
                })
                ->when(request('date'), function ($query) {
                    return $query->whereDate('created_at', request('date'));
                })
                ->when(request('search'), function ($query) {
                    return $query->where(function ($q) {
                        $q->where('id', 'like', '%' . request('search') . '%')
                            ->orWhereHas('user', function ($q) {
                                $q->where('name', 'like', '%' . request('search') . '%');
                            });
                    });
                })
                ->latest()
                ->paginate(10);

            return view('admin.orders.index', compact('orders'));
        } else {
            $orders = Order::where('user_id', Auth::id())
                ->with('items')
                ->latest()
                ->paginate(10);

            return view('orders.index', compact('orders'));
        }
    }

    public function show(Order $order)
    {
        // Check if user is authorized to view this order
        if (!Auth::user()->is_admin && $order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['user', 'items.product.category']);
        return view(Auth::user()->is_admin ? 'admin.orders.show' : 'orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'contact_number' => 'required|string',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'shipping_address' => $validated['shipping_address'],
            'contact_number' => $validated['contact_number'],
            'notes' => $validated['notes'],
            'status' => 'pending',
            'approval_status' => 'pending',
            'total_amount' => 0
        ]);

        $totalAmount = 0;

        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            $price = $product->price;
            $quantity = $item['quantity'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price
            ]);

            $totalAmount += $price * $quantity;
        }

        $order->update(['total_amount' => $totalAmount]);

        // Clear the cart after successful order
        session()->forget('cart');

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order status updated successfully.');
    }

    public function updateApproval(Request $request, Order $order)
    {
        $request->validate([
            'approval_status' => 'required|in:pending,approved,rejected'
        ]);

        $order->update(['approval_status' => $request->approval_status]);

        // If order is rejected, update status to cancelled
        if ($request->approval_status === 'rejected') {
            $order->update(['status' => 'cancelled']);
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order approval status updated successfully.');
    }
}
