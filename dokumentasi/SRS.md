# SRS — Software Requirements Specification
## azuregroup.co.id — Laravel 11 + Inertia.js + Vue 3

| | |
|---|---|
| **Dokumen** | SRS-2026-AZURE-001 |
| **Versi** | 1.0 |
| **Tanggal** | 24 Juni 2026 |
| **Author** | ProudTech.id |

---

## 1. Halaman: Homepage (`/`)

### 1.1 Fungsional

**Section 1 — Hero Video**
- Menampilkan video background full-screen (`video_hero_1` dari Settings)
- Overlay teks: tagline utama Azure Group
- Tombol CTA "Discover More" → `/about`
- Video autoplay, muted, loop, preload="auto"
- Fallback: poster image jika video gagal load

**Section 2 — 6 Years Section**
- Video kedua (`video_hero_2`) sebagai background atau parallax
- Teks narasi: "6 Years of Dedication. 6 Years of Building Impact."
- Paragraf deskripsi
- Teks bold: "INVESTING TODAY, TRANSFORMING TOMORROW"

**Section 3 — Partnership / Stats**
- Scroll-triggered section dengan counter animasi (opsional)
- CTA "Discover More" → `/portfolio`

**Section 4 — Footer Nav**
- Tampilan scroll-section element (pills/dots navigasi antar section)

### 1.2 Data dari Controller

```php
// HomeController@index
return Inertia::render('Home', [
    // tidak ada data dinamis — semua dari Settings (shared)
]);
```

### 1.3 Validasi & Edge Case

- Jika `video_hero_1` setting kosong → tampilkan poster image statis
- Video tidak boleh menghambat LCP — load video setelah above-the-fold konten

---

## 2. Halaman: About Us (`/about`)

### 2.1 Fungsional

- Static page — konten hardcoded di template
- Menampilkan: company background, tahun berdiri (2019), fokus bisnis
- CTA ke `/about/our-value`

### 2.2 Data dari Controller

```php
// AboutController@index — tidak ada data dinamis
return Inertia::render('About');
```

---

## 3. Halaman: Our Value (`/about/our-value`)

### 3.1 Fungsional

- Static page — nilai-nilai perusahaan
- List nilai: Integrity, Excellence, Partnership, Sustainability (konfirmasi dengan klien)

### 3.2 Data dari Controller

```php
return Inertia::render('OurValue');
```

---

## 4. Halaman: Portfolio (`/portfolio` & `/portfolio/{slug}`)

### 4.1 Index — `/portfolio`

**Fungsional:**
- Grid/list semua Portfolio yang `is_active = true`, diurutkan `sort_order ASC`
- Setiap card: logo, nama, sektor, tagline, tombol "View Detail"
- Tidak ada pagination (jumlah portfolio diasumsikan < 20)

**Data:**
```php
// PortfolioController@index
return Inertia::render('Portfolio/Index', [
    'portfolios' => Portfolio::active()->ordered()
        ->get(['id','name','slug','tagline','sector','logo']),
]);
```

**Edge Case:**
- Jika tidak ada portfolio aktif → tampilkan empty state "Coming Soon"

### 4.2 Detail — `/portfolio/{slug}`

**Fungsional:**
- Hero: cover image + nama perusahaan + sektor
- Deskripsi lengkap (HTML)
- Link ke website subsidiary (buka tab baru)
- Tombol back ke `/portfolio`

**Data:**
```php
// PortfolioController@show
$portfolio = Portfolio::active()->where('slug', $slug)->firstOrFail();
return Inertia::render('Portfolio/Show', [
    'portfolio' => $portfolio,
]);
```

**Edge Case:**
- Slug tidak ditemukan → 404
- Portfolio `is_active = false` → 404

---

## 5. Halaman: Leadership (`/leadership`)

### 5.1 Fungsional

- Grid foto + nama + jabatan semua Leader yang `is_active = true`, sorted by `sort_order`
- Hover: tampilkan bio singkat (tooltip atau expand)
- LinkedIn icon → buka profil (jika `linkedin_url` terisi)

