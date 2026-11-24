<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'company_name' => 'Azure Investama Group',
            'company_address' => 'Talavera Office Park, 15th floor, South Jakarta 12430',
            'company_phone' => '+6281932099898',
            'company_email' => 'marketing@azureinvestama.com',
            'instagram_url' => 'https://www.instagram.com/azureinvestamagrup/',
            'linkedin_url' => 'https://www.linkedin.com/company/azure-investama',
            'maps_url' => 'https://maps.app.goo.gl/X2zC3NPWhDP3xSUX6',
            'video_hero_1' => 'https://cdn.azuregroup.co.id/video-hero1-final.mp4',
            'video_hero_2' => 'https://cdn.azuregroup.co.id/azure-2.mp4',
            'og_image' => '/images/og-default.svg',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
