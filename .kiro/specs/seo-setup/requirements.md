# Requirements Document

## Introduction

Fitur ini mengimplementasikan **Brand Authority SEO** secara menyeluruh untuk website corporate holding company **Azure Investama Group** (`azuregroup.co.id`) yang dibangun dengan Laravel 11 + Inertia.js + Vue 3.

Tujuan SEO bukan mengejar traffic massal, melainkan memastikan Azure Group muncul di halaman 1 Google untuk branded keywords (nama perusahaan) dan career keywords (lowongan kerja). Implementasi mencakup: meta tags, Open Graph, Twitter Card, JSON-LD structured data, `robots.txt`, `sitemap.xml` dinamis, integrasi SeoService di semua controller, migrasi career route dari ID ke slug, dan panduan Image SEO.

---

## Glossary

- **SeoService**: Class `App\Services\SeoService` yang mengenkapsulasi semua logika pemasangan SEO tags.
- **SEOTools**: Package `artesaos/seotools` — menyediakan facades `SEOMeta`, `OpenGraph`, `TwitterCard`, `JsonLd`.
- **Spatie_Sitemap**: Package `spatie/laravel-sitemap` — menyediakan generator sitemap XML.
- **Meta_Tag**: Tag `<meta>` di `<head>` HTML yang dibaca search engine (title, description, canonical).
- **Open_Graph**: Protokol meta tag untuk preview di platform sosial (Facebook, LinkedIn, WhatsApp).
- **Twitter_Card**: Meta tag spesifik Twitter/X untuk preview tweet yang berisi link.
- **JSON_LD**: Format JavaScript Object Notation for Linked Data, digunakan untuk structured data schema.org yang dirender sebagai `<script type="application/ld+json">`.
- **Canonical_URL**: URL kanonik yang ditentukan via `<link rel="canonical">` untuk mencegah duplikasi konten.
- **Sitemap**: File XML `sitemap.xml` yang mendaftarkan semua URL publik untuk diindeks search engine.
- **Robots_txt**: File teks `/public/robots.txt` yang mengatur akses crawler ke URL tertentu.
- **JobPosting_Schema**: JSON-LD schema type `JobPosting` yang membuat lowongan muncul di Google Jobs.
- **Article_Schema**: JSON-LD schema type `Article` yang mengaktifkan rich snippet untuk blog post di Google.
- **Organization_Schema**: JSON-LD schema type `Organization` untuk knowledge panel perusahaan di Google.
- **Career_Slug**: Identifier unik berbasis teks deskriptif (contoh: `tax-officer-jakarta`) pada model Career, menggantikan ID numerik di URL.
- **OG_Image**: Gambar Open Graph berukuran 1200×630 px yang ditampilkan sebagai thumbnail saat link dibagikan.
- **WebP**: Format gambar modern berukuran lebih kecil dari JPG/PNG, direkomendasikan untuk performa web.
- **Blade_Template**: File `resources/views/app.blade.php` — entry point HTML untuk semua halaman Inertia.js.

---

## Requirements

### Requirement 1: Instalasi dan Konfigurasi Package SEO

**User Story:** Sebagai developer, saya ingin package SEOTools dan Spatie Sitemap terkonfigurasi dengan benar, sehingga semua fitur SEO dapat berjalan di atas fondasi yang konsisten.

#### Acceptance Criteria

