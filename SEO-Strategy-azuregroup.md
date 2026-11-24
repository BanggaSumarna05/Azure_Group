# SEO Strategy & Keyword Plan
## azuregroup.co.id — Laravel 11 Migration

| | |
|---|---|
| **Dokumen** | SEO-2026-AZURE-001 |
| **Versi** | 1.0 |
| **Tanggal** | 24 Juni 2026 |
| **Author** | ProudTech.id |

---

## 1. Konteks & Tujuan SEO

Azure Investama Group adalah **corporate holding company** — bukan e-commerce, bukan SaaS, bukan layanan konsumen. Ini penting karena implikasinya ke SEO sangat berbeda:

| Aspek | Implikasi |
|---|---|
| Target audiens | Calon mitra bisnis, investor, calon karyawan senior, media/pers |
| Intent pencarian | Informational + Branded — bukan transaksional |
| Volume keyword | Kecil tapi sangat targeted — tidak perlu ngejar volume massal |
| Kompetitor SEO | Holding company Indonesia lain: Saratoga, Barito Pacific, dsb. |
| Metrik sukses | Brand visibility, ranking untuk nama perusahaan, traffic qualified |

**Kesimpulan:** Strategi SEO untuk website ini adalah **Brand Authority SEO** — bukan traffic SEO. Tujuannya adalah: siapapun yang search nama perusahaan atau keyword terkait holding industrial Indonesia, Azure Group harus muncul di halaman 1 Google dengan informasi yang akurat dan profesional.

---

## 2. Keyword Strategy Per Halaman

### 2.1 Homepage (`/`)

**Primary keyword (target utama):**
```
Azure Group
Azure Investama Group
Azure Investama
```

**Secondary keywords:**
```
holding company Indonesia
perusahaan holding Indonesia
industrial holding company Jakarta
venture company Indonesia industrial
```

**Long-tail / informational:**
```
Azure Group Indonesia
Azure Investama Group Jakarta
holding company konstruksi Indonesia
investasi industrial Indonesia
```

**Meta Title:**
```
Azure Group | Holding Company for Industrial & Infrastructure Ventures in Indonesia
```
*(max 60 karakter yang terindex dengan baik: "Azure Group | Industrial Holding Company Indonesia")*

**Meta Description:**
```
Azure Investama Group is an Indonesia-based holding company investing in high-potential
industrial and infrastructure ventures. Building long-term value since 2019.
```
*(155 karakter)*

**H1 di halaman:**
```
AZURE GROUP
```

**H2 pertama (section 2):**
```
Advancing Strategic Industries in Indonesia
```

---

### 2.2 About Us (`/about`)

**Primary keyword:**
```
tentang Azure Group
Azure Investama Group profile
Azure holding company profile
```

**Secondary keywords:**
```
holding company visi misi Indonesia
perusahaan holding konstruksi infrastruktur
capital investment Indonesia industrial
```

**Meta Title:**
```
About Azure Group | Industrial Holding Company Since 2019 | Indonesia
```

**Meta Description:**
```
Learn about Azure Investama Group — a holding company committed to scaling strategic
industrial and infrastructure ventures across Indonesia since 2019.
```

**Heading structure:**
```
H1: About Azure Group
H2: Who We Are
H2: Our Vision & Mission
H2: Our Approach
```

---

### 2.3 Portfolio (`/portfolio`)

**Primary keyword:**
```
Azure Group portfolio
Azure Investama portfolio perusahaan
anak perusahaan Azure Group
```

**Secondary keywords:**
```
portfolio holding company konstruksi Indonesia
subsidiaries industrial holding Indonesia
perusahaan konstruksi portofolio Jakarta
```

**Meta Title:**
```
Portfolio | Azure Group — Industrial & Infrastructure Subsidiaries
```

**Meta Description:**
```
Explore Azure Group's portfolio of subsidiaries and investments across Indonesia's
construction, engineering, and industrial sectors.
```

