# Coding Convention — azuregroup.co.id
## Laravel 11 + Inertia.js + Vue 3

| | |
|---|---|
| **Dokumen** | CC-2026-AZURE-001 |
| **Versi** | 1.0 |
| **Tanggal** | 24 Juni 2026 |
| **Author** | ProudTech.id |

---

## 1. Prinsip Umum

- **Consistency over preference** — ikuti convention ini, bukan selera pribadi
- **Explicit over implicit** — nama yang jelas lebih baik daripada kode yang singkat tapi membingungkan
- **Single responsibility** — satu file, satu tujuan
- **Fail fast** — validasi di awal, jangan biarkan data invalid masuk lebih dalam

---

## 2. PHP / Laravel Convention

### 2.1 Penamaan

| Tipe | Convention | Contoh |
|---|---|---|
| Class | PascalCase | `BlogController`, `PostResource` |
| Method | camelCase | `show()`, `getActivePortfolios()` |
| Variable | camelCase | `$postSlug`, `$careerList` |
| Constant | SCREAMING_SNAKE | `MAX_CV_SIZE`, `CAREER_TYPES` |
| Database column | snake_case | `published_at`, `sort_order` |
| Route name | kebab-case (dot grouped) | `blog.show`, `career.apply` |
| Blade view | kebab-case | `app.blade.php` |
| Config key | snake_case | `mail.admin_address` |

### 2.2 Controller Pattern

Gunakan hanya method yang dibutuhkan (`index`, `show`, `apply`) — **jangan gunakan semua 7 RESTful method jika tidak semua dipakai**.

```php
// ✅ BENAR — explicit return type, typed parameter
public function show(string $slug): Response
{
    $portfolio = Portfolio::active()
        ->where('slug', $slug)
        ->firstOrFail();

    return Inertia::render('Portfolio/Show', [
        'portfolio' => $portfolio,
    ]);
}

// ❌ SALAH — tidak ada return type, mixed concern
public function show($slug)
{
    $portfolio = Portfolio::where('slug', $slug)->where('is_active', 1)->first();
    if (!$portfolio) abort(404);
    // ... logika lain yang tidak perlu ada di sini
    return Inertia::render('Portfolio/Show', ['portfolio' => $portfolio]);
}
```

**Rules:**
- Selalu deklarasikan return type (`Response`, `RedirectResponse`, `void`)
- Gunakan `firstOrFail()` untuk 404 otomatis, bukan manual `abort(404)`
- Jangan taruh business logic di controller — gunakan Service atau Model scope
- Data yang dikirim ke Inertia harus minimal (select kolom yang dibutuhkan saja)

### 2.3 Model Pattern

```php
// ✅ BENAR
class Post extends Model
{
    use HasMedia, SoftDeletes;

    // 1. Traits di atas
    // 2. Constants
    // 3. $fillable
    // 4. $casts
    // 5. Relationships
    // 6. Scopes
    // 7. Accessors/Mutators
    // 8. Static methods

    protected $fillable = [
        'title', 'slug', 'excerpt', 'body',
        'category_id', 'published_at', 'author_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Relationships — return type wajib
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Scope — prefix "scope" + PascalCase
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    // Accessor — gunakan Attribute class (Laravel 9+)
    public function getCoverUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('cover') ?: asset('images/og-default.jpg');
    }
}
```

### 2.4 Eloquent Query

```php
// ✅ BENAR — pilih kolom spesifik, gunakan scope
$portfolios = Portfolio::active()
    ->ordered()
    ->get(['id', 'name', 'slug', 'tagline', 'sector', 'logo']);

// ❌ SALAH — select * mengirim data tidak perlu ke frontend
$portfolios = Portfolio::where('is_active', true)->get();
```

**Rules:**
- Selalu gunakan scope yang sudah ada (`active()`, `published()`, `open()`)
- Selalu pilih kolom spesifik untuk query yang hasilnya dikirim ke Inertia
- Hindari N+1: gunakan `->with('relation')` untuk eager loading
- Jangan taruh raw query kecuali benar-benar tidak bisa dengan Eloquent
- Jika raw query diperlukan, wajib gunakan binding parameter

### 2.5 Validation

```php
// ✅ BENAR — validasi inline di apply() untuk form sederhana
$validated = $request->validate([
    'name'    => ['required', 'string', 'max:255'],
    'email'   => ['required', 'email', 'max:255'],
    'phone'   => ['required', 'string', 'max:30'],
    'message' => ['nullable', 'string', 'max:2000'],
    'cv'      => ['required', 'file', 'mimes:pdf', 'max:5120'],
]);

// Untuk form yang kompleks atau dipakai di banyak tempat → gunakan Form Request
// php artisan make:request CareerApplyRequest
```

