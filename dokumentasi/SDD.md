# SDD — Software Design Document
## azuregroup.co.id — Laravel 11 + Inertia.js + Vue 3

| | |
|---|---|
| **Dokumen** | SDD-2026-AZURE-001 |
| **Versi** | 1.0 |
| **Tanggal** | 24 Juni 2026 |
| **Author** | ProudTech.id |

---

## 1. Arsitektur Overview

```
┌─────────────────────────────────────────────────────────┐
│                      CLIENT BROWSER                      │
│           Vue 3 SPA (hydrated by Inertia.js)            │
└───────────────────────┬─────────────────────────────────┘
                        │ HTTP / Inertia XHR
┌───────────────────────▼─────────────────────────────────┐
│                    LARAVEL 11 (Backend)                  │
│  ┌─────────────┐  ┌──────────────┐  ┌───────────────┐  │
│  │   Router    │  │  Controller  │  │  Inertia::    │  │
│  │ routes/web  │─►│  app/Http/   │─►│  render()     │  │
│  └─────────────┘  └──────┬───────┘  └───────────────┘  │
│                           │                              │
│                    ┌──────▼───────┐                      │
│                    │   Services   │                      │
│                    │ app/Services │                      │
│                    └──────┬───────┘                      │
│                           │                              │
│                    ┌──────▼───────┐                      │
│                    │   Models     │                      │
│                    │  app/Models  │                      │
│                    └──────┬───────┘                      │
│                           │ Eloquent ORM                 │
│                    ┌──────▼───────┐                      │
│                    │   MySQL 8.x  │                      │
│                    └─────────────-┘                      │
│                                                          │
│  ┌──────────────────────────────────────────────────┐   │
│  │             Filament v3 /admin                    │   │
│  │  PortfolioResource | PostResource | LeaderRes..  │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                        │
          ┌─────────────▼──────────────┐
          │     External Storage        │
          │  CDN (video MP4)            │
          │  Spatie Media Library       │
          └────────────────────────────┘
```

**Pattern:** Monolith Laravel + Inertia.js (server-driven SPA). Tidak ada REST API publik.

---

## 2. Folder Structure

```
azuregroup/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── ImportWordpress.php          # one-time WP import
│   ├── Filament/
│   │   └── Resources/
│   │       ├── PostResource.php
│   │       ├── PortfolioResource.php
│   │       ├── LeaderResource.php
│   │       ├── CareerResource.php
│   │       ├── CategoryResource.php
│   │       └── SettingResource.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   ├── AboutController.php
│   │   │   ├── PortfolioController.php
│   │   │   ├── LeadershipController.php
│   │   │   ├── CareerController.php
│   │   │   ├── BlogController.php
│   │   │   └── PageController.php           # static pages
│   │   └── Middleware/
│   │       ├── RedirectLegacyUrls.php
│   │       └── SecurityHeaders.php
│   ├── Models/
│   │   ├── Post.php
│   │   ├── Category.php
│   │   ├── Portfolio.php
│   │   ├── Leader.php
│   │   ├── Career.php
│   │   └── Setting.php
│   └── Services/
│       ├── SeoService.php
│       └── SettingService.php
├── database/
│   ├── migrations/
│   │   ├── xxxx_create_posts_table.php
│   │   ├── xxxx_create_categories_table.php
│   │   ├── xxxx_create_portfolios_table.php
│   │   ├── xxxx_create_leaders_table.php
│   │   ├── xxxx_create_careers_table.php
│   │   └── xxxx_create_settings_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   ├── js/
│   │   ├── app.js                           # Inertia bootstrap
│   │   ├── Layouts/
│   │   │   └── AppLayout.vue
│   │   ├── Pages/
│   │   │   ├── Home.vue
│   │   │   ├── About.vue
│   │   │   ├── OurValue.vue
│   │   │   ├── Leadership.vue
│   │   │   ├── CyberSecurity.vue
│   │   │   ├── Portfolio/
│   │   │   │   ├── Index.vue
│   │   │   │   └── Show.vue
│   │   │   ├── Career/
│   │   │   │   ├── Index.vue
│   │   │   │   └── Show.vue
│   │   │   └── Blog/
│   │   │       ├── Index.vue
│   │   │       └── Show.vue
│   │   └── Components/
│   │       ├── Navbar.vue
│   │       ├── Footer.vue
│   │       ├── HeroVideo.vue
│   │       ├── SectionDivider.vue
│   │       └── ui/                          # reusable UI atoms
│   │           ├── Button.vue
│   │           ├── Badge.vue
│   │           └── Card.vue
│   ├── css/
│   │   └── app.css                          # Tailwind + custom vars
│   └── views/
│       └── app.blade.php                    # Inertia root template
├── routes/
│   └── web.php
├── config/
│   └── seo.php                              # default meta config
└── public/
    └── images/                              # static brand assets
```

