<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if (! $this->relationLoaded('media')) {
            $this->loadMissing('media');
        }

        $coverUrl = $this->getFirstMediaUrl('cover');

        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'slug'         => $this->slug,
            'excerpt'      => $this->excerpt,
            'body'         => $this->body,
            'cover_url'    => $coverUrl !== '' ? $coverUrl : null,
            'published_at' => $this->published_at?->format('M d, Y'),
            'category' => $this->whenLoaded('category', fn () => [
                'id'   => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ]),
            'author' => $this->whenLoaded('author', fn () => [
                'id'   => $this->author?->id,
                'name' => $this->author?->name ?? 'Azureinvestama',
            ]),
        ];
    }
}
