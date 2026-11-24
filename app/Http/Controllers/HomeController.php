<?php

namespace App\Http\Controllers;

use App\Services\SeoService;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        app(SeoService::class)->setPage(
            'Azure Group',
            'Azure Group is an Indonesia based venture company investing in high-potential industrial and infrastructure ventures.'
        );

        return Inertia::render('Home');
    }
}
