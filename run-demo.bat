@echo off
echo Menyiapkan Laravel Demo...

composer install
npm install
npm run build
php artisan key:generate
php artisan migrate
php artisan serve

# 1. Install dependency Laravel
composer install

# 2. Install dependency frontend
npm install

# 3. Build asset CSS/JS (WAJIB untuk Vite)
npm run build

# 4. Generate key Laravel
php artisan key:generate

# 5. Jalankan migrasi database
php artisan migrate

# 6. Jalankan aplikasi
php artisan serve
