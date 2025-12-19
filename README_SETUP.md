# Hướng dẫn cài đặt và chạy dự án Laravel Web Bán Điện Thoại

## Yêu cầu hệ thống

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js và NPM (cho frontend assets)

## Các bước cài đặt

### 1. Cài đặt dependencies

```bash
composer install
npm install
```

### 2. Cấu hình môi trường

Sao chép file `.env.example` thành `.env` (nếu chưa có):

```bash
cp .env.example .env
```

Cập nhật thông tin database trong file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=anhkiet_cdtt
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Tạo key ứng dụng

```bash
php artisan key:generate
```

### 4. Chạy migrations

```bash
php artisan migrate
```

### 5. Tạo storage link (cho upload ảnh)

```bash
php artisan storage:link
```

### 6. Chạy seeders (tạo dữ liệu mẫu)

```bash
php artisan db:seed
```

Dữ liệu mẫu bao gồm:
- **Admin user**: 
  - Email: `admin@phonestore.com`
  - Password: `admin123`
- **Customer users**: 
  - Email: `customer@example.com` hoặc `customer2@example.com`
  - Password: `password123`
- **5 danh mục**: iPhone, Samsung, Xiaomi, OPPO, Vivo
- **10 sản phẩm** điện thoại mẫu

### 7. Build frontend assets

```bash
npm run build
```

Hoặc chạy dev mode:

```bash
npm run dev
```

### 8. Chạy server

```bash
php artisan serve
```

Truy cập: http://localhost:8000

## Cấu trúc dự án

### Database

- **users**: Người dùng (admin/customer)
- **categories**: Danh mục sản phẩm
- **products**: Sản phẩm điện thoại
- **orders**: Đơn hàng
- **order_items**: Chi tiết đơn hàng

### Routes

- **Frontend**: `/`, `/products`, `/cart`, `/checkout`, `/orders`
- **Auth**: `/login`, `/register`
- **Admin**: `/admin/dashboard`, `/admin/categories`, `/admin/products`, `/admin/orders`

### Tính năng

✅ Đăng ký/Đăng nhập người dùng
✅ Xem danh sách sản phẩm
✅ Tìm kiếm và lọc sản phẩm
✅ Chi tiết sản phẩm
✅ Giỏ hàng (Session-based)
✅ Đặt hàng
✅ Quản lý đơn hàng (user)
✅ Admin panel:
   - Dashboard với thống kê
   - Quản lý danh mục
   - Quản lý sản phẩm
   - Quản lý đơn hàng

## Lưu ý

- Đảm bảo thư mục `storage/app/public` có quyền ghi để upload ảnh
- Chạy `php artisan storage:link` để liên kết storage với public
- Admin panel chỉ truy cập được khi đăng nhập với tài khoản có role = 'admin'

## Troubleshooting

### Lỗi storage link

```bash
php artisan storage:link
```

### Lỗi permission

Trên Linux/Mac:
```bash
chmod -R 775 storage bootstrap/cache
```

### Clear cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

