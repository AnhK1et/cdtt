# Hướng dẫn Deploy Laravel lên Railway

## Bước 1: Tạo tài khoản Railway
1. Truy cập https://railway.com/
2. Đăng nhập bằng GitHub account của bạn
3. Chọn "Start a New Project"

## Bước 2: Kết nối Repository
1. Chọn "Deploy from GitHub repo"
2. Chọn repository `AnhK1et/cdtt`
3. Railway sẽ tự động detect Laravel project

## Bước 3: Cấu hình Environment Variables
Trong Railway dashboard, thêm các biến môi trường sau:

### Bắt buộc:
```
APP_NAME=AnhKiet Store
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app-name.railway.app

DB_CONNECTION=mysql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Tạo APP_KEY:
Chạy lệnh này trên máy local:
```bash
php artisan key:generate --show
```
Copy key và paste vào `APP_KEY` trên Railway.

## Bước 4: Thêm Database
1. Trong Railway project, click "New" → "Database" → "MySQL"
2. Railway sẽ tự động tạo database và set các biến môi trường:
   - `DB_HOST`
   - `DB_PORT`
   - `DB_DATABASE`
   - `DB_USERNAME`
   - `DB_PASSWORD`

## Bước 5: Chạy Migrations và Seeders
1. Trong Railway dashboard, vào tab "Deployments"
2. Click vào service của bạn
3. Vào tab "Settings" → "Deploy Command"
4. Thêm command:
```bash
php artisan migrate --force && php artisan db:seed --force
```

Hoặc chạy thủ công qua Railway CLI:
```bash
railway run php artisan migrate --force
railway run php artisan db:seed --force
```

## Bước 6: Cấu hình Storage Link
Chạy command để tạo symbolic link:
```bash
railway run php artisan storage:link
```

## Bước 7: Deploy
Railway sẽ tự động deploy khi bạn push code lên GitHub. Hoặc click "Deploy" trong dashboard.

## Lưu ý quan trọng:
1. **Images**: Đảm bảo các images trong `public/images` đã được commit vào Git
2. **Storage**: Files trong `storage/app/public` cần được upload hoặc migrate
3. **Environment**: Không commit file `.env` lên Git
4. **Port**: Railway tự động set PORT, không cần config thủ công

## Troubleshooting:
- Nếu build fail, check logs trong Railway dashboard
- Đảm bảo `composer install` và `npm run build` chạy thành công
- Check database connection trong logs

## Railway CLI (Optional):
```bash
npm i -g @railway/cli
railway login
railway link
railway up
```

