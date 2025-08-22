<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Career;

class CareerSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'job_title' => [
                    'en' => 'Retail Leasing Coordinator',
                    'ar' => 'منسق تأجير التجزئة',
                ],
                'department' => [
                    'en' => 'Retail & Leasing',
                    'ar' => 'التجزئة والتأجير',
                ],
                'location' => [
                    'en' => 'The Village – Abha',
                    'ar' => 'القرية - أبها',
                ],
                'type' => [
                    'en' => 'Full Time',
                    'ar' => 'دوام كامل',
                ],
                'short_description' => [
                    'en' => 'Play a key role in building and managing our retail tenant mix.',
                    'ar' => 'القيام بدور رئيسي في بناء وإدارة تنوع المستأجرين لدينا.',
                ],
                'long_description' => [
                    'en' => "About the Role\nAs a Retail Leasing Coordinator at The Village – Abha, you will work closely with the leasing team to attract premium brands, support tenants, and ensure our open-air lifestyle destination continues to deliver a unique shopping experience.\n\nRequirements\n• Bachelor’s degree in Business, Marketing, or related field.\n• 2+ years experience in retail, leasing, or customer relations.\n• Strong communication and negotiation skills.\n• Knowledge of retail market trends in Saudi Arabia is a plus.\n• Proficiency in Microsoft Office and CRM systems.",
                    'ar' => "عن الدور\nكمنسق تأجير التجزئة في القرية - أبها، ستعمل عن كثب مع فريق التأجير لجذب العلامات التجارية المتميزة ودعم المستأجرين وضمان استمرار وجهتنا المفتوحة في تقديم تجربة تسوق فريدة.\n\nالمتطلبات\n• درجة البكالوريوس في الأعمال أو التسويق أو مجال ذي صلة.\n• خبرة سنتين+ في التجزئة أو التأجير أو علاقات العملاء.\n• مهارات قوية في التواصل والتفاوض.\n• معرفة اتجاهات سوق التجزئة في السعودية ميزة إضافية.\n• إجادة استخدام Microsoft Office وأنظمة إدارة علاقات العملاء.",
                ],
                'status' => 'active',
                'sort_order' => 1,
            ],
            // Add more positions here if you like
        ];

        foreach ($rows as $r) {
            Career::updateOrCreate(
                ['sort_order' => $r['sort_order']], // or add a unique slug/uid later
                [
                    'job_title'         => $r['job_title'],
                    'department'        => $r['department'],
                    'location'          => $r['location'],
                    'type'              => $r['type'],
                    'short_description' => $r['short_description'],
                    'long_description'  => $r['long_description'],
                    'status'            => $r['status'],
                ]
            );
        }
    }
}
