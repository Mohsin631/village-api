<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\BlogCategory;

class BlogSeeder extends Seeder
{
    public function run()
    {
        // Categories
        $events = BlogCategory::create([
            'name' => 'Events',
            'name_ar' => 'الفعاليات'
        ]);
        $partnerships = BlogCategory::create([
            'name' => 'Partnerships',
            'name_ar' => 'الشراكات'
        ]);
        $social = BlogCategory::create([
            'name' => 'Social Media Highlights',
            'name_ar' => 'أبرز وسائل التواصل الاجتماعي'
        ]);

        // Blogs (dummy cover image)
        $cover = '/images/blogs/blog-1.png';

        $blogs = [
            [
                'title' => 'The Village – Abha Welcomes Luxury Brand XYZ',
                'title_ar' => 'القرية - أبها ترحب بالعلامة التجارية الفاخرة XYZ',
                'short_description' => 'The Village – Abha expands its premium retail offering with the opening of XYZ, bringing world-class fashion to Asir.',
                'short_description_ar' => 'القرية - أبها توسع عروضها الراقية في التجزئة مع افتتاح XYZ، مما يجلب أزياء عالمية المستوى إلى عسير.',
                'long_description' => 'The Village – Abha continues to grow as a premier destination for luxury shopping. With the arrival of XYZ, visitors will enjoy exclusive fashion experiences...',
                'long_description_ar' => 'تواصل القرية - أبها النمو كوجهة رئيسية للتسوق الفاخر. مع وصول XYZ، سيتمكن الزوار من الاستمتاع بتجارب أزياء حصرية...',
                'cover_image' => $cover,
                'blog_category_id' => $events->id,
                'status' => 'active',
            ],
            [
                'title' => 'The Village Partnerships: Global Brands Join Hands',
                'title_ar' => 'شراكات القرية: العلامات التجارية العالمية تنضم',
                'short_description' => 'Announcing new partnerships with top global brands to enhance shopping and lifestyle experiences at The Village.',
                'short_description_ar' => 'الإعلان عن شراكات جديدة مع أفضل العلامات التجارية العالمية لتعزيز تجربة التسوق ونمط الحياة في القرية.',
                'long_description' => 'The Village – Abha is proud to partner with leading global names to bring premium services and luxury experiences to visitors...',
                'long_description_ar' => 'تفخر القرية - أبها بالشراكة مع أبرز الأسماء العالمية لتقديم خدمات متميزة وتجارب فاخرة للزوار...',
                'cover_image' => $cover,
                'blog_category_id' => $partnerships->id,
                'status' => 'active',
            ],
            [
                'title' => 'The Village on Social Media: Highlights You Can’t Miss',
                'title_ar' => 'القرية على وسائل التواصل الاجتماعي: أبرز ما لا يمكن تفويته',
                'short_description' => 'From Instagram to TikTok, explore how The Village is trending across social media platforms.',
                'short_description_ar' => 'من إنستغرام إلى تيك توك، اكتشف كيف تتصدر القرية منصات التواصل الاجتماعي.',
                'long_description' => 'Follow The Village – Abha across social platforms for behind-the-scenes moments, exclusive brand launches, and interactive events...',
                'long_description_ar' => 'تابع القرية - أبها عبر منصات التواصل الاجتماعي للقطات من وراء الكواليس، وإطلاق العلامات التجارية الحصرية، والفعاليات التفاعلية...',
                'cover_image' => $cover,
                'blog_category_id' => $social->id,
                'status' => 'active',
            ],
        ];

        foreach ($blogs as $b) {
            Blog::create($b);
        }
    }
}

