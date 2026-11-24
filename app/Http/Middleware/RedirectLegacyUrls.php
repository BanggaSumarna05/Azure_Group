<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