### 2.6 Response Pattern

```php
// Inertia render
return Inertia::render('PageName', [/* props */]);

// Redirect setelah form submit
return back()->with('success', 'Pesan sukses.');

// Redirect ke route lain
return redirect()->route('career.index')->with('success', 'Berhasil.');

// 404
abort(404);  // atau firstOrFail() otomatis
```

### 2.7 Env & Config

```php
// ✅ BENAR — akses via config(), bukan env() langsung di kode
config('mail.admin_address')

// ❌ SALAH — env() tidak boleh diakses di luar config files
env('MAIL_ADMIN_ADDRESS')
```

---

## 3. Vue 3 / Inertia Convention

### 3.1 Penamaan File & Component

| Tipe | Convention | Contoh |
|---|---|---|
| Page component | PascalCase | `Home.vue`, `Portfolio/Index.vue` |
| Reusable component | PascalCase | `Navbar.vue`, `HeroVideo.vue` |
| UI atom | PascalCase dengan prefix ui/ | `ui/Button.vue`, `ui/Badge.vue` |
| Composables | camelCase, prefix `use` | `useForm.js`, `useScroll.js` |
| JS utility | camelCase | `formatDate.js`, `slugify.js` |

### 3.2 Script Setup Pattern

**Wajib** menggunakan `<script setup>` (Composition API) untuk semua component baru:

```vue
<script setup>
// 1. Imports
import { ref, computed, onMounted } from 'vue'
import { usePage, useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Button from '@/Components/ui/Button.vue'

// 2. Layout definition (untuk Page component)
defineOptions({ layout: AppLayout })

// 3. Props definition
const props = defineProps({
  portfolios: {
    type: Array,
    required: true,
  },
})

// 4. Emits (jika ada)
const emit = defineEmits(['update:modelValue'])

// 5. Reactive state
const isMenuOpen = ref(false)

// 6. Computed
const activePortfolios = computed(() => props.portfolios.filter(p => p.is_active))

// 7. Methods
function toggleMenu() {
  isMenuOpen.value = !isMenuOpen.value
}

// 8. Lifecycle
onMounted(() => {
  // ...
})
</script>

<template>
  <!-- template di sini -->
</template>
```

### 3.3 Props Definition

```vue
// ✅ BENAR — type, required/default selalu dideklarasikan
const props = defineProps({
  leader: {
    type: Object,
    required: true,
  },
  showBio: {
    type: Boolean,
    default: false,
  },
  imageSize: {
    type: String,
    default: 'md',
    validator: (val) => ['sm', 'md', 'lg'].includes(val),
  },
})

// ❌ SALAH — shorthand tanpa type
defineProps(['leader', 'showBio'])
```

### 3.4 Inertia Form Handling

```vue
<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  career: { type: Object, required: true },
})

const form = useForm({
  name: '',
  email: '',
  phone: '',
  message: '',
  cv: null,
})

function submit() {
  form.post(route('career.apply', props.career.id), {
    forceFormData: true,   // wajib untuk file upload
    onSuccess: () => form.reset(),
  })
}
</script>

<template>
  <form @submit.prevent="submit">
    <div>
      <label for="name" class="form-label">Nama Lengkap</label>
      <input
        id="name"
        v-model="form.name"
        type="text"
        class="form-input"
        :class="{ 'border-red-500': form.errors.name }"
      >
      <p v-if="form.errors.name" class="form-error">{{ form.errors.name }}</p>
    </div>
    <!-- ... -->
    <Button type="submit" :disabled="form.processing">
      {{ form.processing ? 'Mengirim...' : 'Kirim Lamaran' }}
    </Button>
  </form>
</template>
```

### 3.5 v-html Safety Rule

```vue
// ✅ BENAR — hanya gunakan v-html untuk konten yang SUDAH disanitize di backend
// Backend menggunakan HTMLPurifier atau Tiptap output yang sudah bersih
<div class="prose max-w-none" v-html="post.body"></div>

// ❌ SALAH — jangan v-html untuk user input yang belum disanitize
<div v-html="userComment"></div>
```

### 3.6 Inertia Link vs a href

