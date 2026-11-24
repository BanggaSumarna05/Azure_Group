<?php

namespace App\Console\Commands;

use App\Models\Portfolio;
use App\Models\Post;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the XML sitemap';

    public function handle(): int
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/about'))
            ->add(Url::create('/about/our-value'))
            ->add(Url::create('/portfolio'))
            ->add(Url::create('/leadership'))
            ->add(Url::create('/career'))
            ->add(Url::create('/blog'))
            ->add(Url::create('/cybersecurity'));

        foreach (Portfolio::active()->get() as $portfolio) {
            $sitemap->add(Url::create('/portfolio/'.$portfolio->slug));
        }

        foreach (Post::published()->get() as $post) {
            $sitemap->add(Url::create('/blog/'.$post->slug));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated at public/sitemap.xml');

        return self::SUCCESS;
    }
}
