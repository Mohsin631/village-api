<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InquiryType;

class InquiryTypeSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['slug' => 'general', 'name' => ['en'=>'General Inquiry','ar'=>'استفسار عام']],
            ['slug' => 'sales',   'name' => ['en'=>'Sales','ar'=>'المبيعات']],
            ['slug' => 'support', 'name' => ['en'=>'Support','ar'=>'الدعم']],
        ];
        foreach ($rows as $r) {
            InquiryType::updateOrCreate(
                ['slug' => $r['slug']],
                ['name' => $r['name'], 'is_active' => true]
            );
        }
    }
}
