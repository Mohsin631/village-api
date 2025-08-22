<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::updateOrCreate(
            ['key' => 'contact'],
            ['value' => [
                'phone' => '+966-500-000000',
                'email' => 'info@village.example',
                'location' => 'Riyadh, Saudi Arabia',
                'location_google_maps' => 'https://maps.google.com/?q=Riyadh',
                'linkedin'  => 'https://www.linkedin.com/company/example',
                'youtube'   => 'https://www.youtube.com/@example',
                'twitter'   => 'https://twitter.com/example',
                'tiktok'    => 'https://www.tiktok.com/@example',
                'instagram' => 'https://www.instagram.com/example',
            ],
            'is_public' => true]
        );
    }
}

