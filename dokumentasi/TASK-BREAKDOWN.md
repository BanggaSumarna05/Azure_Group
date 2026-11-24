# Task Breakdown — azuregroup.co.id
## Laravel 11 + Inertia.js + Vue 3

| | |
|---|---|
| **Dokumen** | TASK-2026-AZURE-001 |
| **Versi** | 1.0 |
| **Tanggal** | 24 Juni 2026 |
| **Author** | ProudTech.id |

---

## Overview

Total estimasi: **~5 minggu** (1 developer full-time)
Total task: **7 Phase**, dibagi menjadi task atomik yang dapat dikerjakan per-sesi.

---

## Phase 1 — Project Setup & Foundation
**Durasi estimasi: 5 hari**

### 1.1 Laravel Project Init
- [ ] `composer create-project laravel/laravel azuregroup` (Laravel 11)
- [ ] Setup `.env`: DB credentials, APP_URL, MAIL config
- [ ] Init Git repo, buat `.gitignore` yang proper (exclude `/public/storage`, `.env`)
- [ ] Setup `php artisan key:generate`

### 1.2 Package Installation
- [ ] `composer require inertiajs/inertia-laravel`
- [ ] `composer require tightenco/ziggy`
- [ ] `composer require filament/filament:"^3.3" -W`
- [ ] `composer require spatie/laravel-medialibrary:"^11.0"`
- [ ] `composer require spatie/laravel-sitemap`
- [ ] `composer require artesaos/seotools`
- [ ] `composer require barryvdh/laravel-debugbar --dev`
- [ ] `npm install` + setup Vite + Tailwind CSS 3.x
- [ ] `npm install @inertiajs/vue3 vue@3`
- [ ] Publish Inertia middleware: `php artisan inertia:middleware`
- [ ] Install Filament: `php artisan filament:install --panels`

### 1.3 Database Migrations
- [ ] Migration: `create_categories_table`
- [ ] Migration: `create_posts_table` (FK → categories, users)
- [ ] Migration: `create_portfolios_table`
- [ ] Migration: `create_leaders_table`
- [ ] Migration: `create_careers_table`
- [ ] Migration: `create_settings_table`
- [ ] Publish Spatie Media Library migration: `php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"`
- [ ] `php artisan migrate`

### 1.4 Models
- [ ] `Post.php` — fillable, casts, scopes (published), relations (category, author), accessor cover_url
- [ ] `Category.php` — fillable, relation hasManyPosts
- [ ] `Portfolio.php` — fillable, casts, scopes (active, ordered), HasMedia
- [ ] `Leader.php` — fillable, casts, scopes (active, ordered), HasMedia
- [ ] `Career.php` — fillable, casts, scopes (open)
- [ ] `Setting.php` — fillable, static `get()` helper

### 1.5 Auth & Admin Panel
- [ ] Setup Filament admin user: `php artisan make:filament-user`
- [ ] Konfigurasi Filament panel di `AdminPanelProvider.php`
- [ ] Setup prefix `/admin`, warna brand, logo Azure Group
- [ ] Test login ke `/admin`

### 1.6 Base Layout & Inertia Bootstrap
- [ ] Buat `resources/views/app.blade.php` (Inertia root template + Ziggy)
- [ ] Buat `resources/js/app.js` (Inertia createInertiaApp + Vue)
- [ ] Buat `resources/css/app.css` (Tailwind directives + custom CSS vars)
- [ ] Konfigurasi `vite.config.js`
- [ ] Test `npm run dev` — pastikan tidak ada error build

### 1.7 Shared Data & Middleware
- [ ] Buat `SettingService.php` (cache semua settings)
- [ ] Update `HandleInertiaRequests.php` → share `settings` dan `flash`
- [ ] Buat `SecurityHeaders.php` middleware → register di `bootstrap/app.php`
- [ ] Buat `RedirectLegacyUrls.php` middleware → register ke route group

### 1.8 Database Seeder
- [ ] Buat `SettingSeeder.php` dengan data default (company info, social URLs, video URLs)
- [ ] Jalankan seeder: `php artisan db:seed`

---

## Phase 2 — Frontend Static Pages
**Durasi estimasi: 7 hari**

