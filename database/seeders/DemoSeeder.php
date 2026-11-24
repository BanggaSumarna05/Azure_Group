<?php

namespace Database\Seeders;

use App\Models\Career;
use App\Models\Category;
use App\Models\Leader;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@azuregroup.co.id'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        $category = Category::firstOrCreate(
            ['slug' => 'news'],
            ['name' => 'News']
        );

        Post::firstOrCreate(
            ['slug' => 'welcome-to-azure-group'],
            [
                'title' => 'Welcome to Azure Group',
                'excerpt' => 'Insights and updates from Azure Investama Group.',
                'body' => '<p>Azure Group is an Indonesia based venture company investing in high-potential industrial and infrastructure ventures.</p>',
                'category_id' => $category->id,
                'author_id' => $admin->id,
                'published_at' => now(),
            ]
        );

        Portfolio::firstOrCreate(
            ['slug' => 'azure-construction'],
            [
                'name' => 'Azure Construction',
                'tagline' => 'Building Indonesia\'s future',
                'description' => '<p>Leading construction and engineering solutions across Indonesia.</p>',
                'sector' => 'Construction',
                'website_url' => 'https://azuregroup.co.id',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        Leader::firstOrCreate(
            ['name' => 'John Doe'],
            [
                'position' => 'Chief Executive Officer',
                'bio' => 'Seasoned leader with decades of experience in industrial ventures.',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        Career::firstOrCreate(
            ['title' => 'Business Development Manager'],
            [
                'department' => 'Business Development',
                'type' => 'full-time',
                'location' => 'Jakarta',
                'description' => '<p>We are looking for a motivated Business Development Manager to join our team.</p><ul><li>Minimum 5 years experience</li><li>Strong communication skills</li></ul>',
                'is_active' => true,
                'deadline' => now()->addMonths(2),
                'published_at' => now(),
            ]
        );
    }
}