---

## 3. Models

### 3.1 Post

```php
// app/Models/Post.php
class Post extends Model
{
    use HasMedia, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'body',
        'category_id', 'published_at', 'author_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Scopes
    public function scopePublished($q) {
        return $q->whereNotNull('published_at')
                 ->where('published_at', '<=', now());
    }

    // Relations
    public function category(): BelongsTo { ... }
    public function author(): BelongsTo { ... }   // → User

    // Accessor
    public function getCoverUrlAttribute(): string {
        return $this->getFirstMediaUrl('cover') ?: asset('images/og-default.jpg');
    }
}
```

### 3.2 Portfolio

```php
class Portfolio extends Model
{
    use HasMedia;

    protected $fillable = [
        'name', 'slug', 'tagline', 'description',
        'sector', 'website_url', 'sort_order', 'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeOrdered($q) { return $q->orderBy('sort_order'); }
}
```

### 3.3 Leader

```php
class Leader extends Model
{
    use HasMedia;

    protected $fillable = [
        'name', 'position', 'bio', 'linkedin_url', 'sort_order', 'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeOrdered($q) { return $q->orderBy('sort_order'); }
}
```

### 3.4 Career

```php
class Career extends Model
{
    protected $fillable = [
        'title', 'department', 'type', 'location',
        'description', 'is_active', 'deadline', 'published_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'deadline' => 'date',
        'published_at' => 'datetime',
    ];

    public function scopeOpen($q) {
        return $q->where('is_active', true)
                 ->whereNotNull('published_at')
                 ->where('published_at', '<=', now());
    }
}
```

### 3.5 Setting

```php
class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    // Usage: Setting::get('company_phone')
    public static function get(string $key, $default = null): mixed {
        return static::where('key', $key)->value('value') ?? $default;
    }
}
```

---

## 4. Controllers

### 4.1 Pattern Standar

Semua controller menggunakan `Inertia::render()` dan mengembalikan data minimal yang dibutuhkan page.

```php
// Contoh: BlogController
class BlogController extends Controller
{
    public function index(): Response
    {
        $posts = Post::published()
            ->with('category')
            ->latest('published_at')
            ->paginate(9);

        return Inertia::render('Blog/Index', [
            'posts' => PostResource::collection($posts),
        ]);
    }

    public function show(string $slug): Response
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->with('category', 'author')
            ->firstOrFail();

        return Inertia::render('Blog/Show', [
            'post' => new PostResource($post),
            'related' => PostResource::collection(
                Post::published()
                    ->where('category_id', $post->category_id)
                    ->where('id', '!=', $post->id)
                    ->limit(3)
                    ->get()
            ),
        ]);
    }
}
```

### 4.2 Controllers List

| Controller | Method | Route | Inertia Page |
|---|---|---|---|
| `HomeController` | `index` | `GET /` | `Home` |
| `AboutController` | `index` | `GET /about` | `About` |
| `AboutController` | `ourValue` | `GET /about/our-value` | `OurValue` |
| `PortfolioController` | `index` | `GET /portfolio` | `Portfolio/Index` |
| `PortfolioController` | `show` | `GET /portfolio/{slug}` | `Portfolio/Show` |
| `LeadershipController` | `index` | `GET /leadership` | `Leadership` |
| `CareerController` | `index` | `GET /career` | `Career/Index` |
| `CareerController` | `show` | `GET /career/{id}` | `Career/Show` |
| `CareerController` | `apply` | `POST /career/{id}/apply` | redirect |
| `BlogController` | `index` | `GET /blog` | `Blog/Index` |
| `BlogController` | `show` | `GET /blog/{slug}` | `Blog/Show` |
| `PageController` | `cybersecurity` | `GET /cybersecurity` | `CyberSecurity` |