### 2.1 Component Shared
- [ ] Buat `Layouts/AppLayout.vue` (wrapper dengan Navbar + Footer slot)
- [ ] Buat `Components/Navbar.vue`:
  - Logo link ke `/`
  - Navigation links (Home, About, Portfolio, Leadership, Career, Blog)
  - Dropdown "About Us" → About Us + Our Value
  - Hamburger menu mobile (Tailwind)
  - Sticky/fixed + active state via `$page.url`
- [ ] Buat `Components/Footer.vue`:
  - 5 kolom (Useful Links, Follow Us, Get in Touch, Information, Our Location)
  - Dynamic dari `$page.props.settings`
  - Copyright dengan `new Date().getFullYear()`
- [ ] Buat `Components/HeroVideo.vue`:
  - Props: `src`, `poster`
  - autoplay, muted, loop, preload="auto"
  - Fallback ke poster jika src kosong
- [ ] Buat `Components/ui/Button.vue` (variant: primary, outline)
- [ ] Buat `Components/ui/Badge.vue` (untuk kategori/tipe)
- [ ] Buat `Components/ui/Card.vue` (reusable card wrapper)

### 2.2 Page: Homepage (`Pages/Home.vue`)
- [ ] Section 1: Hero Video (HeroVideo component + overlay tagline + CTA "Discover More")
- [ ] Section 2: "6 Years" section (video kedua sebagai background/parallax + narasi)
- [ ] Section 3: Partnership/Stats section (CTA → `/portfolio`)
- [ ] Section 4: Footer navigation pills/dots
- [ ] Integrasikan `video_hero_1` dan `video_hero_2` dari `settings`
- [ ] Edge case: jika setting kosong → fallback poster image

### 2.3 Page: About Us (`Pages/About.vue`)
- [ ] Hardcoded content: company background, tahun berdiri 2019, fokus bisnis
- [ ] CTA ke `/about/our-value`
- [ ] SEO: title "About Us | Azure Group", description

### 2.4 Page: Our Value (`Pages/OurValue.vue`)
- [ ] Hardcoded content: list nilai perusahaan (Integrity, Excellence, Partnership, Sustainability)
- [ ] Visual: card atau icon per nilai
- [ ] SEO meta

### 2.5 Page: Leadership (`Pages/Leadership.vue`)
- [ ] Grid foto + nama + jabatan (data dari props `leaders`)
- [ ] Hover effect: tampilkan bio singkat (tooltip/expand)
- [ ] LinkedIn icon → buka profil jika `linkedin_url` terisi
- [ ] Edge case: photo kosong → avatar inisial nama
- [ ] Buat `LeadershipController@index` → query `Leader::active()->ordered()`
- [ ] SEO meta

### 2.6 Page: Cyber Security (`Pages/CyberSecurity.vue`)
- [ ] Hardcoded content: informasi keamanan siber
- [ ] SEO meta
- [ ] Buat `PageController@cybersecurity`

### 2.7 SEO Integration
- [ ] Install artesaos/seotools, konfigurasi `config/seotools.php`
- [ ] Buat `SeoService.php` (setPage, setPost methods)
- [ ] Update `app.blade.php` → render SEO tags dari artesaos
- [ ] Implementasi di setiap controller (static pages)

---

## Phase 3 — Frontend Dinamis
**Durasi estimasi: 7 hari**

### 3.1 Portfolio
- [ ] Buat `PortfolioController` (`index`, `show`)
- [ ] `Pages/Portfolio/Index.vue`:
  - Grid semua portfolio aktif
  - Card: logo, nama, sektor, tagline, tombol "View Detail"
  - Empty state jika tidak ada data
- [ ] `Pages/Portfolio/Show.vue`:
  - Hero: cover image + nama + sektor
  - Deskripsi lengkap (HTML via `v-html`)
  - Link website subsidiary (target="_blank")
  - Tombol back ke `/portfolio`
  - SEO dinamis (per portfolio)
- [ ] Edge case: slug tidak ditemukan → 404; `is_active = false` → 404

### 3.2 Career
- [ ] Buat `CareerController` (`index`, `show`, `apply`)
- [ ] `Pages/Career/Index.vue`:
  - List lowongan aktif (sorted `published_at DESC`)
  - Filter by `type` via query param (optional)
  - Card: judul, departemen, tipe badge, lokasi, deadline, CTA "Apply Now"
  - Empty state jika tidak ada lowongan
