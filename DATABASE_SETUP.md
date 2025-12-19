# Hướng dẫn tạo Database và chạy Migrations

## Bước 1: Tạo Database trong MySQL

Bạn có thể tạo database bằng một trong các cách sau:

### Cách 1: Sử dụng phpMyAdmin (Laragon)

1. Mở Laragon
2. Click vào **Database** hoặc truy cập `http://localhost/phpmyadmin`
3. Tạo database mới với tên: `anhkiet_cdtt`
4. Chọn collation: `utf8mb4_unicode_ci`

### Cách 2: Sử dụng MySQL Command Line

```bash
mysql -u root -p
```

Sau đó chạy lệnh SQL:

```sql
CREATE DATABASE anhkiet_cdtt CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### Cách 3: Sử dụng Laravel Artisan (Tự động tạo nếu có quyền)

```bash
php artisan db:create
```

**Lưu ý**: Lệnh này chỉ hoạt động nếu MySQL user có quyền CREATE DATABASE.

## Bước 2: Cấu hình file .env

Đảm bảo file `.env` có cấu hình database đúng:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=anhkiet_cdtt
DB_USERNAME=root
DB_PASSWORD=
```

**Lưu ý**: 
- Nếu MySQL có password, thêm vào `DB_PASSWORD`
- Nếu dùng port khác, cập nhật `DB_PORT`

## Bước 3: Chạy Migrations

Sau khi tạo database, chạy migrations để tạo các bảng:

```bash
php artisan migrate
```

Hoặc nếu muốn reset và chạy lại từ đầu (xóa dữ liệu cũ):

```bash
php artisan migrate:fresh
```

## Bước 4: Chạy Seeders (Tạo dữ liệu mẫu)

Sau khi migrations hoàn tất, chạy seeders:

```bash
php artisan db:seed
```

Hoặc reset và seed cùng lúc:

```bash
php artisan migrate:fresh --seed
```

## Kiểm tra Database

### Kiểm tra migrations đã chạy:

```bash
php artisan migrate:status
```

### Kiểm tra kết nối database:

```bash
php artisan tinker
```

Trong tinker, chạy:
```php
DB::connection()->getPdo();
```

Nếu không có lỗi, database đã kết nối thành công.

## Các bảng sẽ được tạo

Sau khi chạy migrations, các bảng sau sẽ được tạo:

1. **users** - Người dùng (admin/customer)
2. **password_reset_tokens** - Token reset password
3. **failed_jobs** - Jobs thất bại
4. **personal_access_tokens** - API tokens
5. **categories** - Danh mục sản phẩm
6. **products** - Sản phẩm điện thoại
7. **orders** - Đơn hàng
8. **order_items** - Chi tiết đơn hàng

## Troubleshooting

### Lỗi: "Access denied for user"
- Kiểm tra `DB_USERNAME` và `DB_PASSWORD` trong file `.env`
- Đảm bảo MySQL đang chạy

### Lỗi: "Unknown database 'anhkiet_cdtt'"
- Database chưa được tạo
- Tạo database theo Bước 1 ở trên

### Lỗi: "Table already exists"
- Chạy `php artisan migrate:fresh` để reset database
- **CẢNH BÁO**: Lệnh này sẽ xóa toàn bộ dữ liệu!

### Lỗi: "Migration table not found"
- Chạy `php artisan migrate:install` trước
- Hoặc chạy `php artisan migrate` sẽ tự động tạo

## Quick Start (Tất cả trong một lệnh)

Nếu muốn làm tất cả từ đầu:

```bash
# 1. Tạo database (thủ công qua phpMyAdmin hoặc MySQL)
# 2. Chạy migrations và seeders
php artisan migrate:fresh --seed
```

Lệnh này sẽ:
- Xóa tất cả bảng cũ (nếu có)
- Tạo lại tất cả bảng
- Chèn dữ liệu mẫu