**Data:**
```php
// LeadershipController@index
return Inertia::render('Leadership', [
    'leaders' => Leader::active()->ordered()
        ->get(['id','name','position','bio','photo','linkedin_url']),
]);
```

**Edge Case:**
- `linkedin_url` kosong → tidak tampilkan icon LinkedIn
- `photo` kosong → tampilkan avatar placeholder (inisial nama)

---

## 6. Halaman: Career (`/career` & `/career/{id}`)

### 6.1 Index — `/career`

**Fungsional:**
- List semua Career yang `is_active = true` dan `published_at <= now()`
- Sorted: terbaru dulu (`published_at DESC`)
- Filter opsional: by `type` (full-time, part-time, contract, internship)
- Setiap item: judul, departemen, tipe badge, lokasi, deadline, CTA "Apply Now"

**Data:**
```php
// CareerController@index
return Inertia::render('Career/Index', [
    'careers' => Career::open()
        ->latest('published_at')
        ->get(['id','title','department','type','location','deadline']),
]);
```

**Edge Case:**
- Tidak ada lowongan aktif → empty state "Tidak ada posisi yang dibuka saat ini"
- `deadline` sudah lewat tapi `is_active = true` → masih tampil (admin yang handle tutup manual)

### 6.2 Detail — `/career/{id}`

**Fungsional:**
- Judul posisi, departemen, tipe, lokasi, deadline
- Deskripsi + kualifikasi lengkap (HTML dari `description`)
- Form apply di bawah konten

**Form Apply:**
| Field | Tipe | Validasi |
|---|---|---|
| Nama Lengkap | text | required, max 255 |
| Email | email | required, valid email |
| No. HP | text | required, max 30 |
| Pesan (opsional) | textarea | max 2000 |
| Upload CV | file | required, PDF only, max 5MB |

**Setelah Submit:**
- Success: flash message "Lamaran berhasil dikirim"
- Error validasi: inline error per field
- Email notifikasi dikirim ke `MAIL_ADMIN_ADDRESS` di `.env`

**Data:**
```php
// CareerController@show
$career = Career::open()->findOrFail($id);
return Inertia::render('Career/Show', [
    'career' => $career,
]);
```

**Edge Case:**
- Career tidak ditemukan atau sudah ditutup → 404
- Upload CV gagal → error "Gagal mengunggah CV, coba lagi"
- Email gagal terkirim → log error, tetap flash success ke user

---

## 7. Halaman: Blog (`/blog` & `/blog/{slug}`)

### 7.1 Index — `/blog`

**Fungsional:**
- Grid artikel yang sudah published, 9 per halaman (pagination)
- Setiap card: cover image, kategori badge, judul, excerpt, tanggal publish
- Filter by kategori (optional, via query param `?category=slug`)

**Data:**
```php
// BlogController@index
$query = Post::published()->with('category')->latest('published_at');

if ($request->has('category')) {
    $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
}

return Inertia::render('Blog/Index', [
    'posts' => PostResource::collection($query->paginate(9)),
    'categories' => Category::whereHas('posts', fn($q) => $q->published())->get(['id','name','slug']),
    'activeCategory' => $request->query('category'),
]);
```

**Edge Case:**
- Tidak ada post → empty state "Belum ada artikel"
- Cover image kosong → fallback ke OG image default

### 7.2 Detail — `/blog/{slug}`

**Fungsional:**
- Hero: cover image full-width + judul + meta (kategori, tanggal, author)
- Body HTML dirender aman (tidak ada XSS)
- Related posts: 3 artikel dari kategori yang sama
- Breadcrumb: Home > Blog > [Judul]

**Data:**
```php
// BlogController@show
$post = Post::published()->where('slug', $slug)->with('category','author')->firstOrFail();
return Inertia::render('Blog/Show', [
    'post' => new PostResource($post),
    'related' => PostResource::collection(
        Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->limit(3)->get()
    ),
]);
```

