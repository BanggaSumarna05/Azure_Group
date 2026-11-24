<?php

namespace App\Http\Controllers;

use App\Models\Leader;
use App\Services\SeoService;
use Inertia\Inertia;
use Inertia\Response;

class LeadershipController extends Controller
{
    public function index(): Response
    {
        app(SeoService::class)->setPage(
            'Leadership',
            'Meet the Azureinvestama leadership team — a blend of seasoned expertise and youthful vision.'
        );

        $leaders = Leader::active()
            ->ordered()
            ->with('media')
            ->get()
            ->map(fn ($l) => [
                'id'           => $l->id,
                'name'         => $l->name,
                'position'     => $l->position,
                'bio'          => $l->bio,
                'linkedin_url' => $l->linkedin_url,
                'photo_url'    => $l->photo_url,
            ]);

        return Inertia::render('Leadership', [
            'leaders' => $leaders,
        ]);
    }
}
