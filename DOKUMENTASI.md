# 📰 NexaNews - Website Berita Profesional

Website berita profesional yang dibangun dengan Laravel 11, Tailwind CSS, dan fitur-fitur lengkap untuk manajemen konten berita.

---

## 🎯 Fitur Utama

### 1. **Sistem Multi User**
- Admin: Mengelola konten, moderasi komentar, kelola user
- Pengunjung: Membaca berita, komentar, like tanpa login

### 2. **Autentikasi & Otorisasi**
- Login & Register (bawaan Laravel)
- Role-based access control (Admin/User)
- Middleware proteksi halaman admin
- Session-based tracking untuk pengunjung

### 3. **Manajemen Berita (CRUD Lengkap)**
- ✅ Create: Buat artikel baru dengan form validasi
- ✅ Read: Tampilkan artikel dengan paginasi
- ✅ Update: Edit artikel dengan upload gambar baru
- ✅ Delete: Hapus artikel dan gambarnya
- Status: Draft & Published
- Slug otomatis untuk SEO friendly URL
- Upload gambar dengan validasi

### 4. **Kategori Berita**
- CRUD kategori lengkap
- Relasi dengan berita
- Warna custom untuk setiap kategori

### 5. **Komentar**
- Pengunjung bisa komentar tanpa login
- Admin bisa moderasi (approve/reject)
- Sistem notifikasi untuk admin
- Anonymous comment support

### 6. **Like/Reaksi**
- Pengunjung bisa like tanpa login (via session)
- User login bisa like dengan akun
- Counter like real-time
- Prevent duplicate likes

### 7. **Frontend Profesional**
- Homepage dengan hero section & berita terbaru
- Detail berita lengkap dengan komentar
- Halaman kategori
- Search berita
- Sidebar trending articles
- Responsive design (mobile & desktop)

### 8. **Dashboard Admin**
- Statistik (jumlah berita, user, komentar)
- Kelola berita, kategori, user
- Moderasi komentar
- Notifikasi komentar baru
- Quick actions

