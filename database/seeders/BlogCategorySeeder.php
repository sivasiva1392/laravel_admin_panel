<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first(); // Get the first user (admin)

        $categories = [
            [
                'category_name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Latest technology news, reviews, and insights',
                'status' => 'active',
                'is_show' => 1,
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Lifestyle',
                'slug' => 'lifestyle',
                'description' => 'Tips and trends for modern living',
                'status' => 'active',
                'is_show' => 1,
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Business',
                'slug' => 'business',
                'description' => 'Business strategies, entrepreneurship, and market insights',
                'status' => 'active',
                'is_show' => 0,
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Health & Wellness',
                'slug' => 'health-wellness',
                'description' => 'Health tips, wellness guides, and medical insights',
                'status' => 'active',
                'is_show' => 1,
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Travel',
                'slug' => 'travel',
                'description' => 'Travel guides, destination reviews, and travel tips',
                'status' => 'active',
                'is_show' => 1,
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('blog_categories')->insert($categories);
    }
}
