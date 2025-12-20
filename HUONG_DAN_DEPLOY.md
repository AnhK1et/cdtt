# 🚀 HƯỚNG DẪN DEPLOY LARAVEL LÊN RAILWAY (HOSTING)

## 📋 CHUẨN BỊ

### APP_KEY của bạn:
```
base64:JtgBmBpRzHEgXN/71caroUgQhyGiZ0s4WkyLLYDZtQU=
```
**Lưu ý:** Copy key này để dùng ở bước sau!

---

## 🔥 CÁC BƯỚC DEPLOY

### **BƯỚC 1: Đăng nhập Railway**
1. Truy cập: https://railway.com/
2. Click **"Login"** hoặc **"Start a New Project"**
3. Chọn **"Login with GitHub"**
4. Authorize Railway truy cập GitHub của bạn

---

### **BƯỚC 2: Tạo Project mới**
1. Sau khi đăng nhập, click **"New Project"**
2. Chọn **"Deploy from GitHub repo"**
3. Tìm và chọn repository: **`cdtt`** (hoặc `AnhK1et/cdtt`)
4. Railway sẽ tự động bắt đầu build project

---

### **BƯỚC 3: Thêm Database MySQL**
1. Trong project vừa tạo, click nút **"New"** (màu xanh)
2. Chọn **"Database"** → **"Add MySQL"**
3. Railway sẽ tự động tạo MySQL database
4. **QUAN TRỌNG:** Railway sẽ tự động thêm các biến môi trường:
   - `MYSQL_HOST`
   - `MYSQL_PORT`
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`
   - `MYSQL_URL`

---

### **BƯỚC 4: Cấu hình Environment Variables**
1. Click vào **service Laravel** (không phải database)
2. Vào tab **"Variables"**
3. Thêm các biến sau:

#### **Biến bắt buộc:**
```
APP_NAME=AnhKiet Store
APP_ENV=production
APP_KEY=base64:JtgBmBpRzHEgXN/71caroUgQhyGiZ0s4WkyLLYDZtQU=
APP_DEBUG=false
APP_URL=https://your-app-name.railway.app
```

#### **Biến Database (Railway tự động thêm, nhưng cần map sang Laravel):**
```
DB_CONNECTION=mysql
DB_HOST=${MYSQL_HOST}
DB_PORT=${MYSQL_PORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}
```

**Hoặc nếu Railway không tự map, bạn cần:**
1. Vào **MySQL service** → tab **"Variables"**
2. Copy các giá trị:
   - `MYSQL_HOST` → dùng cho `DB_HOST`
   - `MYSQL_PORT` → dùng cho `DB_PORT`
   - `MYSQLDATABASE` → dùng cho `DB_DATABASE`
   - `MYSQLUSER` → dùng cho `DB_USERNAME`
   - `MYSQLPASSWORD` → dùng cho `DB_PASSWORD`

---

### **BƯỚC 5: Chờ Build hoàn tất**
1. Railway sẽ tự động build project
2. Xem tiến trình ở tab **"Deployments"**
3. Đợi đến khi thấy **"Deploy Successful"** (màu xanh)

---

### **BƯỚC 6: Chạy Migrations và Seeders**

#### **Cách 1: Dùng Railway Dashboard (Dễ nhất)**
1. Vào **service Laravel** → tab **"Settings"**
2. Tìm phần **"Deploy Command"** hoặc **"Start Command"**
3. Thay đổi command thành:
```bash
php artisan migrate --force && php artisan db:seed --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=${PORT}
```

#### **Cách 2: Dùng Railway CLI**
1. Cài Railway CLI:
```bash
npm install -g @railway/cli
```

2. Login:
```bash
railway login
```

3. Link project:
```bash
railway link
```

4. Chạy migrations:
```bash
railway run php artisan migrate --force
railway run php artisan db:seed --force
railway run php artisan storage:link
```

#### **Cách 3: Dùng Railway Shell (Trong Dashboard)**
1. Vào service Laravel → tab **"Deployments"**
2. Click vào deployment mới nhất
3. Tìm nút **"Shell"** hoặc **"Open Shell"**
4. Chạy các lệnh:
```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

---

### **BƯỚC 7: Lấy URL của website**
1. Vào service Laravel → tab **"Settings"**
2. Tìm phần **"Domains"** hoặc **"Generate Domain"**
3. Click **"Generate Domain"** để tạo URL miễn phí
4. URL sẽ có dạng: `https://your-app-name.up.railway.app`
5. **Copy URL này** và cập nhật lại biến `APP_URL` trong Variables:
   ```
   APP_URL=https://your-app-name.up.railway.app
   ```
6. Redeploy để áp dụng thay đổi

---

### **BƯỚC 8: Kiểm tra website**
1. Mở URL vừa tạo trong trình duyệt
2. Nếu thấy website chạy = **THÀNH CÔNG!** ✅

---

## ⚠️ XỬ LÝ LỖI

### **Lỗi: Build failed**
- Kiểm tra logs trong tab **"Deployments"**
- Đảm bảo tất cả files đã được commit lên GitHub
- Kiểm tra Dockerfile có đúng không

### **Lỗi: Database connection failed**
- Kiểm tra các biến môi trường DB đã đúng chưa
- Đảm bảo MySQL service đã chạy
- Kiểm tra `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

### **Lỗi: 500 Internal Server Error**
- Kiểm tra logs trong Railway dashboard
- Đảm bảo `APP_KEY` đã được set
- Kiểm tra permissions của storage folder

### **Lỗi: Images không hiển thị**
- Đảm bảo các images trong `public/images` đã được commit
- Chạy `php artisan storage:link`

---

## 📝 LƯU Ý QUAN TRỌNG

1. **Không commit file `.env`** lên GitHub (đã có trong .gitignore)
2. **Images trong `public/images`** đã được commit, sẽ tự động có trên hosting
3. **Railway tự động deploy** mỗi khi bạn push code lên GitHub
4. **Free tier có giới hạn**, nhưng đủ để test và demo

---

## 🎉 HOÀN TẤT!

Sau khi hoàn tất các bước trên, website của bạn sẽ chạy trên Railway với URL dạng:
```
https://your-app-name.up.railway.app
```

**Chúc bạn deploy thành công!** 🚀