1. THE project SHALL list `artesaos/seotools` under the `require` (not `require-dev`) section of `composer.json` and the package SHALL be present in the `vendor/` directory.
2. THE project SHALL list `spatie/laravel-sitemap` under the `require` (not `require-dev`) section of `composer.json` and the package SHALL be present in the `vendor/` directory.
3. WHEN `config/seotools.php` is loaded by Laravel, THE SEOTools meta defaults SHALL include title `Azure Group | Industrial Holding Company Indonesia` as fallback when a controller does not call `setPage`.
4. WHEN `config/seotools.php` is loaded by Laravel, THE SEOTools opengraph defaults SHALL include `type: website`, `site_name: Azure Group`, and `images: ['/images/og-default.svg']`.
5. WHEN `config/seotools.php` is loaded by Laravel, THE SEOTools twitter defaults SHALL include `card: summary_large_image` and `site: @azureinvestama`.
6. WHEN environment variable `GOOGLE_SEARCH_CONSOLE_ID` is set to a non-empty string, THE `config/seotools.php` SHALL map that value to `webmaster_tags.google` so SEOTools renders the Google verification meta tag.
7. THE Blade_Template (`resources/views/app.blade.php`) SHALL include `{!! SEOMeta::generate() !!}`, `{!! OpenGraph::generate() !!}`, `{!! TwitterCard::generate() !!}`, and `{!! JsonLd::generate() !!}` inside the `<head>` element, each on a separate line before `@viteReactRefresh` or `@vite`.

---

### Requirement 2: SeoService — Metode Lengkap dan Terintegrasi

**User Story:** Sebagai developer, saya ingin SeoService menyediakan metode khusus untuk setiap tipe halaman, sehingga setiap controller dapat memanggil satu metode untuk menghasilkan meta tags, OG tags, Twitter Card, dan JSON-LD yang lengkap.

#### Acceptance Criteria

1. THE SeoService SHALL provide a `setPage(string $title, string $description, ?string $image = null, ?string $canonical = null): void` method that calls `SEOMeta`, `OpenGraph`, and `TwitterCard` facades.
2. WHEN `setPage` is called with `$canonical = null`, THE SeoService SHALL pass `request()->url()` as the canonical URL to `SEOMeta::setCanonical()`.
3. WHEN `setPage` is called with `$image = null`, THE SeoService SHALL resolve `asset('images/og-default.svg')` and use it as the OG image via `OpenGraph::addImage()` and as the Twitter image via `TwitterCard::setImage()`.
4. THE SeoService SHALL provide a `setHome(): void` method that calls `SEOMeta::setTitle`, `SEOMeta::setDescription`, `SEOMeta::setCanonical`, `SEOMeta::addKeyword`, `OpenGraph`, `TwitterCard`, and `JsonLd::setType('Organization')` with all required Organization fields.
5. THE SeoService SHALL provide a `setPost(Post $post): void` method that calls `setPage()` then sets `JsonLd::setType('Article')` with fields `headline`, `datePublished`, `dateModified`, `author`, `publisher`, and `image`.
6. THE SeoService SHALL provide a `setPortfolio(Portfolio $portfolio): void` method that calls `setPage()` with canonical set to `route('portfolio.show', $portfolio->slug)`, title formatted as `"{$portfolio->name} | Azure Group Portfolio"`, description from `$portfolio->tagline` or `Str::limit($portfolio->description, 155)`, and image from `$portfolio->cover_url`.
7. THE SeoService SHALL provide a `setCareer(Career $career): void` method that calls `setPage()` then sets `JsonLd::setType('JobPosting')` with fields `title`, `description`, `datePosted`, `validThrough` (omitted when null), `employmentType`, `hiringOrganization`, and `jobLocation`.
8. WHEN `setCareer` is called, THE SeoService SHALL use `route('career.show', $career->slug)` as the canonical URL passed to `setPage()`.
9. WHEN `setPost` is called for a post without `excerpt`, THE SeoService SHALL compute description as `Str::limit(strip_tags($post->body), 155)`.
10. WHEN `setCareer` is called, THE SeoService SHALL format `employmentType` as `strtoupper(str_replace('-', '_', $career->type))` — e.g., `full-time` → `FULL_TIME` — before passing it to JsonLd.

---

### Requirement 3: Meta Tags Per Halaman

**User Story:** Sebagai tim marketing, saya ingin setiap halaman memiliki meta title, meta description, dan canonical URL yang unik dan sesuai strategi keyword, sehingga Google dapat mengindeks setiap halaman dengan identitas yang berbeda.

#### Acceptance Criteria