**Edge Case:**
- Slug tidak ditemukan atau draft → 404
- Body HTML: gunakan `v-html` dengan konten sudah di-sanitize di backend (via `HTMLPurifier` atau Filament Tiptap output)
- Related posts < 3 → tampilkan sebanyak yang ada

---

## 8. Halaman: Cyber Security Information (`/cybersecurity`)

### 8.1 Fungsional

- Static page — konten informasi keamanan siber
- Tidak ada data dinamis dari database

```php
return Inertia::render('CyberSecurity');
```

---

## 9. Komponen: Navbar

### 9.1 Fungsional

- Logo Azure Group (klik → `/`)
- Navigation links: Home, About Us, Portfolio, Leadership, Career, Blog
- "About Us" memiliki dropdown: About Us, Our Value
- Responsive: hamburger menu di mobile
- Sticky/fixed di top saat scroll
- Active state: highlight link sesuai halaman aktif (via `$page.url` Inertia)

### 9.2 Data

Data dari `$page.props.settings` (shared):
- `company_name` → alt text logo
- Instagram, LinkedIn URL → footer (bukan navbar)

---

## 10. Komponen: Footer

### 10.1 Fungsional

**Kolom 1 — Useful Links**
- Home, About, Portfolio, Leadership

**Kolom 2 — Follow Us**
- Instagram icon → `settings.instagram_url`
- LinkedIn icon → `settings.linkedin_url`

**Kolom 3 — Get in Touch**
- WhatsApp icon → `https://wa.me/{settings.company_phone}`
- Email icon → `mailto:{settings.company_email}`

**Kolom 4 — Information**
- Link "Cyber Security Information" → `/cybersecurity`

**Kolom 5 — Our Location**
- Nama: Azure Investama Group
- Alamat → `settings.company_address`
- Link Google Maps → `settings.maps_url`

**Copyright:**
- `© {tahun} Azure Investama Group, All Rights Reserved.`
- Tahun auto dari `new Date().getFullYear()`

---

## 11. SEO — Per Halaman

| Halaman | Title | Description |
|---|---|---|
| Home | Azure Group | Azure Group is an Indonesia based venture company investing in high-potential industrial and infrastructure ventures. |
| About | About Us \| Azure Group | Learn about Azure Investama Group, a holding venture focused on industrial projects across Indonesia since 2019. |
| Our Value | Our Value \| Azure Group | Discover the core values that drive Azure Group — integrity, excellence, and long-term partnership. |
| Portfolio | Portfolio \| Azure Group | Explore Azure Group's portfolio of subsidiaries and investments in construction and engineering sectors. |
| Leadership | Leadership \| Azure Group | Meet the Azure Group leadership team — a blend of seasoned expertise and youthful vision. |
| Career | Career \| Azure Group | Join Azure Group. Explore open positions and be part of building Indonesia's industrial future. |
| Blog | Blog \| Azure Group | Insights, news, and updates from Azure Investama Group. |
| Blog/{slug} | `{post.title}` \| Azure Group | `{post.excerpt}` |
| Cybersecurity | Cyber Security Info \| Azure Group | Azure Group's cyber security information and policies. |

---

## 12. Validasi Global

- CSRF token: Laravel default, otomatis via Inertia
- Rate limiting: form apply career → 5 request/menit per IP
- File upload: hanya PDF, max 5MB
- XSS: semua input di-escape, HTML dari CMS di-sanitize sebelum disimpan
- SQL injection: aman via Eloquent ORM (tidak ada raw query tanpa binding)

---

## 13. Email Notifikasi

### 13.1 CareerApplicationMail

| Field | Value |
|---|---|
| To | `config('mail.admin_address')` |
| Subject | `[Career Apply] {posisi} — {nama_pelamar}` |
| Body | Nama, email, phone, posisi, pesan, attachment CV (PDF) |
| Driver | SMTP (config dari `.env`: MAIL_HOST, MAIL_PORT, dsb.) |

---

*SRS-2026-AZURE-001 | v1.0 | 24 Juni 2026 | ProudTech.id*
