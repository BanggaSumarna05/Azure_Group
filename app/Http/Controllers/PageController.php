<?php

namespace App\Http\Controllers;

use App\Services\SeoService;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function cybersecurity(): Response
    {
        app(SeoService::class)->setPage(
            'Cyber Security Info',
            'Azureinvestama\'s cyber security information and policies.'
        );

        return Inertia::render('CyberSecurity');
    }
}
