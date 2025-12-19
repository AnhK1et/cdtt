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
        $cartItems = [];
        $total = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $item['product'] = $product;
                $item['subtotal'] = $product->final_price * $item['quantity'];
                $total += $item['subtotal'];
                $cartItems[$productId] = $item;
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        if (!$product->is_active) {
            return back()->with('error', 'Sản phẩm không khả dụng');
        }

        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity ?? 1;
        } else {
            $cart[$id] = [
                'quantity' => $request->quantity ?? 1,
            ];
        }

        Session::put('cart', $cart);

        return back()->with('success', 'Đã thêm vào giỏ hàng');
    }

    public function update(Request $request, $id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            $quantity = (int) $request->quantity;
            if ($quantity > 0) {
                $cart[$id]['quantity'] = $quantity;
            } else {
                unset($cart[$id]);
            }
        }

        Session::put('cart', $cart);

        return back()->with('success', 'Đã cập nhật giỏ hàng');
    }

    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        Session::put('cart', $cart);

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
    }

    public function clear()
    {
        Session::forget('cart');
        return back()->with('success', 'Đã xóa toàn bộ giỏ hàng');
    }
}