**Heading structure:**
```
H1: Our Portfolio
H2: [Nama Anak Perusahaan] — untuk setiap portfolio item
```

**Catatan:** Setiap halaman detail portfolio (`/portfolio/{slug}`) harus punya meta title + description sendiri dengan nama perusahaan sebagai keyword utamanya. Contoh:
```
Meta Title: PT Raya Konstruksi Internasional | Azure Group Portfolio
```

---

### 2.4 Leadership (`/leadership`)

**Primary keyword:**
```
Azure Group leadership team
tim manajemen Azure Investama
direksi Azure Group
```

**Secondary keywords:**
```
Azure Group directors Indonesia
leadership holding company konstruksi
```

**Meta Title:**
```
Leadership | Azure Group Management Team
```

**Meta Description:**
```
Meet the Azure Group leadership team — experienced executives driving industrial
growth and long-term value creation across Indonesia's built environment sector.
```

---

### 2.5 Career (`/career`)

**Primary keyword:**
```
lowongan kerja Azure Group
Azure Investama loker
karir Azure Group
```

**Secondary keywords:**
```
lowongan holding company Jakarta
kerja di perusahaan holding Indonesia
Azure Investama recruitment
loker konstruksi infrastruktur Jakarta
```

**Long-tail:**
```
lowongan kerja Azure Investama Group 2026
rekrutmen Azure Group Jakarta Selatan
career holding company TB Simatupang
```

> ⚡ **Halaman Career adalah halaman SEO tertinggi potensinya** karena keyword "lowongan kerja [nama perusahaan]" selalu dicari aktif oleh jobseeker. Pastikan setiap posting lowongan punya slug yang descriptive: `/career/tax-officer-jakarta` bukan `/career/12`.

**Meta Title:**
```
Karir di Azure Group | Lowongan Kerja Industrial Holding Company Jakarta
```

**Meta Description:**
```
Bergabunglah dengan Azure Investama Group. Temukan lowongan kerja terbaru di bidang
konstruksi, infrastruktur, dan manajemen investasi di Jakarta.
```

**Setiap posting career harus punya:**
- H1: nama posisi (misal "Tax Officer")
- Meta title: `[Posisi] — Azure Group | Lowongan Jakarta`
- Meta description: ringkasan singkat posisi + lokasi + tipe

---

### 2.6 Blog (`/blog`)

**Primary keyword:**
```
Azure Group blog
Azure Investama news
berita Azure Group
```

**Secondary keywords:**
```
artikel holding company Indonesia
industrial infrastructure insight Indonesia
konstruksi infrastruktur Indonesia berita
```

**Meta Title:**
```
Blog & Insights | Azure Group — Industrial Holding Company Indonesia
```

**Meta Description:**
```
Read the latest insights, news, and updates from Azure Investama Group on
industrial ventures, infrastructure development, and strategic investments.
```

**Setiap blog post:**
- Meta title: `{Judul Post} | Azure Group`
- Meta description: excerpt 155 karakter
- Slug: descriptive dan mengandung keyword (`/blog/strategi-investasi-konstruksi-indonesia`)
- H1: judul artikel
- H2/H3: subheading per section artikel

---

### 2.7 Cyber Security (`/cybersecurity`)

**Meta Title:**
```
Cyber Security Information | Azure Group
```

**Meta Description:**
```
Azure Group's cyber security information, policies, and guidelines for
safe digital interactions with our organization.
```

---

## 3. Technical SEO — Implementasi di Laravel

### 3.1 Package: `artesaos/seotools`

```bash
composer require artesaos/seotools
php artisan vendor:publish --provider="Artesaos\SEOTools\Providers\SEOToolsServiceProvider"
```

### 3.2 Config Default (`config/seotools.php`)