---

## 5. Routes

```php
// routes/web.php

// Middleware untuk redirect URL WordPress lama
Route::middleware('redirect.legacy')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('about')->name('about.')->group(function () {
        Route::get('/', [AboutController::class, 'index'])->name('index');
        Route::get('/our-value', [AboutController::class, 'ourValue'])->name('our-value');
    });

    Route::prefix('portfolio')->name('portfolio.')->group(function () {
        Route::get('/', [PortfolioController::class, 'index'])->name('index');
        Route::get('/{slug}', [PortfolioController::class, 'show'])->name('show');
    });

    Route::get('/leadership', [LeadershipController::class, 'index'])->name('leadership');

    Route::prefix('career')->name('career.')->group(function () {
        Route::get('/', [CareerController::class, 'index'])->name('index');
        Route::get('/{career}', [CareerController::class, 'show'])->name('show');
        Route::post('/{career}/apply', [CareerController::class, 'apply'])->name('apply');
    });

    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
    });

    Route::get('/cybersecurity', [PageController::class, 'cybersecurity'])->name('cybersecurity');
});
```

---

## 6. Middleware

### 6.1 RedirectLegacyUrls

```php
// app/Http/Middleware/RedirectLegacyUrls.php
class RedirectLegacyUrls
{
    protected array $map = [
        '4194' => '/about',
        '4173' => '/about/our-value',
        '4279' => '/portfolio',
        '4354' => '/leadership',
        '2430' => '/career',
        '4541' => '/blog',
        '2260' => '/cybersecurity',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('page_id')) {
            $pageId = $request->query('page_id');
            if (isset($this->map[$pageId])) {
                return redirect($this->map[$pageId], 301);
            }
        }
        return $next($request);
    }
}
```

### 6.2 SecurityHeaders

```php
// app/Http/Middleware/SecurityHeaders.php
public function handle(Request $request, Closure $next): Response
{
    $response = $next($request);
    $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
    $response->headers->set('X-Content-Type-Options', 'nosniff');
    $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
    $response->headers->set('Permissions-Policy', 'camera=(), microphone=()');
    return $response;
}
```

---

## 7. Services

### 7.1 SeoService

```php
// app/Services/SeoService.php
class SeoService
{
    public function setPage(string $title, string $description, ?string $image = null): void
    {
        SEOMeta::setTitle($title . ' | Azure Group');
        SEOMeta::setDescription($description);
        OpenGraph::setTitle($title)->setDescription($description)->setUrl(request()->url());
        if ($image) OpenGraph::addImage($image);
        TwitterCard::setTitle($title)->setDescription($description);
        if ($image) TwitterCard::setImage($image);
    }

    public function setPost(Post $post): void
    {
        $this->setPage($post->title, $post->excerpt ?? Str::limit(strip_tags($post->body), 155), $post->cover_url);
        SEOMeta::setCanonical(route('blog.show', $post->slug));
    }
}
```

### 7.2 SettingService

```php
// app/Services/SettingService.php
class SettingService
{
    protected array $cache = [];

    public function get(string $key, $default = null): mixed
    {
        if (!isset($this->cache[$key])) {
            $this->cache[$key] = Setting::where('key', $key)->value('value');
        }
        return $this->cache[$key] ?? $default;
    }

    public function all(): array
    {
        return Setting::pluck('value', 'key')->toArray();
    }
}
```

---

## 8. Inertia Shared Data

Data yang di-share ke semua Vue page via `HandleInertiaRequests` middleware:

```php
// app/Http/Middleware/HandleInertiaRequests.php
public function share(Request $request): array
{
    return array_merge(parent::share($request), [
        'settings' => fn() => app(SettingService::class)->all(),
        'flash' => [
            'success' => fn() => $request->session()->get('success'),
            'error' => fn() => $request->session()->get('error'),
        ],
    ]);
}
```

Diakses di Vue via `usePage().props.settings` atau `usePage().props.flash`.

---

## 9. AppLayout.vue — Struktur

```vue
<!-- resources/js/Layouts/AppLayout.vue -->
<template>
  <div class="min-h-screen bg-white">
    <Navbar :settings="$page.props.settings" />

    <main>
      <slot />
    </main>

    <Footer :settings="$page.props.settings" />
  </div>
</template>
```

