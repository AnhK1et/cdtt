<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        // Thống kê
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processing', 'shipping'])
            ->count();
        $totalReviews = Review::where('user_id', $user->id)->count();
        $totalWishlist = $user->wishlists()->count();

        // Đơn hàng gần đây
        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('account.index', compact(
            'user',
            'totalOrders',
            'pendingOrders',
            'totalReviews',
            'totalWishlist',
            'recentOrders'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('account.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return back()->with('success', 'Đã cập nhật thông tin thành công!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Đã đổi mật khẩu thành công!');
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('account.orders', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        // Kiểm tra order thuộc về user hiện tại
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.product', 'coupon']);

        return view('account.order-detail', compact('order'));
    }

    public function reviews()
    {
        $user = Auth::user();
        $reviews = Review::where('user_id', $user->id)
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('account.reviews', compact('reviews'));
    }
}

