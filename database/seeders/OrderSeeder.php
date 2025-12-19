<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $products = Product::where('is_active', true)->get();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Không có khách hàng hoặc sản phẩm. Vui lòng chạy UserSeeder và ProductSeeder trước.');
            return;
        }

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $addresses = [
            '123 Đường Nguyễn Huệ, Quận 1, TP.HCM',
            '456 Đường Lê Lợi, Quận 3, TP.HCM',
            '789 Đường Trần Hưng Đạo, Quận 5, TP.HCM',
            '321 Đường Nguyễn Trãi, Quận 1, TP.HCM',
            '654 Đường Điện Biên Phủ, Quận Bình Thạnh, TP.HCM',
            '987 Đường Võ Văn Tần, Quận 3, TP.HCM',
            '147 Đường Nguyễn Văn Cừ, Quận 5, TP.HCM',
            '258 Đường Cách Mạng Tháng 8, Quận 10, TP.HCM',
        ];

        // Tạo 20 đơn hàng mẫu
        for ($i = 0; $i < 20; $i++) {
            $customer = $customers->random();
            $status = $statuses[array_rand($statuses)];
            
            // Tạo ngày ngẫu nhiên trong 30 ngày qua
            $createdAt = Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            
            // Chọn 1-3 sản phẩm ngẫu nhiên
            $selectedProducts = $products->random(rand(1, 3));
            $totalAmount = 0;
            $orderItems = [];

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 3);
                $price = $product->sale_price ?? $product->price;
                $subtotal = $price * $quantity;
                $totalAmount += $subtotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
            }

            $order = Order::create([
                'user_id' => $customer->id,
                'status' => $status,
                'total_amount' => $totalAmount,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => '0' . rand(900000000, 999999999),
                'shipping_address' => $addresses[array_rand($addresses)],
                'notes' => rand(0, 1) ? 'Giao hàng trong giờ hành chính' : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Tạo order items
            foreach ($orderItems as $item) {
                OrderItem::create(array_merge($item, [
                    'order_id' => $order->id,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]));
            }
        }

        $this->command->info('Đã tạo 20 đơn hàng mẫu với các sản phẩm.');
    }
}