- [ ] `Pages/Career/Show.vue`:
  - Detail posisi: judul, departemen, tipe, lokasi, deadline
  - Deskripsi + kualifikasi (HTML via `v-html`)
  - Form apply di bawah konten:
    - Nama Lengkap (required)
    - Email (required, valid)
    - No. HP (required)
    - Pesan (optional, textarea)
    - Upload CV (required, PDF only, max 5MB)
  - Inline validation error per field (via Inertia `useForm`)
  - Flash success message setelah submit
- [ ] `CareerController@apply`: validasi → simpan CV → kirim email → redirect with flash
- [ ] Buat `CareerApplicationMail.php` Mailable
- [ ] Rate limiting: 5 request/menit per IP di route POST
- [ ] Edge case: career tidak ditemukan/ditutup → 404

### 3.3 Blog
- [ ] Buat `BlogController` (`index`, `show`)
- [ ] Buat `PostResource.php` (API Resource untuk transformasi data)
- [ ] `Pages/Blog/Index.vue`:
  - Grid artikel published, 9 per halaman (paginate)
  - Card: cover image, kategori badge, judul, excerpt, tanggal publish
  - Filter by kategori via query param `?category=slug`
  - Inertia pagination component
  - Empty state jika tidak ada artikel
  - Fallback cover → OG image default
- [ ] `Pages/Blog/Show.vue`:
  - Hero: cover image full-width + judul + meta (kategori, tanggal, author)
  - Body HTML (`v-html`, sudah sanitized di backend)
  - Related posts: 3 artikel dari kategori yang sama
  - Breadcrumb: Home > Blog > [Judul]
  - SEO dinamis dari post data
- [ ] Edge case: slug tidak ditemukan/draft → 404

### 3.4 Routes
- [ ] Daftarkan semua routes di `routes/web.php` sesuai SDD Section 5
- [ ] Test semua routes dengan `php artisan route:list`

---

## Phase 4 — Filament Admin Panel
**Durasi estimasi: 4 hari**

### 4.1 Filament Plugins
- [ ] `composer require filament/spatie-laravel-media-library-plugin`
- [ ] `composer require awcodes/filament-tiptap-editor`
- [ ] Publish config: `php artisan vendor:publish --tag=filament-tiptap-editor-config`

### 4.2 Resources
- [ ] Buat `CategoryResource` — CRUD (nama, slug auto-gen)
- [ ] Buat `PostResource`:
  - Form: title, slug (auto dari title), category, excerpt, body (TiptapEditor), cover image (Spatie), published_at (draft jika null)
  - Table: title, category badge, status published, tanggal
  - Filter by category, sort default by created_at desc
- [ ] Buat `PortfolioResource`:
  - Form: name, slug, tagline, description, sector, logo, cover image, website_url, sort_order, is_active toggle
  - Table: logo thumbnail, name, sector, is_active badge, sort_order
  - Reorderable rows via sort_order
- [ ] Buat `LeaderResource`:
  - Form: name, position, bio, photo (Spatie), linkedin_url, sort_order, is_active
  - Table: photo thumbnail, name, position, is_active
  - Reorderable
- [ ] Buat `CareerResource`:
  - Form: title, department, type (dropdown enum), location, description (TiptapEditor), deadline, published_at, is_active toggle
  - Table: title, department, type badge, deadline, status
- [ ] Buat `SettingResource`:
  - Key-value editor (all settings keys)
  - Kelompokkan: Company Info, Social Media, Video URLs, SEO

### 4.3 Navigation Groups
- [ ] Group "Konten": Post, Category, Portfolio, Leader
- [ ] Group "Karir": Career
- [ ] Group "Konfigurasi": Setting

---

## Phase 5 — Migrasi Konten
**Durasi estimasi: 3 hari**

### 5.1 WordPress Export
- [ ] Export konten dari WordPress: Admin → Tools → Export → All Content
- [ ] Download semua media dari `/wp-content/uploads/` via FTP

### 5.2 Import Command
- [ ] Buat `app/Console/Commands/ImportWordpress.php`:
  - Parse `<item>` dari XML
  - Map `post_type: 'post'` → Post model
  - Auto-generate slug dari `post_name`
  - Skip pages (rebuild manual)
- [ ] Test import di environment lokal: `php artisan wp:import --file=wordpress-export.xml`
- [ ] Verifikasi data: jumlah post, kategori, konten