1. WHEN `HomeController::index` runs, THE SeoService SHALL call `setHome()` producing meta title `Azure Group | Industrial Holding Company Indonesia` and meta description `Azure Investama Group is an Indonesia-based holding company investing in high-potential industrial and infrastructure ventures. Building long-term value since 2019.`
2. WHEN `AboutController::index` runs, THE controller SHALL call `app(SeoService::class)->setPage('About Azure Group', 'Learn about Azure Investama Group — a holding company committed to scaling strategic industrial and infrastructure ventures across Indonesia since 2019.', null, url('/about'))`.
3. WHEN `AboutController::ourValue` runs, THE controller SHALL call `setPage` with title `Our Value` and canonical `url('/about/our-value')`.
4. WHEN `PortfolioController::index` runs, THE controller SHALL call `setPage` with title `Portfolio` and description `Explore Azure Group's portfolio of subsidiaries and investments across Indonesia's construction, engineering, and industrial sectors.` and canonical `url('/portfolio')`.
5. WHEN `PortfolioController::show` runs, THE controller SHALL call `app(SeoService::class)->setPortfolio($portfolio)` which produces meta title `{$portfolio->name} | Azure Group Portfolio` and canonical `route('portfolio.show', $portfolio->slug)`.
6. WHEN `LeadershipController::index` runs, THE controller SHALL call `setPage` with title `Leadership` and description `Meet the Azure Group leadership team — experienced executives driving industrial growth and long-term value creation across Indonesia's built environment sector.` and canonical `url('/leadership')`.
7. WHEN `CareerController::index` runs, THE controller SHALL call `setPage` with title `Karir di Azure Group` and description `Bergabunglah dengan Azure Investama Group. Temukan lowongan kerja terbaru di bidang konstruksi, infrastruktur, dan manajemen investasi di Jakarta.` and canonical `url('/career')`.
8. WHEN `CareerController::show` runs, THE controller SHALL call `app(SeoService::class)->setCareer($career)` which produces meta title `{$career->title} | Karir Azure Group`.
9. WHEN `BlogController::index` runs, THE controller SHALL call `setPage` with title `Blog & Insights` and description `Read the latest insights, news, and updates from Azure Investama Group on industrial ventures, infrastructure development, and strategic investments.` and canonical `url('/blog')`.
10. WHEN `BlogController::show` runs, THE controller SHALL call `app(SeoService::class)->setPost($post)` which produces meta title `{$post->title} | Azure Group`.
11. WHEN `PageController::cybersecurity` runs, THE controller SHALL call `setPage` with title `Cyber Security Information` and description `Azure Group's cyber security information, policies, and guidelines for safe digital interactions with our organization.` and canonical `url('/cybersecurity')`.
12. THE composed full meta title (including ` | Azure Group` suffix) SHALL NOT exceed 60 characters for static pages, and SHALL be truncated gracefully if a dynamic value (e.g., post title) causes the composed title to exceed 70 characters.

---

### Requirement 4: Open Graph Tags Per Halaman

**User Story:** Sebagai tim marketing, saya ingin setiap halaman menghasilkan Open Graph tags yang lengkap, sehingga link website tampil profesional saat dibagikan di LinkedIn, WhatsApp, dan Facebook.

#### Acceptance Criteria

1. THE SeoService `setPage()` method SHALL set `og:title`, `og:description`, `og:url`, `og:type`, `og:image`, and `og:site_name` on every page via the `OpenGraph` facade.
2. WHEN `setPage()` is called for static pages (About, Portfolio index, Leadership, Career index, Blog index, Cybersecurity, Our Value), THE SeoService SHALL call `OpenGraph::setType('website')`.
3. WHEN `setPost()` is called, THE SeoService SHALL call `OpenGraph::setType('article')` to override the default `website` type.
4. WHEN `setPortfolio()` is called, THE SeoService SHALL use `$portfolio->cover_url` as `og:image` when the attribute returns a non-empty URL, otherwise SHALL fall back to `asset('images/og-default.svg')`.
5. WHEN `setPost()` is called, THE SeoService SHALL use `$post->cover_url` as `og:image` when the attribute returns a non-empty URL, otherwise SHALL fall back to `asset('images/og-default.svg')`.
6. WHEN `setCareer()` is called, THE SeoService SHALL always use `asset('images/og-default.svg')` as `og:image` because Career records have no cover image.
7. THE SeoService `setPage()` method SHALL call `OpenGraph::setSiteName('Azure Group')` on every invocation so that `og:site_name` is present on all pages.
8. THE `og:description` value set by `setPage()` SHALL NOT exceed 155 characters; values longer than 155 characters SHALL be truncated via `Str::limit($description, 155)`.