```php
// config/seotools.php
'meta' => [
    'defaults' => [
        'title'        => 'Azure Group | Industrial Holding Company Indonesia',
        'titleBefore'  => false,  // format: "Page Title | Azure Group"
        'description'  => 'Azure Investama Group is an Indonesia-based holding company investing in high-potential industrial and infrastructure ventures.',
        'separator'    => ' | ',
        'keywords'     => ['azure group', 'azure investama', 'holding company indonesia', 'industrial infrastructure'],
        'canonical'    => null,   // di-set per halaman
    ],
    'webmaster_tags' => [
        'google'    => env('GOOGLE_SEARCH_CONSOLE_ID', null),
    ],
],
'opengraph' => [
    'defaults' => [
        'title'       => 'Azure Group | Industrial Holding Company Indonesia',
        'description' => 'Azure Investama Group — Indonesia-based holding company for industrial and infrastructure ventures.',
        'url'         => env('APP_URL'),
        'type'        => 'website',
        'site_name'   => 'Azure Group',
        'images'      => [env('APP_URL') . '/images/og-default.jpg'],
    ],
],
'twitter' => [
    'defaults' => [
        'card'        => 'summary_large_image',
        'site'        => '@azureinvestama',
    ],
],
```

### 3.3 SeoService (`app/Services/SeoService.php`)

