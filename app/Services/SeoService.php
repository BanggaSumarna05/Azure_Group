<?php

namespace App\Services;

use App\Models\Post;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Str;

class SeoService
{
    public function setPage(string $title, string $description, ?string $image = null): void
    {
        SEOMeta::setTitle($title.' | Azureinvestama');
        SEOMeta::setDescription($description);
        OpenGraph::setTitle($title)->setDescription($description)->setUrl(request()->url());
        TwitterCard::setTitle($title)->setDescription($description);

        if ($image) {
            OpenGraph::addImage($image);
            TwitterCard::setImage($image);
        }
    }

    public function setPost(Post $post): void
    {
        $description = $post->excerpt ?? Str::limit(strip_tags($post->body), 155);
        $this->setPage($post->title, $description, $post->cover_url);
        SEOMeta::setCanonical(route('blog.show', $post->slug));
    }
}