---

### Requirement 5: Twitter Card Tags Per Halaman

**User Story:** Sebagai tim marketing, saya ingin setiap halaman menghasilkan Twitter Card tags yang benar, sehingga link website tampil sebagai large image card saat dibagikan di Twitter/X.

#### Acceptance Criteria

1. THE SeoService `setPage()` method SHALL call `TwitterCard::setTitle()`, `TwitterCard::setDescription()`, `TwitterCard::setImage()`, `TwitterCard::addValue('card', 'summary_large_image')`, and `TwitterCard::addValue('site', '@azureinvestama')` on every invocation.
2. THE `twitter:card` value SHALL always be `summary_large_image` for all pages, set explicitly in `setPage()` rather than relying solely on the config default.
3. WHEN `setPost()` or `setPortfolio()` is called with a cover image URL that is non-empty, THE SeoService SHALL pass that URL to `TwitterCard::setImage()`.
4. WHEN `setPost()` or `setPortfolio()` is called without a cover image (empty or null URL), THE SeoService SHALL fall back to `asset('images/og-default.svg')` for `TwitterCard::setImage()`.
5. THE `twitter:site` tag SHALL always be set to `@azureinvestama` on every page, set explicitly inside `setPage()`.

---

### Requirement 6: JSON-LD Structured Data

**User Story:** Sebagai tim marketing, saya ingin halaman utama, blog post, dan lowongan kerja memiliki JSON-LD structured data yang valid, sehingga Google dapat menampilkan rich snippets dan lowongan muncul di Google Jobs.

#### Acceptance Criteria

1. WHEN `HomeController::index` runs, THE `setHome()` method SHALL build a JSON-LD block with `@type: Organization` containing `name`, `url`, `logo` (as ImageObject), `foundingDate`, `description`, `address`, `contactPoint`, and `sameAs`.
2. WHEN JSON-LD Organization is rendered, THE address object SHALL be `@type: PostalAddress` with `streetAddress: "Talavera Office Park, 15th floor, Jl. Let TB Simatupang No. Kav. 22-26"`, `addressLocality: "South Jakarta"`, `postalCode: "12430"`, `addressCountry: "ID"`.
3. WHEN JSON-LD Organization is rendered, THE `sameAs` array SHALL contain exactly `["https://www.instagram.com/azureinvestamagrup/", "https://id.linkedin.com/company/azure-investama"]`.
4. WHEN `setPost()` is called, THE method SHALL set JSON-LD `@type: Article` with fields `headline` (= post title), `datePublished` (ISO 8601), `dateModified` (ISO 8601), `author` (`@type: Organization, name: Azure Group`), `publisher` (`@type: Organization, name: Azure Group, logo: ImageObject`), and `image` (cover URL or default).
5. WHEN JSON-LD Article is rendered, THE `author` and `publisher` objects SHALL each have `@type: Organization` and `name: "Azure Group"`.
6. WHEN `setCareer()` is called, THE method SHALL set JSON-LD `@type: JobPosting` with fields `title`, `description`, `datePosted` (ISO 8601 date string from `$career->published_at`), `employmentType`, `hiringOrganization`, and `jobLocation`.
7. WHEN JSON-LD JobPosting is rendered, THE `hiringOrganization` object SHALL be `@type: Organization` with `name: "Azure Investama Group"`, `sameAs: {APP_URL}`, and `logo: asset('images/logo.png')`.
8. WHEN `$career->deadline` is not null, THE `setCareer()` method SHALL include `validThrough` in the JobPosting JSON-LD, formatted as `$career->deadline->toDateString()` (YYYY-MM-DD).
9. WHEN `$career->deadline` is null, THE `setCareer()` method SHALL omit the `validThrough` field entirely from the JobPosting JSON-LD to avoid schema.org validation warnings.
10. WHEN JSON-LD JobPosting is rendered, THE `jobLocation` SHALL be a `Place` object with a nested `PostalAddress` containing `addressLocality: "Jakarta Selatan"` and `addressCountry: "ID"`.
11. THE JSON-LD output for Organization, Article, and JobPosting SHALL each include `@context: "https://schema.org"` so the output is valid linked data without relying on external context resolution.

