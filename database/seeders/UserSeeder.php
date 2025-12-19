<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin users
        User::create([
            'name' => 'Admin',
            'email' => 'admin@phonestore.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Quản trị viên',
            'email' => 'admin2@phonestore.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Customer users
        $customers = [
            [
                'name' => 'Nguyễn Văn A',
                'email' => 'nguyenvana@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Trần Thị B',
                'email' => 'tranthib@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Lê Văn C',
                'email' => 'levanc@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Phạm Thị D',
                'email' => 'phamthid@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Hoàng Văn E',
                'email' => 'hoangvane@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Vũ Thị F',
                'email' => 'vuthif@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Đỗ Văn G',
                'email' => 'dovang@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ],
            [
                'name' => 'Bùi Thị H',
                'email' => 'buithih@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ],
        ];

        foreach ($customers as $customer) {
            User::create($customer);
        }

        $this->command->info('Đã tạo ' . (2 + count($customers)) . ' người dùng mẫu (2 admin, ' . count($customers) . ' khách hàng).');
    }
}
