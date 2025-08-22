<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BoardMember;

class BoardMemberSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'name' => ['en' => 'Waleed Muhammed', 'ar' => 'وليد محمد'],
                'position' => [
                    'en' => 'Founder and Acting CEO',
                    'ar' => 'المؤسس والرئيس التنفيذي بالإنابة'
                ],
                'image' => '/images/board/waleed.png',
                'sort_order' => 1,
            ],
            [
                'name' => ['en' => 'Faisal Al Qarhani', 'ar' => 'فيصل القرطاني'],
                'position' => [
                    'en' => 'PMO',
                    'ar' => 'PMO'
                ],
                'image' => '/images/board/faisal.png',
                'sort_order' => 2,
            ],
        ];

        foreach ($rows as $r) {
            BoardMember::updateOrCreate(
                ['image' => $r['image']], // unique-ish key you control (or add a slug column)
                [
                    'name'       => $r['name'],
                    'position'   => $r['position'],
                    'is_active'  => true,
                    'sort_order' => $r['sort_order'],
                ]
            );
        }
    }
}

