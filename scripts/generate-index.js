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

const html = `<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Anhkiet Store</title>
  ${cssFile ? `<link rel="stylesheet" href="/assets/${cssFile}" />` : ''}
</head>
<body>
  <div id="app"></div>
  ${jsFile ? `<script type="module" src="/assets/${jsFile}"></script>` : ''}
</body>
</html>`;

fs.writeFileSync(outPath, html, 'utf8');
console.log('Wrote', outPath);


