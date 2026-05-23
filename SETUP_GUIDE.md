# 🚀 Setup Guide - NexaNews

Panduan lengkap setup dan menjalankan NexaNews website berita.

---

## 📋 Prasyarat

Pastikan sudah install:
- PHP 8.2+ 
- Composer
- Node.js & npm (opsional, tapi recommended)
- Database (PostgreSQL/MySQL)

---

## 🔧 Step-by-Step Setup

### Step 1: Navigate ke Project
```bash
cd d:\malikussaleh\joki\nexanews-app
```

### Step 2: Install Dependencies
```bash
# Install PHP dependencies
composer install

# (Optional) Install node dependencies
npm install
```

### Step 3: Configure Environment
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Setup Database

Edit file `.env` dan sesuaikan database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nexanews_db
DB_USERNAME=root
DB_PASSWORD=
```

Atau untuk PostgreSQL:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nexanews_db
DB_USERNAME=postgres
DB_PASSWORD=password
```

### Step 5: Run Migrations
```bash
# Buat semua tables
php artisan migrate

# Jika ada error, refresh database
php artisan migrate:refresh
```

### Step 6: Seed Database (Create Initial Data)
```bash
# Buat admin user, kategori, dan sample articles
php artisan db:seed

# Atau:
php artisan migrate:fresh --seed
```

### Step 7: Link Storage (untuk upload gambar)
```bash
php artisan storage:link
```

### Step 8: Run Development Server
```bash
php artisan serve
```

Server akan berjalan di: **http://localhost:8000**

---

## 🔑 Default Credentials

Setelah seed, gunakan credentials ini untuk login:

### Admin Account
```
Email:    admin@nexanews.com
Password: admin123456
Role:     Admin
```

### Regular User Account
```
Email:    test@example.com
Password: password
Role:     User
```

---

## 🌐 URLs Penting

| Halaman | URL |
|---------|-----|
| Homepage | http://localhost:8000/ |
| Admin Dashboard | http://localhost:8000/admin/dashboard |
| Kelola Artikel | http://localhost:8000/admin/articles |
| Kelola Kategori | http://localhost:8000/admin/categories |
| Moderasi Komentar | http://localhost:8000/admin/comments |
| Kelola User | http://localhost:8000/admin/users |

---

## 📝 Quick Commands

```bash
# Start development server
php artisan serve

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Clear cache
php artisan cache:clear

# Create new model
php artisan make:model ModelName -m

# Create new controller
php artisan make:controller ControllerName

# Make model, migration, and controller
php artisan make:model Article -mc

# View all routes
php artisan route:list

# Run tests
php artisan test
```

---

## 📁 File Structure Overview

```
nexanews-app/
├── app/                    # Application code
├── database/              # Migrations & seeders
├── resources/views/       # Blade templates
├── routes/               # Route definitions
├── public/              # Public accessible files
├── storage/            # Uploaded files & cache
├── .env               # Environment configuration
├── DOKUMENTASI.md     # Full documentation
└── SETUP_GUIDE.md     # This file
```

---

## ✨ Project Features Checklist

- [x] Multi-user system (Admin & Pengunjung)
- [x] Full CRUD untuk Artikel
- [x] Full CRUD untuk Kategori
- [x] System Komentar dengan Moderasi
- [x] Like/Reaksi pada Artikel
- [x] Search Berita
- [x] Upload Gambar
- [x] Notifikasi untuk Admin
- [x] Dashboard Admin
- [x] Responsive Design
- [x] Professional UI dengan Tailwind CSS

---

## 🎨 Default Categories

Setelah seed, akan ada 3 kategori:
1. **Makanan** - Berita & tips seputar makanan
2. **Teknologi** - Perkembangan teknologi
3. **Pendidikan** - Informasi pendidikan

---

## 📸 Sample Articles

3 sample articles sudah dibuat di seeder:
1. "5 Resep Makanan Sehat untuk Diet Seimbang" (Kategori: Makanan)
2. "AI dan Machine Learning Mengubah Masa Depan" (Kategori: Teknologi)
3. "Panduan Lengkap Persiapan Ujian Nasional" (Kategori: Pendidikan)

---

## 🐛 Common Issues & Solutions