### 5.3 Media Import
- [ ] Upload video hero ke CDN (Cloudflare R2 / BunnyCDN)
- [ ] Update `video_hero_1` dan `video_hero_2` di Settings
- [ ] Upload foto leadership ke Spatie Media Library
- [ ] Upload logo dan cover image portfolio
- [ ] Konversi foto-foto ke format WebP
- [ ] Verifikasi semua gambar tampil di frontend

### 5.4 Verifikasi Manual
- [ ] Cek setiap halaman: konten, gambar, link internal
- [ ] Test video autoplay di desktop dan mobile
- [ ] Cek footer links dan social media links

---

## Phase 6 — SEO, Redirect & Technical
**Durasi estimasi: 3 hari**

### 6.1 301 Redirects
- [ ] Test semua redirect via `RedirectLegacyUrls` middleware
- [ ] Verifikasi dengan browser: `/?page_id=4194` → `/about` (301)
- [ ] Verifikasi semua 7 page_id redirects

### 6.2 Sitemap
- [ ] Konfigurasi sitemap generation di `routes/console.php` (scheduler weekly)
- [ ] Generate sitemap manual: `php artisan schedule:run` atau via command
- [ ] Verifikasi `/sitemap.xml` valid
- [ ] Submit ke Google Search Console

### 6.3 robots.txt
- [ ] Buat `public/robots.txt`:
  ```
  User-agent: *
  Allow: /
  Disallow: /admin
  Sitemap: https://azuregroup.co.id/sitemap.xml
  ```

### 6.4 JSON-LD Schema
- [ ] Tambahkan JSON-LD `Organization` schema di `Home.vue` (hardcoded atau dari settings)

### 6.5 Security
- [ ] Verifikasi `SecurityHeaders` middleware berjalan: cek di browser DevTools
- [ ] Test di `securityheaders.com`
- [ ] Pastikan `.env` tidak accessible dari public
- [ ] Test HTTPS redirect

---

## Phase 7 — QA, Optimasi & Deployment
**Durasi estimasi: 4 hari**

### 7.1 QA Fungsional
- [ ] Cek semua 11 halaman publik: tidak ada 404/500
- [ ] Test Career form: submit valid, validasi error, rate limiting
- [ ] Test email notifikasi Career diterima
- [ ] Test Filament CRUD semua resource
- [ ] Test filter blog by kategori
- [ ] Test pagination blog
- [ ] Test responsif: mobile 375px, tablet 768px, desktop 1440px

### 7.2 Performance Optimasi
- [ ] `npm run build` — cek bundle size
- [ ] Aktifkan lazy loading semua gambar (`loading="lazy"`)
- [ ] Pastikan video tidak blocking LCP (load setelah above-fold content)
- [ ] Optimasi gambar: konversi ke WebP, kompresi
- [ ] Aktifkan Laravel route/config cache: `php artisan optimize`
- [ ] Test Lighthouse di homepage target ≥ 85 Performance, ≥ 95 SEO

### 7.3 Cross-Browser Test
- [ ] Chrome (desktop + mobile)
- [ ] Safari (desktop + iOS)
- [ ] Firefox
- [ ] Edge

### 7.4 Deployment
- [ ] Setup server: PHP 8.2+, MySQL 8.x, Node.js untuk build
- [ ] Upload code via Git atau SFTP
- [ ] `composer install --no-dev --optimize-autoloader`
- [ ] `npm run build`
- [ ] `php artisan migrate --force`
- [ ] `php artisan db:seed` (jika fresh install)
- [ ] `php artisan storage:link`
- [ ] `php artisan optimize`
- [ ] Setup cron untuk Laravel Scheduler (sitemap weekly)
- [ ] DNS switch ke server baru
- [ ] Monitor 48 jam pertama
- [ ] Keep WordPress live di server lama selama 48 jam sebagai fallback

---

## Dependency Map

```
Phase 1 (Setup)
  └─► Phase 2 (Static Frontend) — butuh Layout, Middleware, Settings
  └─► Phase 4 (Filament) — butuh Models & Migrations
Phase 2 + Phase 4
  └─► Phase 3 (Dinamis Frontend) — butuh Controllers & Filament Resources
Phase 3
  └─► Phase 5 (Import Konten)
Phase 1–5
  └─► Phase 6 (SEO & Technical)
Phase 1–6
  └─► Phase 7 (QA & Deployment)
```

---

*TASK-2026-AZURE-001 | v1.0 | 24 Juni 2026 | ProudTech.id*