```vue
// ✅ BENAR — internal navigation gunakan <Link> dari Inertia
import { Link } from '@inertiajs/vue3'
<Link :href="route('portfolio.show', portfolio.slug)">View Detail</Link>

// ✅ BENAR — external link gunakan <a> biasa dengan target="_blank"
<a :href="portfolio.website_url" target="_blank" rel="noopener noreferrer">
  Visit Website
</a>

// ❌ SALAH — jangan gunakan <a> untuk internal link
<a href="/portfolio/slug-here">View Detail</a>
```

### 3.7 Template Guidelines

```vue
<template>
  <!-- ✅ Root element tunggal (Vue 3 support multiple, tapi satu lebih jelas) -->
  <div>

    <!-- ✅ v-if/v-else selalu berpasangan, jangan v-show untuk konten yang tidak dirender -->
    <div v-if="portfolios.length > 0">
      <!-- grid -->
    </div>
    <div v-else class="empty-state">
      <p>Belum ada portfolio tersedia.</p>
    </div>

    <!-- ✅ :key wajib di v-for, gunakan id bukan index -->
    <PortfolioCard
      v-for="portfolio in portfolios"
      :key="portfolio.id"
      :portfolio="portfolio"
    />

  </div>
</template>
```

### 3.8 Inertia Page Access

```vue
<script setup>
import { usePage, router } from '@inertiajs/vue3'

const page = usePage()

// Akses settings (shared data)
const settings = page.props.settings

// Akses flash message
const flash = page.props.flash

// Active route check
const isActive = (routeName) => route().current(routeName)
</script>
```

---

## 4. CSS / Tailwind Convention

### 4.1 Class Order (Tailwind)

Ikuti urutan ini untuk konsistensi (atau gunakan Prettier Tailwind plugin):

```
1. Layout:     flex, grid, block, hidden, relative, absolute
2. Sizing:     w-, h-, max-w-, min-h-
3. Spacing:    p-, m-, gap-, space-
4. Typography: text-, font-, leading-, tracking-
5. Color:      text-color, bg-color, border-color
6. Border:     border, rounded-
7. Shadow:     shadow-
8. Transition: transition-, duration-, ease-
9. Responsive: md:, lg:, xl: (selalu di akhir)
10. State:     hover:, focus:, active:, disabled:
```

### 4.2 Custom CSS

```css
/* ✅ BENAR — letakkan di app.css, gunakan @layer */
@layer components {
  .form-input {
    @apply w-full px-4 py-3 border border-gray-200 bg-white
           focus:outline-none focus:ring-2 focus:ring-azure-blue focus:border-transparent
           transition-colors duration-200;
    border-radius: 0;
  }

  .section-container {
    @apply max-w-7xl mx-auto px-6 lg:px-8;
  }
}

@layer utilities {
  .text-balance {
    text-wrap: balance;
  }
}
```

### 4.3 Prose untuk HTML Content

Untuk body konten blog dan deskripsi career/portfolio yang berasal dari rich text editor:

```vue
<!-- Gunakan @tailwindcss/typography plugin -->
<div class="prose prose-azure max-w-none prose-headings:font-montserrat prose-a:text-azure-blue">
  <div v-html="post.body"></div>
</div>
```

---

## 5. File & Folder Structure Rules

### 5.1 Laravel

```
app/
├── Filament/Resources/       — satu file per resource
├── Http/Controllers/         — satu controller per domain (Home, Blog, Career, dst.)
├── Http/Middleware/          — middleware custom
├── Http/Requests/            — Form Request class (jika validasi kompleks)
├── Mail/                     — Mailable class
├── Models/                   — satu file per model
├── Services/                 — business logic yang dipakai banyak controller
└── Console/Commands/         — artisan commands
```

### 5.2 Vue

```
resources/js/
├── Pages/                    — Inertia page components (struktur mirror routes)
│   ├── Home.vue
│   ├── Portfolio/Index.vue
│   └── Blog/Show.vue
├── Layouts/                  — layout wrappers
│   └── AppLayout.vue
├── Components/               — shared components
│   ├── Navbar.vue
│   ├── Footer.vue
│   └── ui/                   — atomic UI components (Button, Badge, Card)
└── composables/              — Vue composables (useX pattern)
```

**Rules:**
- Page component hanya ada di `Pages/` — jangan taruh di `Components/`
- UI atoms (`Button`, `Badge`, `Card`) masuk ke `Components/ui/`
- Satu komponen = satu file = satu tujuan

---

## 6. Git & Commit Convention

### 6.1 Branch Naming

