<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\BlogCategory;
use App\Models\BlogSubCategory;

class BlogProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        $aiSubCategory = BlogSubCategory::where('sub_category_name', 'Artificial Intelligence')->first();
        $webDevSubCategory = BlogSubCategory::where('sub_category_name', 'Web Development')->first();
        $fashionSubCategory = BlogSubCategory::where('sub_category_name', 'Fashion')->first();

        $products = [
            [
                'blog_category_id' => BlogCategory::where('category_name', 'Technology')->first()->id,
                'blog_sub_category_id' => $aiSubCategory->id,
                'product_name' => 'ChatGPT: The Future of AI Writing',
                'slug' => 'chatgpt-future-ai-writing',
                'description' => 'An in-depth review of ChatGPT and its impact on content creation, writing, and the future of artificial intelligence in creative industries.',
                'short_description' => 'Comprehensive review of ChatGPT and AI writing tools',
                'image' => null,
                'image_url' => 'https://via.placeholder.com/300x200',
                'link' => 'https://openai.com/blog/chatgpt',
                'affiliate_url' => null,
                'meta_title' => 'ChatGPT Review: AI Writing Tools Guide',
                'meta_description' => 'Complete review of ChatGPT, its features, pricing, and how it\'s changing the future of AI writing and content creation.',
                'meta_keywords' => 'ChatGPT, AI writing, artificial intelligence, content creation, OpenAI',
                'status' => 'active',
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_category_id' => BlogCategory::where('category_name', 'Technology')->first()->id,
                'blog_sub_category_id' => $webDevSubCategory->id,
                'product_name' => 'Laravel 10: Complete Developer Guide',
                'slug' => 'laravel-10-developer-guide',
                'description' => 'Everything you need to know about Laravel 10, including new features, installation, and best practices for modern web development.',
                'short_description' => 'Complete guide to Laravel 10 framework',
                'image' => null,
                'image_url' => 'https://via.placeholder.com/300x200',
                'link' => 'https://laravel.com/docs/10.x',
                'affiliate_url' => null,
                'meta_title' => 'Laravel 10 Developer Guide - Complete Tutorial',
                'meta_description' => 'Learn Laravel 10 with our comprehensive developer guide covering installation, features, and best practices.',
                'meta_keywords' => 'Laravel, PHP, web development, Laravel 10, framework',
                'status' => 'active',
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_category_id' => BlogCategory::where('category_name', 'Lifestyle')->first()->id,
                'blog_sub_category_id' => $fashionSubCategory->id,
                'product_name' => 'Sustainable Fashion: 2024 Trends',
                'slug' => 'sustainable-fashion-2024-trends',
                'description' => 'Explore the latest sustainable fashion trends for 2024, including eco-friendly materials, ethical brands, and conscious consumer choices.',
                'short_description' => 'Latest sustainable fashion trends and eco-friendly brands',
                'image' => null,
                'image_url' => 'https://via.placeholder.com/300x200',
                'link' => null,
                'affiliate_url' => 'https://example.com/fashion-affiliate',
                'meta_title' => 'Sustainable Fashion Trends 2024 - Eco-Friendly Style',
                'meta_description' => 'Discover the top sustainable fashion trends for 2024, featuring eco-friendly materials and ethical fashion brands.',
                'meta_keywords' => 'sustainable fashion, eco-friendly clothing, ethical brands, 2024 trends',
                'status' => 'active',
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_category_id' => BlogCategory::where('category_name', 'Business')->first()->id,
                'blog_sub_category_id' => null,
                'product_name' => 'Remote Work Productivity Guide',
                'slug' => 'remote-work-productivity-guide',
                'description' => 'Master the art of remote work with our comprehensive productivity guide, including tools, tips, and strategies for success.',
                'short_description' => 'Essential productivity tips for remote work success',
                'image' => null,
                'image_url' => 'https://via.placeholder.com/300x200',
                'link' => null,
                'affiliate_url' => null,
                'meta_title' => 'Remote Work Productivity Guide - Work From Home Tips',
                'meta_description' => 'Boost your productivity while working from home with our comprehensive guide featuring tools, strategies, and best practices.',
                'meta_keywords' => 'remote work, productivity, work from home, telecommuting',
                'status' => 'active',
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('blog_products')->insert($products);
    }
}
