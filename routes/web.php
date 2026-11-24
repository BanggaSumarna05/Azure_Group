<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadershipController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Models\CareerApplication;

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
        Route::post('/apply', [CareerController::class, 'applyGeneral'])
            ->middleware(['throttle:5,1', \App\Http\Middleware\VerifyHoneypot::class])
            ->name('apply.general');
        Route::get('/{career}', [CareerController::class, 'show'])->name('show');
        Route::post('/{career}/apply', [CareerController::class, 'apply'])
            ->middleware(['throttle:5,1', \App\Http\Middleware\VerifyHoneypot::class])
            ->name('apply');
    });

    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
    });

    Route::get('/cybersecurity', [PageController::class, 'cybersecurity'])->name('cybersecurity');
});

// Admin: download CV (protected — only accessible when logged in to Filament)
Route::get('/admin/career-applications/{application}/cv', function (CareerApplication $application) {
    $path = storage_path('app/private/' . $application->cv_path);

    if (! file_exists($path)) {
        abort(404, 'CV file not found.');
    }

    return response()->download(
        $path,
        'CV-' . str($application->name)->slug() . '.pdf',
        ['Content-Type' => 'application/pdf']
    );
})->middleware(['web', 'auth'])->name('admin.career-applications.cv');
