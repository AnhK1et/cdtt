# Hướng dẫn sử dụng dữ liệu mẫu

## Tổng quan dữ liệu mẫu

Dữ liệu mẫu bao gồm:
- **8 Categories**: iPhone, Samsung, Xiaomi, OPPO, Vivo, Realme, OnePlus, Huawei
- **50+ Products**: Sản phẩm điện thoại đa dạng từ các hãng
- **10 Users**: 2 admin + 8 khách hàng
- **20 Orders**: Đơn hàng mẫu với các trạng thái khác nhau

## Cách chạy seeder

### 1. Reset và seed toàn bộ database
```bash
php artisan migrate:fresh --seed
```

### 2. Chạy từng seeder riêng lẻ
```bash
# Seed users
php artisan db:seed --class=UserSeeder

# Seed categories
php artisan db:seed --class=CategorySeeder

# Seed products
php artisan db:seed --class=ProductSeeder

# Seed orders
php artisan db:seed --class=OrderSeeder
```

### 3. Chạy tất cả seeders
```bash
php artisan db:seed
```

## Thông tin đăng nhập

### Tài khoản Admin
- **Email**: `admin@phonestore.com`
- **Password**: `admin123`

- **Email**: `admin2@phonestore.com`
- **Password**: `admin123`

### Tài khoản Khách hàng
Tất cả khách hàng có cùng password: `password123`

- `nguyenvana@example.com`
- `tranthib@example.com`
- `levanc@example.com`
- `phamthid@example.com`
- `hoangvane@example.com`
- `vuthif@example.com`
- `dovang@example.com`
- `buithih@example.com`

## Chi tiết dữ liệu mẫu

### Categories (8 danh mục)
1. iPhone - Điện thoại iPhone chính hãng Apple
2. Samsung - Điện thoại Samsung Galaxy series
3. Xiaomi - Điện thoại Xiaomi giá tốt
4. OPPO - Điện thoại OPPO với camera chụp ảnh đẹp
5. Vivo - Điện thoại Vivo với nhiều tính năng
6. Realme - Điện thoại Realme giá rẻ
7. OnePlus - Điện thoại OnePlus flagship killer
8. Huawei - Điện thoại Huawei với camera Leica

### Products (50+ sản phẩm)
- **iPhone**: 8 sản phẩm (iPhone 15 Pro Max, iPhone 15 Pro, iPhone 15, iPhone 14 Pro, iPhone 14, iPhone 13)
- **Samsung**: 8 sản phẩm (Galaxy S24 Ultra, S24+, S24, A54, A34, Z Fold5, Z Flip5)
- **Xiaomi**: 6 sản phẩm (Xiaomi 14 Pro, Xiaomi 14, Redmi Note 13 Pro, Redmi Note 13, POCO X6 Pro, Redmi 13C)
- **OPPO**: 6 sản phẩm (Find X7 Ultra, Find X7, Reno11, A79, A58)
- **Vivo**: 6 sản phẩm (X100 Pro, X100, Y100, Y27, V29, Y36)
- **Realme**: 4 sản phẩm (GT5 Pro, 12 Pro+, C55, C53)
- **OnePlus**: 3 sản phẩm (OnePlus 12, 12R, Nord CE 3)
- **Huawei**: 3 sản phẩm (P60 Pro, Nova 12, Enjoy 70)

### Orders (20 đơn hàng)
- Các trạng thái: pending, processing, shipped, delivered, cancelled
- Mỗi đơn hàng có 1-3 sản phẩm
- Đơn hàng được tạo trong 30 ngày qua
- Địa chỉ giao hàng ngẫu nhiên tại TP.HCM

## Lưu ý

1. **Thứ tự chạy seeder**: 
   - UserSeeder → CategorySeeder → ProductSeeder → OrderSeeder
   - DatabaseSeeder sẽ tự động chạy theo thứ tự này

2. **Reset database**: 
   - Sử dụng `migrate:fresh` sẽ xóa toàn bộ dữ liệu và chạy lại migrations + seeders

3. **Thêm dữ liệu mới**: 
   - Chỉnh sửa các file seeder trong thư mục `database/seeders/`
   - Chạy lại seeder tương ứng

## Troubleshooting

### Lỗi: "Không có danh mục nào"
- Chạy CategorySeeder trước ProductSeeder

### Lỗi: "Không có khách hàng hoặc sản phẩm"
- Đảm bảo đã chạy UserSeeder và ProductSeeder trước OrderSeeder

### Lỗi foreign key constraint
- Sử dụng `migrate:fresh --seed` để reset toàn bộ database

