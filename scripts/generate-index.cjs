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
                <div class="product-card">
                  <div class="product-badge">Giảm 10%</div>
                  <a href="#"><img src="" alt="Product" onerror="this.style.display='none'"><div class="product-info"><h3>iPhone 17 Pro</h3><div class="product-price"><span class="price-old">34,990,000₫</span><span class="price-new">30,990,000₫</span></div></div></a>
                </div>
                <div class="product-card">
                  <a href="#"><div class="product-placeholder">📱</div><div class="product-info"><h3>Laptop ABC</h3><div class="product-price"><span class="price-new">22,500,000₫</span></div></div></a>
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
</head>
<body>
  <div id="app">${bodyContent}</div>
  ${jsFile ? `<script type="module" src="/${jsFile}"></script>` : ''}
</body>
</html>`;

fs.writeFileSync(outPath, html, 'utf8');
console.log('Wrote', outPath);


