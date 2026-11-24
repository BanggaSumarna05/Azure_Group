<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function index(Request $request): Response
    {
        app(SeoService::class)->setPage(
            'Blog',
            'Insights, news, and updates from Azure Investama Group.'
        );

        $query = Post::published()->with('category', 'media')->latest('published_at');

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        return Inertia::render('Blog/Index', [
            'posts' => PostResource::collection($query->paginate(9)),
            'categories' => Category::whereHas('posts', fn ($q) => $q->published())->get(['id', 'name', 'slug']),
            'activeCategory' => $request->query('category'),
        ]);
    }

    public function show(string $slug): Response
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->with('category', 'author', 'media')
            ->firstOrFail();

        app(SeoService::class)->setPost($post);

        return Inertia::render('Blog/Show', [
            'post' => [
                'id'           => $post->id,
                'title'        => $post->title,
                'slug'         => $post->slug,
                'excerpt'      => $post->excerpt,
                'body'         => $post->body,
                'cover_url'    => $post->getFirstMediaUrl('cover') ?: null,
                'published_at' => $post->published_at?->format('M d, Y'),
                'category'     => $post->category ? [
                    'id'   => $post->category->id,
                    'name' => $post->category->name,
                    'slug' => $post->category->slug,
                ] : null,
                'author' => $post->author ? [
                    'id'   => $post->author->id,
                    'name' => $post->author->name ?? 'Azure Group',
                ] : ['id' => null, 'name' => 'Azure Group'],
            ],
            'related' => PostResource::collection(
                Post::published()
                    ->where('category_id', $post->category_id)
                    ->where('id', '!=', $post->id)
                    ->with('media')
                    ->limit(3)
                    ->get()
            ),
        ]);
    }
}
