<?php

namespace App\Http\Controllers;

use App\Services\SeoService;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function index(): Response
    {
        app(SeoService::class)->setPage(
            'About Us',
            'Learn about Azure Investama Group, a holding venture focused on industrial projects across Indonesia since 2019.'
        );

        return Inertia::render('About');
    }

    public function ourValue(): Response
    {
        app(SeoService::class)->setPage(
            'Our Value',
            'Discover the core values that drive Azure Group — integrity, excellence, and long-term partnership.'
        );

        return Inertia::render('About/OurValue');
    }
}
