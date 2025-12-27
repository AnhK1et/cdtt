const fs = require('fs');
const path = require('path');

const manifestPath = path.join(process.cwd(), 'public', 'build', 'manifest.json');
const outPath = path.join(process.cwd(), 'public', 'build', 'index.html');

if (!fs.existsSync(manifestPath)) {
  console.error('manifest.json not found at', manifestPath);
  process.exit(1);
}

const manifest = JSON.parse(fs.readFileSync(manifestPath, 'utf8'));
const cssFile = manifest['resources/css/app.css']?.file || '';
const jsFile = manifest['resources/js/app.js']?.file || '';

// Collect images from public/images/* (category subfolders) to use as product thumbnails
const imagesRoot = path.join(process.cwd(), 'public', 'images');
let productImages = [];
if (fs.existsSync(imagesRoot)) {
  const categoryDirs = fs.readdirSync(imagesRoot).map(n => path.join(imagesRoot, n)).filter(p => fs.statSync(p).isDirectory());
  for (const dir of categoryDirs) {
    const files = fs.readdirSync(dir).filter(f => /\.(png|jpe?g|webp|gif)$/i.test(f)).map(f => path.join(path.basename(dir), f));
    productImages.push(...files);
  }
  // Also include images directly under public/images if any
  const rootFiles = fs.readdirSync(imagesRoot).filter(f => /\.(png|jpe?g|webp|gif)$/i.test(f));
  productImages.push(...rootFiles);
}
// Ensure images are copied into public/build/images so Vercel serves them when outputDirectory=public/build
const buildImagesDir = path.join(process.cwd(), 'public', 'build', 'images');
if (!fs.existsSync(buildImagesDir)) {
  fs.mkdirSync(buildImagesDir, { recursive: true });
}
for (const rel of productImages) {
  const src = path.join(process.cwd(), 'public', 'images', rel);
  const dest = path.join(buildImagesDir, path.basename(rel));
  try {
    fs.copyFileSync(src, dest);
  } catch (err) {
    // ignore copy errors, continue
    // console.error('copy image failed', src, err);
  }
}

// Static homepage content to embed inside #app so production always shows homepage
const bodyContent = `
    <div class="homepage-layout">
      <div class="container">
        <div class="homepage-content">
          <aside class="categories-sidebar">
            <h3 class="sidebar-title">DANH MỤC SẢN PHẨM</h3>
            <ul class="sidebar-categories">
              <li><a href="#"><span class="category-icon">📱</span><span>iPhone</span></a></li>
              <li><a href="#"><span class="category-icon">💻</span><span>Laptop</span></a></li>
              <li><a href="#"><span class="category-icon">⌚</span><span>Apple Watch</span></a></li>
              <li><a href="#"><span class="category-icon">🎧</span><span>Tai nghe</span></a></li>
            </ul>
          </aside>

          <div class="homepage-main">
            <div class="hero-banner">
              <div class="hero-content">
                <div class="hero-left">
                  <h2 class="hero-title">iPhone 17 PRO</h2>
                  <p class="hero-subtitle">Bù thật ít. Đổi thật nhanh.</p>
                  <div class="hero-installment">
                    <div class="installment-item"><span class="installment-label">Trả góp</span><span class="installment-value">Đến 7 Triệu</span></div>
                    <div class="installment-item"><span class="installment-label">Giá</span><span class="installment-value">30.99 Triệu</span></div>
                    <div class="installment-item"><span class="installment-label">Thời hạn</span><span class="installment-value">12 Tháng</span></div>
                  </div>
                  <a href="#" class="btn-hero-buy">Xem thêm</a>
                </div>
                <div class="hero-right">
                  <div class="hero-image-placeholder">📱</div>
                </div>
              </div>
            </div>

            <section class="category-icons-section">
              <div class="section-header">
                <h2>Danh mục sản phẩm</h2>
                <a href="#" class="view-all-link">Xem tất cả</a>
              </div>
              <div class="category-icons-grid">
                <a class="category-icon-item" href="#"><div class="category-icon-circle">📱</div><span>iPhone</span></a>
                <a class="category-icon-item" href="#"><div class="category-icon-circle">💻</div><span>Laptop</span></a>
                <a class="category-icon-item" href="#"><div class="category-icon-circle">⌚</div><span>Watch</span></a>
                <a class="category-icon-item" href="#"><div class="category-icon-circle">🎧</div><span>Audio</span></a>
              </div>
            </section>

            <section class="featured-products-section">
              <div class="section-header"><h2>Sản phẩm nổi bật</h2><a href="#" class="view-all-link">Xem tất cả</a></div>
              <div class="product-grid-homepage">
                <div class="product-grid" style="display:flex;flex-wrap:wrap;gap:16px;align-items:flex-start;">
                  ${[...Array(12)].map((_,i) => `
                    <div class="product-card" style="flex:0 0 calc(33.333% - 16px);box-sizing:border-box;border:1px solid #eee;padding:12px;border-radius:8px;">
                      ${i % 4 === 0 ? '<div class="product-badge" style="background:#ff4d4f;color:#fff;padding:4px 8px;border-radius:4px;font-size:12px;display:inline-block;margin-bottom:6px;">Giảm 10%</div>' : ''}
                      <a href="#" style="text-decoration:none;color:inherit;display:block;">
                        ${productImages.length ? `<img src="/images/${productImages[i % productImages.length]}" alt="Sản phẩm ${i+1}" style="width:100%;height:160px;object-fit:cover;border-radius:6px;" />` : `<div style="width:100%;height:160px;background:#fafafa;display:flex;align-items:center;justify-content:center;font-size:40px;">📱</div>`}
                        <div class="product-info" style="padding-top:8px;">
                          <h3 style="margin:6px 0 4px;font-size:16px;">Sản phẩm mẫu ${i+1}</h3>
                          <div class="product-price" style="color:#111;font-weight:600;">
                            ${i % 3 === 0 ? '<span class="price-old" style="text-decoration:line-through;color:#888;margin-right:6px;">' + (24990000 - i*100000) + '₫</span>' : ''}
                            <span class="price-new">${(19990000 - i*50000).toLocaleString('vi-VN')}₫</span>
                          </div>
                        </div>
                      </a>
                    </div>
                  `).join('')}
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
`;

