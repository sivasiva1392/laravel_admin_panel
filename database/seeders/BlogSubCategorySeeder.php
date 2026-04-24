<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\BlogCategory;

class BlogSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        $technologyCategory = BlogCategory::where('category_name', 'Technology')->first();
        $lifestyleCategory = BlogCategory::where('category_name', 'Lifestyle')->first();
        $businessCategory = BlogCategory::where('category_name', 'Business')->first();

        $subCategories = [
            [
                'blog_category_id' => $technologyCategory->id,
                'sub_category_name' => 'Artificial Intelligence',
                'slug' => 'artificial-intelligence',
                'description' => 'AI news, machine learning, and automation insights',
                'status' => 'active',
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_category_id' => $technologyCategory->id,
                'sub_category_name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Frontend, backend, and full-stack development tutorials',
                'status' => 'active',
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_category_id' => $lifestyleCategory->id,
                'sub_category_name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Fashion trends, style guides, and clothing reviews',
                'status' => 'active',
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_category_id' => $lifestyleCategory->id,
                'sub_category_name' => 'Food & Cooking',
                'slug' => 'food-cooking',
                'description' => 'Recipes, cooking tips, and food reviews',
                'status' => 'active',
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_category_id' => $businessCategory->id,
                'sub_category_name' => 'Startups',
                'slug' => 'startups',
                'description' => 'Startup advice, funding news, and entrepreneurship tips',
                'status' => 'active',
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_category_id' => $businessCategory->id,
                'sub_category_name' => 'Digital Marketing',
                'slug' => 'digital-marketing',
                'description' => 'SEO, social media, and online marketing strategies',
                'status' => 'active',
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('blog_sub_categories')->insert($subCategories);
    }
}