Setiap Page component menggunakan layout ini via:

```vue
<!-- resources/js/Pages/Home.vue -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
defineOptions({ layout: AppLayout })
</script>
```

---

## 10. Filament Resources

### 10.1 PostResource (Blog)

```php
// app/Filament/Resources/PostResource.php
class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Konten';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()->live(onBlur: true)
                ->afterStateUpdated(fn ($state, Set $set) =>
                    $set('slug', Str::slug($state))),
            Forms\Components\TextInput::make('slug')
                ->required()->unique(ignoreRecord: true),
            Forms\Components\Select::make('category_id')
                ->relationship('category', 'name')->required(),
            Forms\Components\Textarea::make('excerpt')->rows(3),
            TiptapEditor::make('body')->required()->columnSpanFull(),
            SpatieMediaLibraryFileUpload::make('cover')
                ->collection('cover')->image()->imageEditor(),
            Forms\Components\DateTimePicker::make('published_at')
                ->label('Publish At (kosongkan = draft)'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('category.name')->badge(),
            Tables\Columns\IconColumn::make('published_at')
                ->label('Status')
                ->boolean()
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-clock'),
            Tables\Columns\TextColumn::make('published_at')->dateTime()->sortable(),
        ])
        ->filters([Tables\Filters\SelectFilter::make('category')->relationship('category', 'name')])
        ->defaultSort('created_at', 'desc');
    }
}
```

---

## 11. Database Migrations

### 11.1 Urutan Eksekusi

```
1. create_categories_table
2. create_posts_table          (FK → categories)
3. create_portfolios_table
4. create_leaders_table
5. create_careers_table
6. create_settings_table
7. create_media_table          (Spatie — auto via publish)
```

### 11.2 Settings Default Seeder

```php
// database/seeders/SettingSeeder.php
$settings = [
    'company_name'    => 'Azure Investama Group',
    'company_address' => 'Talavera Office Park, 15th floor, South Jakarta 12430',
    'company_phone'   => '+6281932099898',
    'company_email'   => 'marketing@azureinvestama.com',
    'instagram_url'   => 'https://www.instagram.com/azureinvestamagrup/',
    'linkedin_url'    => 'https://www.linkedin.com/company/azure-investama',
    'maps_url'        => 'https://maps.app.goo.gl/X2zC3NPWhDP3xSUX6',
    'video_hero_1'    => 'https://cdn.azuregroup.co.id/video-hero1-final.mp4',
    'video_hero_2'    => 'https://cdn.azuregroup.co.id/azure-2.mp4',
    'og_image'        => '/images/og-default.jpg',
];
```

---

## 12. Career Apply — Form Handling

```php
// CareerController@apply
public function apply(Request $request, Career $career): RedirectResponse
{
    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|max:255',
        'phone'    => 'required|string|max:30',
        'message'  => 'nullable|string|max:2000',
        'cv'       => 'required|file|mimes:pdf|max:5120',  // max 5MB
    ]);

    // Store CV
    $path = $request->file('cv')->store('career-applications/' . $career->id, 'local');

    // Send notification email to admin
    Mail::to(config('mail.admin_address'))->send(
        new CareerApplicationMail($career, $validated, $path)
    );

    return back()->with('success', 'Lamaran berhasil dikirim. Kami akan menghubungi Anda.');
}
```

---

## 13. Sitemap Config

```php
// Dijadwalkan via Laravel Scheduler atau digenerate manual
// routes/console.php
Schedule::call(function () {
    \Spatie\Sitemap\Sitemap::create()
        ->add(Url::create('/'))
        ->add(Url::create('/about'))
        ->add(Url::create('/about/our-value'))
        ->add(Url::create('/portfolio'))
        ->add(Url::create('/leadership'))
        ->add(Url::create('/career'))
        ->add(Url::create('/blog'))
        ->add(Portfolio::active()->get()->map(fn($p) => Url::create("/portfolio/{$p->slug}")))
        ->add(Post::published()->get()->map(fn($p) => Url::create("/blog/{$p->slug}")))
        ->writeToFile(public_path('sitemap.xml'));
})->weekly();
```

---

*SDD-2026-AZURE-001 | v1.0 | 24 Juni 2026 | ProudTech.id*