---

### Requirement 7: robots.txt

**User Story:** Sebagai SEO specialist, saya ingin file `robots.txt` mengizinkan crawling semua halaman publik dan memblokir area admin, sehingga Google mengindeks halaman yang tepat dan tidak membuang crawl budget di halaman admin.

#### Acceptance Criteria

1. THE file `public/robots.txt` SHALL exist and when requested at `GET /robots.txt` SHALL return HTTP 200 with `Content-Type: text/plain`.
2. THE `robots.txt` file SHALL contain the line `User-agent: *` followed on the next line by `Allow: /`.
3. THE `robots.txt` file SHALL contain `Disallow: /admin` and `Disallow: /admin/*` on separate lines to block the Filament admin panel.
4. THE `robots.txt` file SHALL contain `Disallow: /login`, `Disallow: /storage/app/`, and `Disallow: /horizon` on separate lines.
5. THE `robots.txt` file SHALL contain the line `Sitemap: https://azuregroup.co.id/sitemap.xml` as the last directive.
6. THE paths listed under `Disallow` in `robots.txt` SHALL NOT appear as URLs inside `sitemap.xml`, ensuring crawl budget is not wasted on non-indexable paths.

---

### Requirement 8: Sitemap XML Dinamis

**User Story:** Sebagai SEO specialist, saya ingin sitemap.xml di-generate secara otomatis dan mencakup semua URL publik beserta metadata prioritas dan frekuensi update, sehingga Google dapat menemukan dan mengindeks semua halaman dengan efisien.

#### Acceptance Criteria

1. THE `GenerateSitemap` command SHALL be invokable via `php artisan sitemap:generate` and SHALL write a valid XML file to `public/sitemap.xml`, returning exit code `0` on success.
2. WHEN `GenerateSitemap` runs, THE sitemap SHALL include all eight static pages as `<url>` entries: `/`, `/about`, `/about/our-value`, `/portfolio`, `/leadership`, `/career`, `/blog`, `/cybersecurity`.
3. WHEN `GenerateSitemap` runs, THE sitemap SHALL include one `<url>` entry per `Portfolio::active()` record with path `/portfolio/{portfolio->slug}`.
4. WHEN `GenerateSitemap` runs, THE sitemap SHALL include one `<url>` entry per `Career::open()` record with path `/career/{career->slug}` — this requires the `slug` column to exist on the `careers` table (see Requirement 9).
5. WHEN `GenerateSitemap` runs, THE sitemap SHALL include one `<url>` entry per `Post::published()` record with path `/blog/{post->slug}`.
6. THE `GenerateSitemap` command SHALL set `<priority>` values as follows: `1.0` for `/`, `0.9` for `/about`, `/portfolio`, `/career`, `0.8` for `/blog`, `/leadership`, and each `/portfolio/{slug}`, `0.85` for each `/career/{slug}`, `0.7` for `/blog/{slug}` and `/about/our-value`, `0.5` for `/cybersecurity`.
7. THE `GenerateSitemap` command SHALL set `<changefreq>` values as follows: `weekly` for `/` and each `/portfolio/{slug}`, `daily` for `/career` and `/blog`, `monthly` for `/about`, `/about/our-value`, `/leadership`, each `/portfolio/{slug}` detail page, and each `/blog/{slug}`, `weekly` for each `/career/{slug}`, `yearly` for `/cybersecurity`.
8. THE `GenerateSitemap` command SHALL set `<lastmod>` for each Portfolio, Career, and Post URL using the record's `updated_at` value formatted as `Y-m-d`.
9. THE Laravel Scheduler in `routes/console.php` SHALL invoke `GenerateSitemap` with `->daily()` frequency (not `->weekly()` as currently configured).
10. THE generated `sitemap.xml` SHALL declare the namespace `xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"` in its root `<urlset>` element and SHALL be parseable as valid XML.