const html = `<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Anhkiet Store</title>
  ${cssFile ? `<link rel="stylesheet" href="/${cssFile}" />` : ''}
  <style>
    /* Layout tweaks: keep sidebar fixed width, allow main to expand */
    /* Make main column narrow and centered to match screenshot */
    .homepage-layout .container { display:flex; gap:16px; align-items:flex-start; max-width:420px; margin:0 auto; padding:0 12px; }
    .categories-sidebar { flex: 0 0 60px; min-width:60px; }
    .homepage-main { flex: 1 1 0; min-width:0; }
    /* Single-column compact cards to match screenshot */
    .product-grid { display: grid; grid-template-columns: 1fr; gap:12px; align-items:start; }
    .product-card { box-sizing:border-box; width:100%; display:flex; flex-direction:column; justify-content:flex-start; min-height:140px; background:#fff; border-radius:8px; padding:8px; }
    .product-card img { width:100%; height:120px; object-fit:contain; border-radius:6px; display:block; background:#fafafa; padding:6px; }
    .product-info { padding:6px 0; flex:0 0 auto; font-size:13px; }
    .product-price { margin-top:6px; font-weight:600; color:#d32f2f; font-size:13px; }
    /* responsive: keep narrow layout but allow full width on very small screens */
    @media (max-width: 600px) {
      .homepage-layout .container { max-width:100%; padding:0 8px; }
      .categories-sidebar { display:none; }
      .product-card { min-height:160px; }
      .product-card img { height:140px; }
    }
  </style>
</head>
<body>
  <header class="site-header" style="padding:12px 20px;display:flex;justify-content:space-between;align-items:center;background:#111;color:#fff;">
    <a href="/" class="brand" style="color:#fff;text-decoration:none;font-weight:700;">Anhkiet Store</a>
    <nav class="nav" style="display:flex;gap:12px;align-items:center;">
      <a href="/" style="color:#fff;text-decoration:none;">Trang chủ</a>
      <a href="/products" style="color:#fff;text-decoration:none;">Sản phẩm</a>
      <button id="loginBtn" style="background:none;border:1px solid #fff;color:#fff;padding:6px 10px;cursor:pointer;border-radius:4px;">Đăng nhập</button>
      <button id="registerBtn" style="background:#fff;border:none;color:#111;padding:6px 10px;cursor:pointer;border-radius:4px;">Đăng ký</button>
    </nav>
  </header>

  <div id="app">${bodyContent}</div>

  <!-- Login Modal -->
  <div id="loginModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;">
    <div style="background:#fff;padding:20px;border-radius:8px;max-width:420px;width:100%;">
      <h3>Đăng nhập</h3>
      <form action="/login" method="POST">
        <div style="margin-bottom:8px;"><label>Email</label><input name="email" type="email" style="width:100%;padding:8px"/></div>
        <div style="margin-bottom:8px;"><label>Mật khẩu</label><input name="password" type="password" style="width:100%;padding:8px"/></div>
        <div style="display:flex;gap:8px;justify-content:flex-end;"><button type="button" id="loginClose">Hủy</button><button type="submit">Đăng nhập</button></div>
      </form>
    </div>
  </div>

  <!-- Register Modal -->
  <div id="registerModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;">
    <div style="background:#fff;padding:20px;border-radius:8px;max-width:480px;width:100%;">
      <h3>Đăng ký</h3>
      <form action="/register" method="POST">
        <div style="margin-bottom:8px;"><label>Họ tên</label><input name="name" type="text" style="width:100%;padding:8px"/></div>
        <div style="margin-bottom:8px;"><label>Email</label><input name="email" type="email" style="width:100%;padding:8px"/></div>
        <div style="margin-bottom:8px;"><label>Mật khẩu</label><input name="password" type="password" style="width:100%;padding:8px"/></div>
        <div style="display:flex;gap:8px;justify-content:flex-end;"><button type="button" id="registerClose">Hủy</button><button type="submit">Đăng ký</button></div>
      </form>
    </div>
  </div>

  ${jsFile ? `<script type="module" src="/${jsFile}"></script>` : ''}
  <script>
    document.getElementById('loginBtn')?.addEventListener('click', function(){ document.getElementById('loginModal').style.display='flex'; });
    document.getElementById('registerBtn')?.addEventListener('click', function(){ document.getElementById('registerModal').style.display='flex'; });
    document.getElementById('loginClose')?.addEventListener('click', function(){ document.getElementById('loginModal').style.display='none'; });
    document.getElementById('registerClose')?.addEventListener('click', function(){ document.getElementById('registerModal').style.display='none'; });
  </script>
</body>
</html>`;

fs.writeFileSync(outPath, html, 'utf8');
console.log('Wrote', outPath);


