<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Map tên danh mục với tên thư mục ảnh
        $imageFolderMap = [
            'iPhone' => 'iphone',
            'Samsung' => 'samsung',
            'Xiaomi' => 'xiaomi',
            'OPPO' => 'oppo',
            'Vivo' => 'vivo',
            'Realme' => 'remi',
            'Laptop' => 'Laptop',
            'Ipad' => 'Ipad',
        ];

        $categories = [
            [
                'name' => 'iPhone',
                'description' => 'Điện thoại iPhone chính hãng Apple - Công nghệ tiên tiến, thiết kế sang trọng',
                'is_active' => true,
            ],
            [
                'name' => 'Samsung',
                'description' => 'Điện thoại Samsung Galaxy series - Hiệu năng mạnh mẽ, màn hình sắc nét',
                'is_active' => true,
            ],
            [
                'name' => 'Xiaomi',
                'description' => 'Điện thoại Xiaomi giá tốt - Cấu hình cao, giá hợp lý',
                'is_active' => true,
            ],
            [
                'name' => 'OPPO',
                'description' => 'Điện thoại OPPO với camera chụp ảnh đẹp - Chuyên về selfie và chụp ảnh',
                'is_active' => true,
            ],
            [
                'name' => 'Vivo',
                'description' => 'Điện thoại Vivo với nhiều tính năng - Camera Zeiss, hiệu năng ổn định',
                'is_active' => true,
            ],
            [
                'name' => 'Realme',
                'description' => 'Điện thoại Realme giá rẻ - Hiệu năng tốt, pin trâu',
                'is_active' => true,
            ],
            [
                'name' => 'Laptop',
                'description' => 'Laptop chính hãng - Hiệu năng mạnh mẽ, phù hợp mọi nhu cầu',
                'is_active' => true,
            ],
            [
                'name' => 'Ipad',
                'description' => 'Máy tính bảng iPad và Android - Màn hình lớn, hiệu năng cao',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create($categoryData);
            
            // Tự động tìm và gán ảnh từ thư mục images
            $categoryName = $category->name;
            if (isset($imageFolderMap[$categoryName])) {
                $imageFolder = $imageFolderMap[$categoryName];
                $imagePath = public_path("images/{$imageFolder}");
                
                if (is_dir($imagePath)) {
                    // Lấy file ảnh đầu tiên trong thư mục
                    $files = glob($imagePath . '/*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', GLOB_BRACE);
                    if (!empty($files)) {
                        // Lấy file đầu tiên và lưu đường dẫn tương đối
                        $firstImage = basename($files[0]);
                        $category->image = "images/{$imageFolder}/{$firstImage}";
                        $category->save();
                    }
                }
            }
        }
    }
}