```
main              — production-ready code
develop           — integration branch
feature/xxx       — fitur baru (feature/portfolio-crud)
fix/xxx           — bug fix (fix/career-form-validation)
chore/xxx         — non-code tasks (chore/update-deps)
```

### 6.2 Commit Message (Conventional Commits)

```
<type>(<scope>): <subject>

feat(portfolio): add CRUD resource in Filament
fix(career): handle missing CV upload error
style(navbar): fix mobile hamburger menu alignment
refactor(blog): extract PostResource transformer
chore(deps): update filament to 3.2.x
docs: add README setup instructions
```

**Types:** `feat`, `fix`, `style`, `refactor`, `test`, `chore`, `docs`

### 6.3 .gitignore Tambahan

```
.env
/public/storage
/public/hot
/public/build
/storage/*.key
node_modules/
vendor/
```

---

## 7. Security Coding Rules

### 7.1 Input Sanitization

```php
// ✅ Selalu sanitize HTML input sebelum simpan ke DB
// Tiptap output dari Filament relatif aman, tapi tetap validasi tipe kolom

// ✅ Jangan simpan file langsung ke public/ — gunakan storage/
$path = $request->file('cv')->store('career-applications/' . $career->id, 'local');
// Akses via signed URL atau via controller, bukan direct public URL
```

### 7.2 Authorization

```php
// Untuk route admin, Filament sudah handle auth
// Untuk route publik — pastikan tidak ada data sensitif yang bocor

// ✅ BENAR — select kolom yang aman untuk publik
Leader::active()->ordered()->get(['id', 'name', 'position', 'bio', 'photo', 'linkedin_url']);

// ❌ SALAH — jangan kirim semua kolom termasuk timestamps internal
Leader::active()->ordered()->get();
```

### 7.3 Rate Limiting

```php
// routes/web.php
Route::post('/career/{career}/apply', [CareerController::class, 'apply'])
    ->name('career.apply')
    ->middleware('throttle:5,1');  // 5 request per menit
```

---

## 8. Performance Coding Rules

### 8.1 Eager Loading

```php
// ✅ BENAR — eager load relasi yang dipakai di view
$posts = Post::published()
    ->with('category', 'author')
    ->paginate(9);

// ❌ SALAH — N+1 query
$posts = Post::published()->paginate(9);
// lalu di view: {{ post.category.name }} → 1 query per post
```

### 8.2 Pagination

```php
// ✅ Blog selalu paginate, jangan get() semua
Post::published()->paginate(9)

// Portfolio & Leadership — get() OK karena jumlah < 20
Portfolio::active()->ordered()->get(['id', 'name', 'slug', ...])
```

### 8.3 Inertia Partial Reload

```vue
// Untuk filter yang hanya update sebagian data (misal filter blog by kategori)
router.get(route('blog.index'), { category: selectedCategory }, {
  preserveState: true,
  preserveScroll: true,
  only: ['posts'],  // hanya reload 'posts' dari server, bukan semua props
})
```

---

## 9. Komentar & Dokumentasi

```php
// ✅ Komentar untuk "kenapa", bukan "apa"
// Redirect 301 diperlukan agar Google tidak kehilangan page rank dari URL WordPress lama
return redirect($this->map[$pageId], 301);

// ❌ Komentar yang hanya mendeskripsikan kode itu sendiri
// redirect to the new URL
return redirect($this->map[$pageId], 301);
```

**PHPDoc untuk public method di Service class:**

```php
/**
 * Get a setting value by key, with in-memory caching.
 *
 * @param  string  $key      The setting key (e.g., 'company_phone')
 * @param  mixed   $default  Value returned if key not found
 * @return mixed
 */
public function get(string $key, mixed $default = null): mixed
```

---

## 10. Testing Notes

Untuk proyek ini testing difokuskan pada:

- Manual QA per milestone (lihat TASK-BREAKDOWN Phase 7)
- Pastikan Career form berjalan end-to-end (submit → email → flash)
- Pastikan 301 redirect berjalan benar untuk semua 7 URL WordPress lama

Jika di masa depan ditambahkan automated testing:

```
tests/
├── Feature/
│   ├── CareerApplyTest.php    — test form submit + validation
│   ├── BlogTest.php           — test pagination, filter
│   └── RedirectTest.php       — test 301 redirects
└── Unit/
    └── SettingServiceTest.php — test cache behavior
```

---

*CC-2026-AZURE-001 | v1.0 | 24 Juni 2026 | ProudTech.id*