---

### Requirement 9: Career Route Migrasi ke Slug

**User Story:** Sebagai SEO specialist, saya ingin URL lowongan kerja menggunakan slug deskriptif seperti `/career/tax-officer-jakarta`, bukan ID numerik seperti `/career/12`, sehingga URL mengandung keyword yang relevan dan lebih mudah diingat.

#### Acceptance Criteria

1. THE `careers` table SHALL have a `slug` column of type `string`, declared `unique`, and `nullable` in the migration that adds it.
2. WHEN a new Career is saved (created or updated via Filament admin), THE Career model's `saving` observer SHALL auto-generate `slug` from `title` using `Str::slug($this->title)` if `slug` is empty.
3. WHEN the auto-generated slug already exists in the `careers` table, THE Career model SHALL append a numeric suffix (e.g., `tax-officer-2`, `tax-officer-3`) incrementing until the slug is unique, with the suffix counter bounded at 100 iterations.
4. THE Career model SHALL override `getRouteKeyName(): string` to return `'slug'`, enabling implicit route–model binding by slug.
5. WHEN Laravel resolves route `/career/{career}`, THE router SHALL perform model binding against the `slug` column, returning HTTP 404 if no Career record has that slug value.
6. WHEN `CareerController::show` receives a Career model bound by slug, THE controller SHALL call `app(SeoService::class)->setCareer($career)` to produce full SEO tags including meta title `{$career->title} | Karir Azure Group`, canonical `route('career.show', $career->slug)`, and JobPosting JSON-LD.
7. WHEN `GenerateSitemap::handle` iterates `Career::open()`, THE command SHALL use `$career->slug` to construct the URL `/career/{slug}` in the sitemap.
8. THE `slug` field SHALL be included in the data payload passed to Inertia on `CareerController::index` so the frontend can construct `/career/{slug}` links without exposing the numeric ID.
9. THE database migration for the `slug` column SHALL be runnable via `php artisan migrate` on a database that already has rows in `careers`, without error and without data loss.
10. THE migration file SHALL include a post-migration data fill that iterates all existing Career records with a null slug and assigns `Str::slug($career->title)` with uniqueness enforcement (same suffix logic as criterion 3).
11. WHEN `CareerController::apply` is called, THE route SHALL pass the Career model via slug-based implicit binding; the method SHALL NOT use `int $career` type-hint and SHALL work identically to `show` for route resolution.

---

### Requirement 10: Image SEO Guidelines

**User Story:** Sebagai developer dan content editor, saya ingin panduan dan implementasi Image SEO yang konsisten, sehingga semua gambar di website berkontribusi positif pada SEO dan performa halaman.

#### Acceptance Criteria

