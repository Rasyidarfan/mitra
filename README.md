# 📊 Aplikasi Manajemen Mitra BPS

Aplikasi web untuk mengelola mitra BPS dalam berbagai kegiatan statistik. Memudahkan manajemen mitra, survei, dan penugasan secara efisien.

### 👥 Manajemen Mitra
- Pendaftaran dan pengelolaan data mitra
- Riwayat keterlibatan mitra dalam kegiatan
- Statistik aktivitas mitra
- Upload data mitra via Excel

### 📋 Manajemen Kegiatan
- Pencatatan kegiatan statistik
- Penugasan mitra ke kegiatan
- Pengaturan penanggung jawab
- Monitor progress kegiatan

### 👤 Manajemen User
- Multi-role system (Admin, Kepala, Tim Teknis)
- Pembagian akses berdasarkan fungsi
- Penanggung jawab kegiatan

## 🚀 Teknologi

- Laravel 11
- MySQL Database
- Tailwind CSS
- Alpine.js

## 📱 Screenshot
[Tambahkan screenshot aplikasi di sini]

## 📦 Instalasi

```bash
# Clone repository
git clone https://github.com/Rasyidarfan/manajemen-mitra.git

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations and seeders
php artisan migrate:fresh --seed

# Jalankan aplikasi
php artisan serve
npm run dev
```