### Issue 1: SQLSTATE[HY000] - Database Connection Error
**Solution:**
```bash
# Check .env database configuration
# Make sure MySQL/PostgreSQL service is running
# Verify database credentials
php artisan migrate
```

### Issue 2: Gambar tidak tampil setelah upload
**Solution:**
```bash
# Run storage link
php artisan storage:link

# Check permissions
chmod -R 755 storage/app/public
```

### Issue 3: Route not found error
**Solution:**
```bash
# Clear route cache
php artisan route:clear

# View all routes
php artisan route:list
```

### Issue 4: CSRF token mismatch
**Solution:**
- Pastikan @csrf ada di semua form
- Check middleware order di bootstrap/app.php

### Issue 5: No supported encrypter found
**Solution:**
```bash
# Generate app key
php artisan key:generate

# Jika sudah ada:
php artisan key:generate --force
```

---

## 🔐 Security Checklist

Sebelum production:
- [ ] Set `APP_DEBUG=false` di `.env`
- [ ] Set `APP_ENV=production`
- [ ] Generate unique `APP_KEY`
- [ ] Setup HTTPS (SSL certificate)
- [ ] Restrict file permissions
- [ ] Configure backup database
- [ ] Setup proper logging
- [ ] Enable rate limiting
- [ ] Test all authentication flows
- [ ] Validate all forms properly

---

## 📚 File Descriptions

### Key Files Created

| File | Purpose |
|------|---------|
| `app/Models/*.php` | Database models with relationships |
| `app/Http/Controllers/*.php` | Request handlers & business logic |
| `app/Http/Middleware/AdminMiddleware.php` | Admin protection |
| `resources/views/layouts/app.blade.php` | Master template |
| `resources/views/home.blade.php` | Homepage |
| `resources/views/admin/dashboard.blade.php` | Admin dashboard |
| `routes/web.php` | All routes (publik & admin) |
| `database/migrations/*.php` | Database schema |
| `database/seeders/DatabaseSeeder.php` | Initial data |
| `DOKUMENTASI.md` | Full documentation |

---

## 🎯 Next Steps After Setup

1. **Login as Admin** dengan credentials di atas
2. **Explore Dashboard** - lihat statistik
3. **Create New Article** - test artikel creation
4. **Upload Gambar** - test image upload
5. **Create Kategori** - tambah kategori baru
6. **Test Frontend** - browse homepage, search, komentar

---

## 📞 Troubleshooting

Jika ada masalah:

1. **Check Error Log:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Run Diagnostics:**
   ```bash
   php artisan about
   ```

3. **Reset Everything:**
   ```bash
   php artisan migrate:refresh --seed
   php artisan cache:clear
   php artisan config:clear
   ```

4. **Clear Node Modules (if issues):**
   ```bash
   rm -rf node_modules
   npm install
   ```

---

## 🚀 Deployment

Untuk deployment ke production server:

```bash
# 1. Clone repository
git clone <repository> nexanews-app
cd nexanews-app

# 2. Install dependencies
composer install --no-dev
npm install --production

# 3. Setup environment
cp .env.production .env
php artisan key:generate

# 4. Database
php artisan migrate --force
php artisan db:seed --force

# 5. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Storage
php artisan storage:link
chmod -R 755 storage/app/public

# 7. Permissions
chown -R www-data:www-data .
chmod -R 775 storage/
```

---

## 📖 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com)
- [Blade Template Engine](https://laravel.com/docs/blade)
- [Eloquent ORM](https://laravel.com/docs/eloquent)

---

## ✅ Testing Checklist

- [ ] Homepage load correctly
- [ ] Can create article (admin)
- [ ] Can edit article (admin)
- [ ] Can delete article (admin)
- [ ] Can create kategori (admin)
- [ ] Can comment on article (visitor)
- [ ] Can like article (visitor)
- [ ] Can search articles
- [ ] Can filter by kategori
- [ ] Admin panel loads correctly
- [ ] Moderasi komentar works
- [ ] User management works
- [ ] Responsive on mobile
- [ ] Upload gambar works
- [ ] Logout works

---

## 🎉 You're All Set!

Project NexaNews siap digunakan. Selamat bermain dengan website berita profesional Anda!

**Questions?** Lihat DOKUMENTASI.md untuk detail lebih lanjut.

---

*Last Updated: May 23, 2026*