```php
<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Portfolio;
use App\Models\Career;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

class SeoService
{
    protected string $siteName = 'Azure Group';
    protected string $defaultImage;
    protected string $baseUrl;

    public function __construct()
    {
        $this->defaultImage = asset('images/og-default.jpg');
        $this->baseUrl = config('app.url');
    }

    // ── Generic page ──────────────────────────────────────────
    public function setPage(
        string $title,
        string $description,
        ?string $image = null,
        ?string $canonical = null
    ): void {
        $fullTitle = $title . ' | ' . $this->siteName;
        $image = $image ?? $this->defaultImage;

        SEOMeta::setTitle($fullTitle);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical($canonical ?? request()->url());

        OpenGraph::setTitle($fullTitle)
            ->setDescription($description)
            ->setUrl($canonical ?? request()->url())
            ->addImage($image);

        TwitterCard::setTitle($fullTitle)
            ->setDescription($description)
            ->setImage($image);
    }

    // ── Homepage ───────────────────────────────────────────────
    public function setHome(): void
    {
        SEOMeta::setTitle('Azure Group | Industrial Holding Company Indonesia');
        SEOMeta::setDescription('Azure Investama Group is an Indonesia-based holding company investing in high-potential industrial and infrastructure ventures. Building long-term value since 2019.');
        SEOMeta::setCanonical($this->baseUrl);
        SEOMeta::addKeyword(['azure group', 'azure investama group', 'holding company indonesia', 'industrial holding', 'infrastructure investment indonesia']);

        OpenGraph::setTitle('Azure Group | Industrial Holding Company Indonesia')
            ->setDescription('Azure Investama Group — Indonesia-based holding company for industrial & infrastructure ventures.')
            ->setUrl($this->baseUrl)
            ->setType('website')
            ->addImage($this->defaultImage);

        TwitterCard::setTitle('Azure Group | Industrial Holding Company Indonesia')
            ->setDescription('Holding company committed to industrial & infrastructure ventures in Indonesia.')
            ->setImage($this->defaultImage);

        // JSON-LD Organization schema
        JsonLd::setType('Organization')
            ->setName('Azure Investama Group')
            ->addValue('url', $this->baseUrl)
            ->addValue('logo', asset('images/logo.png'))
            ->addValue('foundingDate', '2019')
            ->addValue('description', 'Capital investment holding company focusing on industrial and infrastructure sectors in Indonesia.')
            ->addValue('address', [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Talavera Office Park, 15th floor, Jl. Let TB Simatupang No. Kav. 22-26',
                'addressLocality' => 'South Jakarta',
                'postalCode' => '12430',
                'addressCountry' => 'ID',
            ])
            ->addValue('contactPoint', [
                '@type' => 'ContactPoint',
                'telephone' => '+6281932099898',
                'contactType' => 'customer service',
                'availableLanguage' => ['Indonesian', 'English'],
            ])
            ->addValue('sameAs', [
                'https://www.instagram.com/azureinvestamagrup/',
                'https://id.linkedin.com/company/azure-investama',
            ]);
    }

    // ── Blog post ──────────────────────────────────────────────
    public function setPost(Post $post): void
    {
        $description = $post->excerpt
            ?? \Str::limit(strip_tags($post->body), 155);

        $this->setPage(
            $post->title,
            $description,
            $post->cover_url,
            route('blog.show', $post->slug)
        );

        // JSON-LD Article schema
        JsonLd::setType('Article')
            ->setTitle($post->title)
            ->addValue('datePublished', $post->published_at->toIso8601String())
            ->addValue('dateModified', $post->updated_at->toIso8601String())
            ->addValue('author', ['@type' => 'Organization', 'name' => 'Azure Group'])
            ->addValue('publisher', [
                '@type' => 'Organization',
                'name' => 'Azure Group',
                'logo' => ['@type' => 'ImageObject', 'url' => asset('images/logo.png')],
            ])
            ->addValue('image', $post->cover_url);
    }

    // ── Portfolio detail ───────────────────────────────────────
    public function setPortfolio(Portfolio $portfolio): void
    {
        $this->setPage(
            $portfolio->name . ' | Azure Group Portfolio',
            $portfolio->tagline ?? \Str::limit($portfolio->description, 155),
            $portfolio->cover_url,
            route('portfolio.show', $portfolio->slug)
        );
    }

    // ── Career detail ──────────────────────────────────────────
    public function setCareer(Career $career): void
    {
        $description = "Lowongan {$career->title} di Azure Group — {$career->type}, {$career->location}. "
            . \Str::limit(strip_tags($career->description), 100);

        $this->setPage(
            "{$career->title} | Karir Azure Group",
            $description,
            null,
            route('career.show', $career->id)
        );

        // JSON-LD JobPosting schema — diindex Google Jobs
        JsonLd::setType('JobPosting')
            ->addValue('title', $career->title)
            ->addValue('description', $career->description)
            ->addValue('datePosted', $career->published_at?->toDateString())
            ->addValue('validThrough', $career->deadline?->toDateString())
            ->addValue('employmentType', strtoupper(str_replace('-', '_', $career->type)))
            ->addValue('hiringOrganization', [
                '@type' => 'Organization',
                'name' => 'Azure Investama Group',
                'sameAs' => $this->baseUrl,
                'logo' => asset('images/logo.png'),
            ])
            ->addValue('jobLocation', [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Talavera Office Park, 15th floor',
                    'addressLocality' => 'Jakarta Selatan',
                    'addressCountry' => 'ID',
                ],
            ]);
    }
}
```

### 3.4 Penggunaan di Controller

```php
// HomeController
public function index(): Response
{
    app(SeoService::class)->setHome();
    return Inertia::render('Home');
}

// BlogController
public function show(string $slug): Response
{
    $post = Post::published()->where('slug', $slug)->firstOrFail();
    app(SeoService::class)->setPost($post);
    return Inertia::render('Blog/Show', ['post' => new PostResource($post)]);
}

// CareerController
public function show(Career $career): Response
{
    app(SeoService::class)->setCareer($career);
    return Inertia::render('Career/Show', ['career' => $career]);
}
```

### 3.5 Blade Template (`resources/views/app.blade.php`)

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! TwitterCard::generate() !!}
    {!! JsonLd::generate() !!}

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png" />

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="bg-[#0A0A0A] text-white antialiased">
    @inertia
</body>
</html>
```

---

## 4. robots.txt

```
# /public/robots.txt
User-agent: *
Allow: /