### 9. **UI/UX Profesional**
- Tailwind CSS (CDN)
- Font Poppins Google Fonts
- Font Awesome icons
- Responsive grid layout
- Color scheme: Red (#c1121f) & Dark Blue (#0f172a)
- Sticky navbar dengan shadow
- Breaking news marquee
- Card-based design
- Smooth animations

---

## 📁 Struktur Project

```
nexanews-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php          # Frontend (home, detail, category, search)
│   │   │   ├── ArticleController.php       # CRUD artikel (admin only)
│   │   │   ├── CategoryController.php      # CRUD kategori (admin only)
│   │   │   ├── CommentController.php       # Manajemen komentar & moderasi
│   │   │   ├── LikeController.php          # Manajemen like
│   │   │   └── AdminController.php         # Dashboard & admin features
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php         # Middleware proteksi admin
│   │   └── Requests/
│   │       ├── StoreArticleRequest.php     # Validasi create artikel
│   │       └── UpdateArticleRequest.php    # Validasi update artikel
│   └── Models/
│       ├── User.php                        # User model + relasi
│       ├── Article.php                     # Artikel model + relasi + scope
│       ├── Category.php                    # Kategori model
│       ├── Comment.php                     # Komentar model
│       ├── Like.php                        # Like model
│       └── Notification.php                # Notifikasi model
├── database/
│   ├── migrations/
│   │   ├── *_add_role_to_users_table.php   # Migration tambah role & status
│   │   ├── *_create_categories_table.php   # Migration kategori
│   │   ├── *_create_articles_table.php     # Migration berita
│   │   ├── *_create_comments_table.php     # Migration komentar
│   │   ├── *_create_likes_table.php        # Migration like
│   │   └── *_create_notifications_table.php
│   └── seeders/
│       └── DatabaseSeeder.php              # Seed data (admin, kategori, artikel)
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php               # Layout utama (navbar, footer, css/js)
│       ├── home.blade.php                  # Homepage
│       ├── articles/
│       │   ├── index.blade.php             # Daftar artikel (admin)
│       │   ├── show.blade.php              # Detail berita + komentar
│       │   ├── create.blade.php            # Form buat artikel
│       │   └── edit.blade.php              # Form edit artikel
│       ├── categories/
│       │   ├── index.blade.php             # Daftar kategori (admin)
│       │   ├── show.blade.php              # Berita per kategori (frontend)
│       │   ├── create.blade.php            # Form buat kategori
│       │   └── edit.blade.php              # Form edit kategori
│       ├── admin/
│       │   ├── dashboard.blade.php         # Dashboard admin
│       │   ├── comments.blade.php          # Moderasi komentar
│       │   └── users.blade.php             # Kelola user
│       └── search-results.blade.php        # Hasil pencarian
├── routes/
│   └── web.php                             # Semua routes (publik & admin)
├── bootstrap/
│   └── app.php                             # Register middleware
└── README.md                               # (file ini)
```

---

## 🚀 Setup & Installation

### 1. **Clone Project**
```bash
cd d:\malikussaleh\joki\nexanews-app
```

### 2. **Install Dependencies**
```bash
composer install
npm install
```

### 3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

### 4. **Database Setup**
```bash
# Jalankan migrations
php artisan migrate

# Jalankan seeder untuk membuat data awal
php artisan db:seed
```

### 5. **Link Storage**
```bash
php artisan storage:link
```

### 6. **Run Development Server**
```bash
php artisan serve
```

Akses di: `http://localhost:8000`

---

## 👤 Default Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@nexanews.com | admin123456 |
| User | test@example.com | password |

---

## 📋 Database Schema

### Users Table
```sql
- id (PK)
- name
- email (UNIQUE)
- password
- role (enum: admin, user)
- status (enum: active, inactive)
- timestamps
```

### Categories Table
```sql
- id (PK)
- name (UNIQUE)
- slug (UNIQUE)
- description (nullable)
- color (default: #c1121f)
- timestamps
```

### Articles Table
```sql
- id (PK)
- user_id (FK → users)
- category_id (FK → categories)
- title
- slug (UNIQUE)
- content
- image (nullable)
- status (enum: draft, published)
- published_at (nullable)
- views (default: 0)
- timestamps
- indexes: category_id, user_id, status
```

### Comments Table
```sql
- id (PK)
- article_id (FK → articles)
- user_id (FK → users, nullable)
- name (nullable - untuk anonymous)
- email (nullable - untuk anonymous)
- content
- status (enum: pending, approved, rejected)
- timestamps
- indexes: article_id, user_id, status
```

### Likes Table
```sql
- id (PK)
- article_id (FK → articles)
- session_id (nullable - untuk pengunjung tanpa login)
- user_id (FK → users, nullable)
- unique: [article_id, session_id, user_id]
- index: article_id
```

### Notifications Table
```sql
- id (PK)
- user_id (FK → users)
- comment_id (FK → comments)
- type (string)
- message
- read (boolean)
- timestamps
- indexes: user_id, read
```

---

## 🗂️ Model Relasi

```
User (1) ──┬─→ (Many) Article
           ├─→ (Many) Comment
           ├─→ (Many) Like
           └─→ (Many) Notification

Category (1) ──→ (Many) Article

Article (1) ──┬─→ (Many) Comment
              └─→ (Many) Like

Comment (1) ──→ (Many) Notification
```

---

## 🛣️ Routes Overview

### Public Routes
```
GET  /                          → Home
GET  /search?q=keyword          → Search
GET  /category/{slug}           → Kategori
GET  /articles/{slug}           → Detail berita
POST /articles/{id}/comments    → Tambah komentar
POST /articles/{id}/like        → Toggle like
GET  /articles/{id}/likes-count → Get likes count
```

### Admin Routes (`/admin/...` - Require auth + admin role)
```
GET    /admin/dashboard              → Dashboard
GET    /admin/articles               → Daftar artikel
GET    /admin/articles/create        → Form buat artikel
POST   /admin/articles               → Store artikel
GET    /admin/articles/{id}/edit     → Form edit artikel
PUT    /admin/articles/{id}          → Update artikel
DELETE /admin/articles/{id}          → Hapus artikel

GET    /admin/categories             → Daftar kategori
GET    /admin/categories/create      → Form buat kategori
POST   /admin/categories             → Store kategori
GET    /admin/categories/{id}/edit   → Form edit kategori
PUT    /admin/categories/{id}        → Update kategori
DELETE /admin/categories/{id}        → Hapus kategori

GET    /admin/comments               → Moderasi komentar
PATCH  /admin/comments/{id}/approve  → Approve komentar
PATCH  /admin/comments/{id}/reject   → Reject komentar
DELETE /admin/comments/{id}          → Hapus komentar

GET    /admin/users                  → Kelola user
PATCH  /admin/users/{id}/role        → Update role user

PATCH  /admin/notifications/{id}/read      → Mark read
PATCH  /admin/notifications/read-all       → Mark all read
```

---

## ✨ Fitur Spesial

### 1. **Slug Otomatis**
```php
// Model Article memiliki event boot
// Slug otomatis generate dari title
// Format: "Hello World" → "hello-world"
// Unique constraint untuk URL SEO friendly
```

### 2. **Session-Based Like**
```php
// Pengunjung tanpa login: gunakan session_id
// User login: gunakan user_id
// Prevent duplicate likes dari orang sama
```

### 3. **Anonymous Comment**
```php
// Pengunjung bisa komentar tanpa login
// Simpan name & email untuk tracking
// Admin bisa moderasi sebelum tampil
```

### 4. **Views Counter**
```php
// Increment otomatis saat artikel dibuka
// Track popularitas artikel
// Gunakan untuk sorting trending
```

### 5. **Notifikasi Admin**
```php
// Auto-create notifikasi saat ada komentar baru
// Kirim ke semua admin
// Mark as read functionality
```

### 6. **Search & Filter**
```php
// Full-text search di title & content
// Filter by status, category
// Search scope di model Article
```

---

## 🎨 UI/UX Details

### Navbar
- ✅ Logo "NexaNews" di kiri
- ✅ Menu: Home, Makanan, Teknologi, Pendidikan
- ✅ Menu aktif berwarna merah dengan underline
- ✅ Icon search di kanan (dropdown modal)
- ✅ Sticky dengan shadow halus
- ✅ Dropdown user menu untuk login/logout

### Breaking News
- ✅ Bar warna merah di bawah navbar
- ✅ Teks berjalan (marquee animation)
- ✅ Badge "🔴 BERITA TERKINI"

### Hero Section
- ✅ Full-width gambar
- ✅ Overlay gelap untuk readability
- ✅ Badge kategori warna merah
- ✅ Judul besar tebal (48px font)
- ✅ Deskripsi singkat + CTA button
- ✅ Teks positioned di bawah kiri
- ✅ Responsive (32px mobile)

### Main Layout
- ✅ Grid 3 kolom: 2 konten + 1 sidebar
- ✅ Berita dalam grid 2 kolom
- ✅ Responsive breakpoint di mobile

### Card Berita
- ✅ Gambar di atas
- ✅ Kategori badge merah kecil
- ✅ Judul tebal 18px
- ✅ Meta: penulis & tanggal abu kecil
- ✅ Hover effect: translate up + shadow
- ✅ Rounded corners 12px

### Sidebar
- **Trending:**
  - 1 gambar utama
  - Judul berita
  - List ranking 1,2,3 dengan views
  
- **Kategori:**
  - Bentuk tag rounded
  - Background abu
  - Hover change warna merah
  
- **Umpan Balik:**
  - Background biru gelap (#0f172a)
  - Text putih
  - Textarea + email input
  - Button merah "KIRIM"

### Button Style
- ✅ Primary: merah solid
- ✅ Outline: border merah, transparent bg
- ✅ Hover effect: change warna/background
- ✅ Smooth transition

### Footer
- ✅ Background biru gelap
- ✅ Grid 3 kolom info
- ✅ Logo NexaNews
- ✅ Copyright notice
- ✅ Menu links

### Responsive
- ✅ Mobile-first approach
- ✅ Breakpoint: md (768px), lg (1024px)
- ✅ Grid 1 kolom mobile → 2 kolom tablet → 3 kolom desktop

---

## 🔐 Security Features

1. **CSRF Protection**
   - Token di semua form
   - Middleware built-in Laravel

2. **Authorization**
   - Middleware check role
   - Policy untuk resource ownership
   - Cannot edit/delete article orang lain

3. **Input Validation**
   - Form Request classes
   - Validasi server-side
   - Custom error messages

4. **File Upload Security**
   - Validasi MIME type (jpeg, png, jpg, gif)
   - Max file size 5MB
   - Store di `/storage/articles/`
   - Public disk untuk akses URL

5. **XSS Prevention**
   - Escape output di blade
   - Use `{!! !!}` hanya untuk trusted content
   - Sanitize user input

---

## 📝 Contoh Usage

### Create Artikel
```php
// Admin bisa buat via form
// Atau programmatic:
Article::create([
    'user_id' => auth()->id(),
    'category_id' => 1,
    'title' => 'Judul Berita',
    'content' => 'Isi berita...',
    'image' => 'path/to/image.jpg',
    'status' => 'published',
    'published_at' => now(),
]);
// Slug otomatis tergenerate dari title
```

### Query Scope Example
```php
// Get hanya published articles
$articles = Article::published()->get();

// Get latest articles
$articles = Article::latest()->paginate(10);

// Search artikel
$articles = Article::search('keyword')->get();

// Get dengan relasi
$articles = Article::with('category', 'user')->get();
```

### Comment Moderation
```php
// Approve komentar
$comment->update(['status' => 'approved']);

// Get pending comments
$comments = Comment::pending()->get();

// Get approved comments di artikel
$comments = $article->comments()->approved()->get();
```

---

## 🐛 Troubleshooting

### 1. Gambar tidak tampil
```bash
# Link storage jika belum ada
php artisan storage:link

# Check permissions
chmod -R 755 storage/app/public
```

### 2. Migration error
```bash
# Refresh database
php artisan migrate:refresh --seed

# Atau check migration conflicts
php artisan migrate:status
```

### 3. CSS/JS tidak load
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear

# Tailwind bisa langsung dari CDN
# Tidak perlu npm build
```

### 4. Login tidak bekerja
```bash
# Generate app key
php artisan key:generate

# Check .env configuration
# DB_CONNECTION, DB_HOST, DB_PORT, etc
```

---

## 📚 Best Practices yang Digunakan

1. **MVC Architecture**
   - Model: Business logic & database
   - View: Template blade
   - Controller: Handle request/response

2. **RESTful Conventions**
   - Resource controller
   - Proper HTTP methods
   - RESTful naming

3. **DRY Principle**
   - Reusable layout
   - Components & partials
   - Query scopes

4. **Separation of Concerns**
   - Form Requests untuk validasi
   - Middleware untuk auth
   - Controllers untuk logic

5. **Code Comments**
   - Setiap class ada PHPDoc
   - Setiap method ada comment
   - Inline comment untuk logic kompleks

---

## 🚢 Deployment Checklist

- [ ] Set `.env` production values
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Enable HTTPS
- [ ] Setup database di production
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Run seeder: `php artisan db:seed --force`
- [ ] Link storage: `php artisan storage:link`
- [ ] Setup proper file permissions
- [ ] Enable error logging
- [ ] Setup backup strategy

---

## 📖 Dokumentasi Lengkap

Setiap file code sudah ada komentar untuk penjelasan:
- Model: Business logic & relationships
- Controller: Route handling & response
- Migration: Database schema
- Blade view: Frontend template
- Route: API endpoints

---

## 📞 Support & Contact

**Admin Login:**
- Email: admin@nexanews.com
- Password: admin123456

**Default Kategori:**
- Makanan
- Teknologi
- Pendidikan

**Sample Data:**
- 2 Users (admin + regular)
- 3 Categories
- 3 Sample Articles

---

## 📄 License

Created by Development Team - 2026

---

**Happy News Sharing! 📰✨**
