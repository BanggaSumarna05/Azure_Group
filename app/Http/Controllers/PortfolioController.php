<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Services\SeoService;
use Inertia\Inertia;
use Inertia\Response;

class PortfolioController extends Controller
{
    public function index(): Response
    {
        app(SeoService::class)->setPage(
            'Portfolio',
            'Explore Azureinvestama\'s portfolio of subsidiaries and investments in construction and engineering sectors.'
        );

        $portfolios = Portfolio::active()
            ->ordered()
            ->with('media')
            ->get()
            ->map(fn ($p) => [
                'id'       => $p->id,
                'name'     => $p->name,
                'slug'     => $p->slug,
                'tagline'  => $p->tagline,
                'sector'   => $p->sector,
                'logo_url' => $p->logo_url,
            ]);

        return Inertia::render('Portfolio/Index', [
            'portfolios' => $portfolios,
        ]);
    }

    public function show(string $slug): Response
    {
        $portfolio = Portfolio::active()->where('slug', $slug)->with('media')->firstOrFail();

        app(SeoService::class)->setPage(
            $portfolio->name,
            $portfolio->tagline ?? \Illuminate\Support\Str::limit(strip_tags($portfolio->description), 155),
            $portfolio->cover_url
        );

        return Inertia::render('Portfolio/Show', [
            'portfolio' => $portfolio,
        ]);
    }
}