1. THE website SHALL use WebP as the primary format for all content images (not screenshots or documents); existing non-WebP images SHALL be converted before going live.
2. WHEN an image is rendered in a Vue component, THE `<img>` element SHALL include an `alt` attribute with a descriptive string between 5 and 125 characters that contains at least one keyword relevant to the page context.
3. IF an image is purely decorative (conveys no information), THE `<img>` element SHALL use `alt=""` (empty string, not the absence of the attribute).
4. THE project SHALL enforce kebab-case, keyword-rich file naming for all images in `public/images/` (e.g., `azure-group-logo.webp`); files named with generic patterns like `IMG_*.jpg` or `photo*.png` SHALL be renamed before going live.
5. WHEN an image is rendered in a Vue component, THE `<img>` element SHALL include explicit `width` and `height` attributes matching the intrinsic pixel dimensions to prevent Cumulative Layout Shift (CLS).
6. THE first `<img>` element in each page's render order (above-the-fold hero image) SHALL use `loading="eager"` (or omit the attribute, as eager is the default).
7. WHEN an image appears after the first `<img>` in page render order (below-the-fold), THE `<img>` element SHALL use `loading="lazy"`.
8. THE default OG image (`public/images/og-default.jpg`) SHALL be exactly 1200×630 pixels (1.91:1 aspect ratio) and SHALL be in JPG format (not WebP) for maximum social platform compatibility.
9. WHEN a blog post or portfolio item has a cover image, THE cover image SHALL have minimum dimensions of 1200×630 pixels and a maximum file size of 2 MB; images below minimum dimensions SHALL NOT be used as OG images and SHALL fall back to the default OG image.

---

### Requirement 11: Integrasi SeoService di Semua Controller

**User Story:** Sebagai developer, saya ingin setiap controller memanggil SeoService dengan metode dan parameter yang sesuai strategi SEO, sehingga tidak ada halaman yang tampil di Google dengan title/description yang generic atau salah.

#### Acceptance Criteria

1. WHEN `HomeController::index` runs, THE controller SHALL call `app(SeoService::class)->setHome()` as the first statement before passing data to Inertia.
2. WHEN `AboutController::index` runs, THE controller SHALL call `app(SeoService::class)->setPage('About Azure Group', 'Learn about Azure Investama Group — a holding company committed to scaling strategic industrial and infrastructure ventures across Indonesia since 2019.', null, url('/about'))`.
3. WHEN `AboutController::ourValue` runs, THE controller SHALL call `app(SeoService::class)->setPage('Our Value', '<description of Azure Group values>', null, url('/about/our-value'))`.
4. WHEN `PortfolioController::index` runs, THE controller SHALL call `app(SeoService::class)->setPage("Portfolio", "Explore Azure Group's portfolio of subsidiaries and investments across Indonesia's construction, engineering, and industrial sectors.", null, url('/portfolio'))`.
5. WHEN `PortfolioController::show` runs, THE controller SHALL call `app(SeoService::class)->setPortfolio($portfolio)` (not a plain `setPage` call).
6. WHEN `LeadershipController::index` runs, THE controller SHALL call `app(SeoService::class)->setPage('Leadership', 'Meet the Azure Group leadership team — experienced executives driving industrial growth and long-term value creation across Indonesia\'s built environment sector.', null, url('/leadership'))`.
7. WHEN `CareerController::index` runs, THE controller SHALL call `app(SeoService::class)->setPage('Karir di Azure Group', 'Bergabunglah dengan Azure Investama Group. Temukan lowongan kerja terbaru di bidang konstruksi, infrastruktur, dan manajemen investasi di Jakarta.', null, url('/career'))`.
8. WHEN `CareerController::show` runs, THE controller SHALL call `app(SeoService::class)->setCareer($career)` (not a plain `setPage` call).
9. WHEN `BlogController::index` runs, THE controller SHALL call `app(SeoService::class)->setPage('Blog & Insights', 'Read the latest insights, news, and updates from Azure Investama Group on industrial ventures, infrastructure development, and strategic investments.', null, url('/blog'))`.
10. WHEN `BlogController::show` runs, THE controller SHALL call `app(SeoService::class)->setPost($post)` and this SHALL be the only SEO-setting call in that method.
11. WHEN `PageController::cybersecurity` runs, THE controller SHALL call `app(SeoService::class)->setPage('Cyber Security Information', 'Azure Group\'s cyber security information, policies, and guidelines for safe digital interactions with our organization.', null, url('/cybersecurity'))`.
