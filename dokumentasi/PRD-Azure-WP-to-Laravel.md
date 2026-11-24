# PRD — Migrasi azuregroup.co.id
## WordPress → Laravel 11 + Inertia.js + Vue 3

| | |
|---|---|
| **Dokumen** | PRD-2026-AZURE-001 |
| **Klien** | Azure Investama Group |
| **Versi** | 1.0 |
| **Tanggal** | 24 Juni 2026 |
| **Author** | ProudTech.id |
| **Status** | Draft |

---

## Daftar Isi

1. [Ringkasan Eksekutif](#1-ringkasan-eksekutif)
2. [Latar Belakang & Masalah](#2-latar-belakang--masalah)
3. [Scope Proyek](#3-scope-proyek)
4. [Tech Stack & Arsitektur](#4-tech-stack--arsitektur)
5. [Database Schema](#5-database-schema)
6. [Halaman & Route Structure](#6-halaman--route-structure)
7. [Admin Panel — Filament v3](#7-admin-panel--filament-v3)
8. [SEO Requirements](#8-seo-requirements)
9. [Target Performa](#9-target-performa)
10. [Rencana Migrasi Konten](#10-rencana-migrasi-konten)
11. [Timeline & Milestone](#11-timeline--milestone)
12. [Acceptance Criteria](#12-acceptance-criteria)
13. [Risiko & Mitigasi](#13-risiko--mitigasi)
14. [Dependencies & Asumsi](#14-dependencies--asumsi)

---

## 1. Ringkasan Eksekutif

Dokumen ini mendefinisikan kebutuhan produk untuk migrasi website korporat **Azure Investama Group** dari WordPress ke **Laravel 11 + Inertia.js + Vue 3**.

Website [azuregroup.co.id](https://azuregroup.co.id/) berfungsi sebagai representasi digital utama Azure Group sebagai perusahaan holding di sektor industrial dan infrastruktur Indonesia. Dengan migrasi ke Laravel, tim pengembang memiliki kontrol penuh atas codebase, menghilangkan ketergantungan pada plugin WordPress pihak ketiga, dan membuka ruang untuk custom feature development jangka panjang.

**Tujuan utama:**
- Performa lebih baik (target Lighthouse Performance ≥ 85)
- Keamanan lebih kuat (tidak ada WordPress attack surface)
- Maintainability — full control atas kode, tidak bergantung pada plugin berbayar
- CMS modern berbasis Filament v3 untuk manajemen konten
- URL structure yang clean dan SEO-friendly

---

## 2. Latar Belakang & Masalah

### 2.1 Kondisi Saat Ini

| Aspek | Detail |
|---|---|
| Platform | WordPress + Avada Theme + Slider Revolution |
| URL Structure | Query-based (`?page_id=xxxx`) — tidak SEO-friendly |
| Media | `/wp-content/uploads/` self-hosted, belum CDN |
| Admin | WordPress Dashboard + Avada Page Builder |
| Bahasa | Inggris |

### 2.2 Pain Points

- **Plugin lock-in** — Avada + Slider Revolution berbayar tahunan, sulit diganti
- **URL buruk** — `?page_id=4194` tidak bisa dijadikan permalink yang clean
- **Performa berat** — WordPress overhead + banyak JS/CSS plugin yang tidak dioptimasi
- **Keamanan** — WordPress adalah target serangan yang sangat umum (brute force, plugin vuln)
- **No version control** — tidak ada git flow yang proper untuk konfigurasi/konten
- **Sulit dikembangkan** — custom feature butuh plugin atau modifikasi PHP yang fragile

---

## 3. Scope Proyek

### 3.1 Dalam Scope

| Halaman / Fitur | Deskripsi | Tipe |
|---|---|---|
| Homepage | Hero video, scroll section, partnership section, stats | Static Template |
| About Us | Company overview, milestones, nilai perusahaan | Static Template |
| Our Value | Halaman nilai dan prinsip perusahaan | Static Template |
| Portfolio | Daftar anak perusahaan/investasi, detail per item | **Dinamis (CMS)** |
| Leadership | Profil tim manajemen, foto, jabatan, bio | **Dinamis (CMS)** |
| Career | Daftar lowongan, detail posisi, form apply | **Dinamis (CMS)** |
| Blog | Listing artikel, single post, kategori/tag | **Dinamis (CMS)** |
| Cyber Security Info | Halaman informasi static | Static Template |
| Footer | Contact info, social links, navigation | Partial CMS |
| Admin Panel (Filament) | CRUD untuk semua konten dinamis | Backend |
| SEO & Redirect | 301 redirect, meta tags, sitemap XML | Backend |
| Import Konten | Script import dari WordPress XML export | One-time |

### 3.2 Luar Scope

- Redesain visual — tampilan mengikuti website WordPress yang sudah ada
- Fitur e-commerce atau payment gateway
- Multi-language (hanya Bahasa Inggris)
- Aplikasi mobile
- Integrasi sistem eksternal (CRM, HR, ERP)

---

## 4. Tech Stack & Arsitektur

### 4.1 Stack Utama

| Layer | Teknologi | Versi |
|---|---|---|
| Backend | Laravel | 11.x |
| Frontend (SPA) | Inertia.js + Vue | 1.x + 3.x |
| Styling | Tailwind CSS | 3.x |
| Build Tool | Vite | latest |
| Admin Panel | Filament | 3.x |
| Media Library | Spatie Media Library | 11.x |
| Sitemap | Spatie Laravel Sitemap | latest |
| Database | MySQL | 8.x |
| Cache / Queue | Redis (opsional) | — |
| Server | Shared Hosting / VPS (Azure-based) | PHP 8.2+ |

### 4.2 Arsitektur

```
Browser
  └─► Laravel Router
        └─► Controller
              └─► Inertia::render('PageName', $props)
                    └─► Vue 3 Component (SSR-ready)
                          └─► Hydrated di browser

/admin
  └─► Filament Panel
        └─► Resource (CRUD)
              └─► Eloquent Model
                    └─► MySQL
```

Pattern: **Monolith** dengan Inertia.js sebagai jembatan. Tidak ada REST API publik dalam scope ini.

### 4.3 Package Laravel yang Diperlukan

```bash
# Core
composer require inertiajs/inertia-laravel
composer require tightenco/ziggy                  # route helper di Vue

# Admin
composer require filament/filament

# Media & SEO
composer require spatie/laravel-medialibrary
composer require spatie/laravel-sitemap
composer require artesaos/seotools              # meta tags helper

# Dev
composer require barryvdh/laravel-debugbar --dev
```

---

## 5. Database Schema

### 5.1 `posts` — Blog

```sql
id              BIGINT PK AUTO_INCREMENT
title           VARCHAR(255)
slug            VARCHAR(255) UNIQUE
excerpt         TEXT NULL
body            LONGTEXT                  -- HTML dari rich text editor
category_id     FK → categories.id
cover_image     VARCHAR(255) NULL         -- path via Spatie Media
published_at    TIMESTAMP NULL            -- NULL = draft
author_id       FK → users.id
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### 5.2 `categories` — Kategori Blog

```sql
id              BIGINT PK AUTO_INCREMENT
name            VARCHAR(255)
slug            VARCHAR(255) UNIQUE
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### 5.3 `portfolios` — Anak Perusahaan / Investasi

```sql
id              BIGINT PK AUTO_INCREMENT
name            VARCHAR(255)
slug            VARCHAR(255) UNIQUE
tagline         VARCHAR(255) NULL
description     TEXT
sector          VARCHAR(255)              -- construction, engineering, etc.
logo            VARCHAR(255) NULL         -- Spatie Media
cover_image     VARCHAR(255) NULL
website_url     VARCHAR(255) NULL
sort_order      INTEGER DEFAULT 0
is_active       TINYINT(1) DEFAULT 1
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### 5.4 `leaders` — Tim Manajemen

```sql
id              BIGINT PK AUTO_INCREMENT
name            VARCHAR(255)
position        VARCHAR(255)
bio             TEXT NULL
photo           VARCHAR(255) NULL         -- Spatie Media
linkedin_url    VARCHAR(255) NULL
sort_order      INTEGER DEFAULT 0
is_active       TINYINT(1) DEFAULT 1
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### 5.5 `careers` — Lowongan Kerja

```sql
id              BIGINT PK AUTO_INCREMENT
title           VARCHAR(255)
department      VARCHAR(255) NULL
type            ENUM('full-time','part-time','contract','internship')
location        VARCHAR(255)              -- Jakarta / Remote / Hybrid
description     LONGTEXT                  -- HTML, kualifikasi & deskripsi
is_active       TINYINT(1) DEFAULT 1
deadline        DATE NULL
published_at    TIMESTAMP NULL
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

### 5.6 `settings` — Global Config

```sql
id              BIGINT PK AUTO_INCREMENT
key             VARCHAR(255) UNIQUE       -- 'company_phone', 'instagram_url', etc.
value           TEXT NULL
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

---

## 6. Halaman & Route Structure

### 6.1 Route Map

| URL Baru (Laravel) | URL WordPress Lama | Vue Component |
|---|---|---|
| `/` | `/` | `Pages/Home.vue` |
| `/about` | `/?page_id=4194` | `Pages/About.vue` |
| `/about/our-value` | `/?page_id=4173` | `Pages/OurValue.vue` |
| `/portfolio` | `/?page_id=4279` | `Pages/Portfolio/Index.vue` |
| `/portfolio/{slug}` | *(belum ada)* | `Pages/Portfolio/Show.vue` |
| `/leadership` | `/?page_id=4354` | `Pages/Leadership.vue` |
| `/career` | `/?page_id=2430` | `Pages/Career/Index.vue` |
| `/career/{id}` | *(belum ada)* | `Pages/Career/Show.vue` |
| `/blog` | `/?page_id=4541` | `Pages/Blog/Index.vue` |
| `/blog/{slug}` | *(belum ada)* | `Pages/Blog/Show.vue` |
| `/cybersecurity` | `/?page_id=2260` | `Pages/CyberSecurity.vue` |
| `/admin` | `/wp-admin` | Filament Panel |

### 6.2 Struktur Direktori Vue Pages

```
resources/js/
├── Pages/
│   ├── Home.vue
│   ├── About.vue
│   ├── OurValue.vue
│   ├── Leadership.vue
│   ├── CyberSecurity.vue
│   ├── Portfolio/
│   │   ├── Index.vue
│   │   └── Show.vue
│   ├── Career/
│   │   ├── Index.vue
│   │   └── Show.vue
│   └── Blog/
│       ├── Index.vue
│       └── Show.vue
├── Components/
│   ├── Navbar.vue
│   ├── Footer.vue
│   ├── HeroVideo.vue
│   └── ...
└── Layouts/
    └── AppLayout.vue
```

### 6.3 301 Redirect Map

Redirect diimplementasikan via middleware Laravel atau `routes/web.php`:

```php
// routes/web.php
Route::permanentRedirect('/?page_id=4194', '/about');   // tidak bisa, gunakan middleware

// Lebih baik: middleware RedirectOldUrls
```

```php
// app/Http/Middleware/RedirectLegacyUrls.php
$redirects = [
    '4194' => '/about',
    '4173' => '/about/our-value',
    '4279' => '/portfolio',
    '4354' => '/leadership',
    '2430' => '/career',
    '4541' => '/blog',
    '2260' => '/cybersecurity',
];

if ($request->has('page_id')) {
    $pageId = $request->query('page_id');
    if (isset($redirects[$pageId])) {
        return redirect($redirects[$pageId], 301);
    }
}
```

---

## 7. Admin Panel — Filament v3

### 7.1 Resources

| Resource | Model | Fitur Utama |
|---|---|---|
| `PostResource` | Post | CRUD, rich text (Tiptap), slug auto-gen, cover image, publish/draft, kategori |
| `CategoryResource` | Category | CRUD kategori blog |
| `PortfolioResource` | Portfolio | CRUD, logo & cover upload, drag-reorder (sort_order), active toggle |
| `LeaderResource` | Leader | CRUD, foto upload, drag-reorder |
| `CareerResource` | Career | CRUD, open/close toggle, deadline picker, type dropdown |
| `SettingResource` | Setting | Key-value editor: company info, social links, WhatsApp, email |

### 7.2 Role & Permission

Menggunakan `spatie/laravel-permission` atau Filament built-in shield:

| Role | Akses |
|---|---|
| `super_admin` | Full akses semua resource + User management |
| `editor` | Post, Portfolio, Leader, Career (tidak bisa akses User & Setting) |
| `viewer` | Read-only, untuk review internal (opsional) |

### 7.3 Filament Plugins yang Diperlukan

```bash
composer require filament/spatie-laravel-media-library-plugin
composer require awcodes/filament-tiptap-editor          # rich text
composer require filament/spatie-laravel-settings-plugin  # atau custom Setting resource
```

---

## 8. SEO Requirements

### 8.1 On-Page SEO

Setiap halaman harus memiliki:

- `<title>` — format: `{Page Title} | Azure Group`
- `<meta name="description">` — unik per halaman, 150–160 karakter
- Open Graph tags: `og:title`, `og:description`, `og:image`, `og:url`, `og:type`
- Twitter Card: `twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`
- `<link rel="canonical">` — absolute URL
- JSON-LD `Organization` schema di homepage

### 8.2 JSON-LD Schema (Homepage)

```json
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Azure Investama Group",
  "url": "https://azuregroup.co.id",
  "logo": "https://azuregroup.co.id/images/logo.png",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+6281932099898",
    "contactType": "customer service"
  },
  "sameAs": [
    "https://www.instagram.com/azureinvestamagrup/",
    "https://www.linkedin.com/company/azure-investama"
  ]
}
```

### 8.3 Technical SEO

- `robots.txt` — allow semua halaman publik, disallow `/admin`
- XML Sitemap di `/sitemap.xml` — auto-generated via `spatie/laravel-sitemap`
- 301 redirect dari semua URL WordPress lama (lihat section 6.3)
- HTTPS enforced — HTTP redirect ke HTTPS
- Security headers via middleware: `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`
- Semua gambar: format WebP, `loading="lazy"`, `alt` attribute wajib

---

## 9. Target Performa

| Metric | Saat Ini (WordPress) | Target (Laravel) |
|---|---|---|
| Lighthouse Performance | ~50–65 | **≥ 85** |
| Lighthouse SEO | ~80–90 | **≥ 95** |
| Lighthouse Accessibility | ~70–80 | **≥ 90** |
| LCP (Largest Contentful Paint) | > 4s | **< 2.5s** |
| CLS (Cumulative Layout Shift) | > 0.2 | **< 0.1** |
| INP (Interaction to Next Paint) | tidak optimal | **< 200ms** |
| TTFB (Time to First Byte) | > 1s | **< 500ms** |
| Total Page Size (Homepage) | > 5MB | **< 2MB** |

> Pengukuran menggunakan [PageSpeed Insights](https://pagespeed.web.dev/) dan Lighthouse CLI. Diuji di koneksi mobile 4G simulated.

---

## 10. Rencana Migrasi Konten

### 10.1 Proses Import

1. Export konten dari WordPress: **Admin → Tools → Export → All Content → Download XML**
2. Download semua media dari `/wp-content/uploads/` via FTP atau cPanel File Manager
3. Jalankan Artisan command: `php artisan wp:import --file=wordpress-export.xml`
4. Upload media ke Spatie Media Library dan update referensi URL di database
5. Verifikasi manual semua halaman: konten, gambar, link internal, video

### 10.2 Artisan Command: `wp:import`

Command custom yang mem-parse WordPress export XML dan memasukkan data ke tabel Laravel:

```php
// app/Console/Commands/ImportWordpress.php
// - Parse <item> elements dari XML
// - Map post_type: 'post' → Post model
// - Import media via Spatie MediaLibrary
// - Skip pages (direbuild manual via template)
// - Generate slug dari post_name atau title
```

### 10.3 Aset Media Kritikal

| File | Ukuran Est. | Catatan |
|---|---|---|
| `video-hero1-final.mp4` | > 50MB | Video hero utama homepage — **wajib CDN** |
| `azure-2.mp4` | > 30MB | Video hero section kedua — **wajib CDN** |
| Logo Azure Group (PNG) | < 1MB | Square black + white variant |
| Foto tim leadership | ~5–10MB total | Resolusi tinggi, konversi ke WebP |
| Logo anak perusahaan | ~2–5MB total | Untuk halaman portfolio |
| Favicon + OG image | < 500KB | — |

### 10.4 Rekomendasi Hosting Video

Video MP4 berukuran besar **tidak boleh** disimpan langsung di shared hosting. Opsi:

- **Cloudflare R2** — gratis 10GB/bulan, mudah diintegrasikan
- **BunnyCDN** — murah, performa bagus untuk Southeast Asia
- **YouTube Unlisted** — zero cost, tapi ada YouTube branding

---

## 11. Timeline & Milestone

| Phase | Durasi | Deliverable |
|---|---|---|
| **Phase 1** — Setup | 5 hari | Laravel install, database schema + migrations, Filament setup, auth, base layout |
| **Phase 2** — Frontend Static | 7 hari | Homepage, About, Our Value, Leadership page |
| **Phase 3** — Frontend Dinamis | 7 hari | Portfolio, Career, Blog (index + detail), CyberSecurity |
| **Phase 4** — Import Konten | 3 hari | Import WordPress XML, upload media, verifikasi konten |
| **Phase 5** — SEO & Redirect | 3 hari | 301 redirect, sitemap, meta tags, JSON-LD, robots.txt |
| **Phase 6** — QA & Optimasi | 3 hari | Lighthouse audit, bug fix, image optimization, cross-browser test |
| **Phase 7** — Deployment | 1 hari | Deploy ke server produksi, DNS switch, monitoring 48 jam |
| **Total** | **~5 minggu** | Website live di azuregroup.co.id |

> Estimasi dengan asumsi 1 developer full-time. Jika ada bottleneck di Phase 2–3, Phase 5–6 bisa dikerjakan bersamaan dengan Phase 3.

---

## 12. Acceptance Criteria

### 12.1 Fungsional

- [ ] Semua halaman publik dapat diakses tanpa error 404 atau 500
- [ ] Admin Filament dapat login dan CRUD semua konten dinamis
- [ ] Blog post yang dibuat via Filament langsung tampil di frontend
- [ ] Form Career berhasil mengirim data dan trigger email notifikasi ke admin
- [ ] Kedua video hero bisa diputar di desktop dan mobile
- [ ] Footer links, social media, contact links semua berfungsi
- [ ] 301 redirect dari URL WordPress lama berjalan benar (verifikasi via browser & GSC)

### 12.2 Performa & SEO

- [ ] Lighthouse Performance ≥ 85 di homepage (PageSpeed Insights)
- [ ] Lighthouse SEO ≥ 95 di semua halaman utama
- [ ] Sitemap XML valid dan dapat diakses di `/sitemap.xml`
- [ ] `robots.txt` terkonfigurasi benar
- [ ] Tidak ada console error JavaScript di browser

### 12.3 Keamanan

- [ ] `/admin` tidak dapat diakses tanpa autentikasi
- [ ] Security headers terpasang (verifikasi via securityheaders.com)
- [ ] File `.env` tidak exposed di public directory
- [ ] Upload file divalidasi: tipe dan ukuran maksimum
- [ ] HTTPS enforced, tidak ada mixed content warning

---

## 13. Risiko & Mitigasi

| Risiko | Level | Mitigasi |
|---|---|---|
| Video MP4 besar membebani shared hosting | 🔴 Tinggi | Host di CDN (Cloudflare R2 / BunnyCDN) — wajib |
| Traffic/ranking drop akibat URL lama masih diindex Google | 🟡 Sedang | 301 redirect komprehensif + submit ke Google Search Console |
| Konten Avada shortcode tidak bisa di-parse otomatis | 🟡 Sedang | Manual rebuild halaman dari visual referensi, bukan dari DB dump |
| Server tidak support Redis | 🟢 Rendah | Gunakan `file` atau `database` cache driver sebagai fallback |
| Waktu development melebihi estimasi | 🟢 Rendah | Prioritaskan Phase 1–4; Phase 5–6 bisa post-launch |
| DNS propagation menyebabkan downtime | 🟡 Sedang | Maintain WordPress di server lama selama 48 jam setelah DNS switch |

---

## 14. Dependencies & Asumsi

### 14.1 Dependencies

- Akses FTP / cPanel ke server hosting klien
- Akses WordPress Admin untuk export konten XML
- DNS `azuregroup.co.id` dapat diarahkan ke server baru
- Klien menyediakan aset brand: logo hi-res, foto tim, logo subsidiary
- Server hosting support **PHP 8.2+**, **MySQL 8.x**, dapat menjalankan Vite build

### 14.2 Asumsi

- Visual design mengikuti website WordPress yang ada — tidak ada redesign
- Website hanya Bahasa Inggris, tidak perlu multi-language
- Tidak ada integrasi sistem eksternal dalam scope ini
- Klien menyetujui perubahan URL structure dari `?page_id=` ke slug-based
- Email notifikasi Career form menggunakan SMTP yang disediakan klien

---

*PRD-2026-AZURE-001 | v1.0 | 24 Juni 2026 | ProudTech.id*