Disallow: /admin
Disallow: /admin/*
Disallow: /login
Disallow: /storage/app/
Disallow: /horizon

Sitemap: https://azuregroup.co.id/sitemap.xml
```

---

## 5. Sitemap — Spatie Laravel Sitemap

### 5.1 Install

```bash
composer require spatie/laravel-sitemap
```

### 5.2 Generate Command

```php
// app/Console/Commands/GenerateSitemap.php
<?php

namespace App\Console\Commands;

use App\Models\Career;
use App\Models\Portfolio;
use App\Models\Post;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature   = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml';

    public function handle(): void
    {
        $sitemap = Sitemap::create();

        // Static pages
        $statics = [
            ['url' => '/',                 'priority' => 1.0,  'freq' => 'weekly'],
            ['url' => '/about',            'priority' => 0.9,  'freq' => 'monthly'],
            ['url' => '/about/our-value',  'priority' => 0.7,  'freq' => 'monthly'],
            ['url' => '/portfolio',        'priority' => 0.9,  'freq' => 'weekly'],
            ['url' => '/leadership',       'priority' => 0.8,  'freq' => 'monthly'],
            ['url' => '/career',           'priority' => 0.9,  'freq' => 'daily'],
            ['url' => '/blog',             'priority' => 0.8,  'freq' => 'daily'],
            ['url' => '/cybersecurity',    'priority' => 0.5,  'freq' => 'yearly'],
        ];

        foreach ($statics as $page) {
            $sitemap->add(
                Url::create($page['url'])
                    ->setPriority($page['priority'])
                    ->setChangeFrequency($page['freq'])
            );
        }

        // Portfolio detail pages
        Portfolio::active()->get()->each(function ($portfolio) use ($sitemap) {
            $sitemap->add(
                Url::create("/portfolio/{$portfolio->slug}")
                    ->setPriority(0.8)
                    ->setChangeFrequency('monthly')
                    ->setLastModificationDate($portfolio->updated_at)
            );
        });

        // Career listings
        Career::open()->get()->each(function ($career) use ($sitemap) {
            $sitemap->add(
                Url::create("/career/{$career->id}")
                    ->setPriority(0.85)
                    ->setChangeFrequency('weekly')
                    ->setLastModificationDate($career->updated_at)
            );
        });

        // Blog posts
        Post::published()->get()->each(function ($post) use ($sitemap) {
            $sitemap->add(
                Url::create("/blog/{$post->slug}")
                    ->setPriority(0.7)
                    ->setChangeFrequency('monthly')
                    ->setLastModificationDate($post->updated_at)
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated: ' . public_path('sitemap.xml'));
    }
}
```

### 5.3 Schedule

```php
// routes/console.php
use App\Console\Commands\GenerateSitemap;

Schedule::command(GenerateSitemap::class)->daily();
```

---

## 6. JSON-LD Schema Per Halaman — Ringkasan

| Halaman | Schema Type | Keuntungan |
|---|---|---|
| Homepage | `Organization` | Brand knowledge panel di Google, info perusahaan terstruktur |
| Blog post | `Article` | Rich snippet di Google Search (tanggal, author) |
| Career detail | `JobPosting` | **Muncul di Google Jobs** — sangat efektif untuk rekrutmen |
| Portfolio detail | `Corporation` (opsional) | Informasi anak perusahaan terstruktur |

---

## 7. Image SEO

Semua gambar di website harus mengikuti aturan ini:

```html
<!-- ✅ Benar -->
<img
  src="/images/azure-group-office-jakarta.webp"
  alt="Azure Investama Group office at Talavera Office Park, South Jakarta"
  width="1200"
  height="630"
  loading="lazy"
/>

<!-- ❌ Salah -->
<img src="/images/photo1.jpg" />
```

**Naming convention file gambar:**
```
✅ azure-group-logo.webp
✅ tim-manajemen-azure-group.webp
✅ portofolio-konstruksi-industrial-indonesia.webp

❌ IMG_0047.jpg
❌ photo.png
❌ image1.webp
```

**Konversi ke WebP:**
```bash
# Install cwebp
# Konversi semua JPG/PNG di folder public/images
find public/images -name "*.jpg" -o -name "*.png" | while read f; do
  cwebp -q 85 "$f" -o "${f%.*}.webp"
done
```

---

## 8. OG Image Default

File: `/public/images/og-default.jpg`
- Ukuran: **1200 × 630 px** (rasio 1.91:1 — standar OG)
- Konten: Logo Azure Group + tagline + background dark industrial
- Format: JPG (WebP belum didukung semua platform social)

Buat versi ini sebagai static asset — bukan generate dinamis.

---

## 9. Google Search Console Setup

Setelah website live, lakukan langkah ini:

1. **Verifikasi domain** di [search.google.com/search-console](https://search.google.com/search-console)
   - Metode: tambahkan TXT record ke DNS
   - Atau: upload HTML verification file ke `/public/`

2. **Submit sitemap:**
   - URL: `https://azuregroup.co.id/sitemap.xml`
   - GSC → Sitemaps → Add new sitemap

3. **Request indexing** untuk semua URL baru:
   - GSC → URL Inspection → ketik URL → Request Indexing
   - Prioritaskan: Homepage, About, Portfolio, Career

4. **Monitor redirect:**
   - GSC → Pages → check "Page with redirect"
   - Pastikan semua URL lama (`?page_id=xxxx`) sudah resolved ke URL baru

5. **Core Web Vitals:**
   - GSC → Experience → Core Web Vitals
   - Target: semua page masuk kategori "Good"

---

## 10. Checklist SEO Pre-Launch

### Technical
- [ ] `sitemap.xml` dapat diakses di `/sitemap.xml`
- [ ] `robots.txt` terkonfigurasi benar, tidak block halaman publik
- [ ] HTTPS aktif, HTTP redirect ke HTTPS
- [ ] 301 redirect dari semua URL WordPress lama berjalan
- [ ] Tidak ada broken link (404) pada halaman yang sudah live
- [ ] Security headers terpasang (X-Frame-Options, X-Content-Type-Options)

### On-Page
- [ ] Setiap halaman punya meta title unik (< 60 karakter)
- [ ] Setiap halaman punya meta description unik (< 155 karakter)
- [ ] Setiap halaman punya canonical URL
- [ ] OG image terdefinisi untuk semua halaman
- [ ] Semua gambar punya `alt` attribute
- [ ] H1 ada tepat 1 per halaman
- [ ] Heading hierarchy benar (H1 → H2 → H3)

### Schema
- [ ] `Organization` JSON-LD ada di homepage
- [ ] `Article` JSON-LD ada di setiap blog post
- [ ] `JobPosting` JSON-LD ada di setiap halaman career detail
- [ ] Validasi schema di [schema.org/validator](https://validator.schema.org/)

### Google
- [ ] Google Search Console verified
- [ ] Sitemap di-submit ke GSC
- [ ] Google Analytics / GA4 terpasang (opsional tapi direkomendasikan)

---

## 11. Keyword Monitoring

Setelah live, pantau keyword berikut di Google Search Console (Queries report):

**Branded (harus ranking #1):**
- `azure group`
- `azure investama group`
- `azure investama`
- `azure group jakarta`

**Career (potensi traffic tinggi):**
- `lowongan kerja azure group`
- `azure investama loker`
- `azure group recruitment`

**Informational:**
- `holding company konstruksi indonesia`
- `perusahaan holding industrial jakarta`

**Jika ada blog post:** pantau keyword per artikel melalui GSC → Performance → Pages → pilih URL artikel.

---

*SEO-2026-AZURE-001 | v1.0 | 24 Juni 2026 | ProudTech.id*
