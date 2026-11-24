<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SimpleXMLElement;

class ImportWordpress extends Command
{
    protected $signature = 'wp:import {--file=wordpress-export.xml}';

    protected $description = 'Import WordPress XML export into Laravel posts';

    public function handle(): int
    {
        $file = base_path($this->option('file'));

        if (! File::exists($file)) {
            $this->error("File not found: {$file}");

            return self::FAILURE;
        }

        $xml = new SimpleXMLElement(File::get($file));
        $xml->registerXPathNamespace('wp', 'http://wordpress.org/export/1.2/');
        $xml->registerXPathNamespace('content', 'http://purl.org/rss/1.0/modules/content/');

        $admin = User::firstOrCreate(
            ['email' => 'admin@azuregroup.co.id'],
            ['name' => 'Admin', 'password' => bcrypt('password')]
        );

        $imported = 0;

        foreach ($xml->channel->item as $item) {
            $wp = $item->children('wp', true);
            $postType = (string) $wp->post_type;

            if ($postType !== 'post') {
                continue;
            }

            $status = (string) $wp->status;
            if ($status !== 'publish') {
                continue;
            }

            $title = (string) $item->title;
            $slug = (string) $wp->post_name ?: Str::slug($title);
            $content = (string) $item->children('content', true)->encoded;
            $excerpt = (string) $item->children('excerpt', true)->encoded ?: Str::limit(strip_tags($content), 200);

            $categoryName = 'Uncategorized';
            foreach ($item->category as $cat) {
                if ((string) $cat['domain'] === 'category') {
                    $categoryName = (string) $cat;
                    break;
                }
            }

            $category = Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName]
            );

            Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'excerpt' => $excerpt,
                    'body' => $content,
                    'category_id' => $category->id,
                    'author_id' => $admin->id,
                    'published_at' => now(),
                ]
            );

            $imported++;
        }

        $this->info("Imported {$imported} posts.");

        return self::SUCCESS;
    }
}
