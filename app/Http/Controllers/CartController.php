<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $products = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
                $total += $product->price * $quantity;
            }
        }

        return view('cart.index', compact('products', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = Session::get('cart', []);
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$product->id])) {
            $cart[$product->id] += $quantity;
        } else {
            $cart[$product->id] = $quantity;
        }

        Session::put('cart', $cart);

        return redirect()->route('cart.index')
            ->with('success', 'Product added to cart successfully.');
    }

    public function update(Request $request, Product $product)
    {
        $cart = Session::get('cart', []);
        $quantity = $request->input('quantity');

        if ($quantity > 0) {
            $cart[$product->id] = $quantity;
        } else {
            unset($cart[$product->id]);
        }

        Session::put('cart', $cart);

        return redirect()->route('cart.index')
            ->with('success', 'Cart updated successfully.');
    }

    public function remove(Product $product)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
        }

        Session::put('cart', $cart);

        return redirect()->route('cart.index')
            ->with('success', 'Product removed from cart successfully.');
    }

    public function clear()
    {
        Session::forget('cart');

        return redirect()->route('cart.index')
            ->with('success', 'Cart cleared successfully.');
    }
}
