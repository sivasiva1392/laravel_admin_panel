<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // Dashboard permissions
            ['name' => 'view_dashboard', 'display_name' => 'View Dashboard', 'module' => 'dashboard'],
            
            // User management permissions
            ['name' => 'view_users', 'display_name' => 'View Users', 'module' => 'users'],
            ['name' => 'create_users', 'display_name' => 'Create Users', 'module' => 'users'],
            ['name' => 'edit_users', 'display_name' => 'Edit Users', 'module' => 'users'],
            ['name' => 'delete_users', 'display_name' => 'Delete Users', 'module' => 'users'],
            
            // Product permissions
            ['name' => 'view_products', 'display_name' => 'View Products', 'module' => 'products'],
            ['name' => 'create_products', 'display_name' => 'Create Products', 'module' => 'products'],
            ['name' => 'edit_products', 'display_name' => 'Edit Products', 'module' => 'products'],
            ['name' => 'delete_products', 'display_name' => 'Delete Products', 'module' => 'products'],
            
            // Category permissions
            ['name' => 'view_categories', 'display_name' => 'View Categories', 'module' => 'categories'],
            ['name' => 'create_categories', 'display_name' => 'Create Categories', 'module' => 'categories'],
            ['name' => 'edit_categories', 'display_name' => 'Edit Categories', 'module' => 'categories'],
            ['name' => 'delete_categories', 'display_name' => 'Delete Categories', 'module' => 'categories'],
            
            // Brand permissions
            ['name' => 'view_brands', 'display_name' => 'View Brands', 'module' => 'brands'],
            ['name' => 'create_brands', 'display_name' => 'Create Brands', 'module' => 'brands'],
            ['name' => 'edit_brands', 'display_name' => 'Edit Brands', 'module' => 'brands'],
            ['name' => 'delete_brands', 'display_name' => 'Delete Brands', 'module' => 'brands'],
            
            // Banner permissions
            ['name' => 'view_banners', 'display_name' => 'View Banners', 'module' => 'banners'],
            ['name' => 'create_banners', 'display_name' => 'Create Banners', 'module' => 'banners'],
            ['name' => 'edit_banners', 'display_name' => 'Edit Banners', 'module' => 'banners'],
            ['name' => 'delete_banners', 'display_name' => 'Delete Banners', 'module' => 'banners'],
            
            // Post permissions
            ['name' => 'view_posts', 'display_name' => 'View Posts', 'module' => 'posts'],
            ['name' => 'create_posts', 'display_name' => 'Create Posts', 'module' => 'posts'],
            ['name' => 'edit_posts', 'display_name' => 'Edit Posts', 'module' => 'posts'],
            ['name' => 'delete_posts', 'display_name' => 'Delete Posts', 'module' => 'posts'],
            
            // Post Category permissions
            ['name' => 'view_post_categories', 'display_name' => 'View Post Categories', 'module' => 'post_categories'],
            ['name' => 'create_post_categories', 'display_name' => 'Create Post Categories', 'module' => 'post_categories'],
            ['name' => 'edit_post_categories', 'display_name' => 'Edit Post Categories', 'module' => 'post_categories'],
            ['name' => 'delete_post_categories', 'display_name' => 'Delete Post Categories', 'module' => 'post_categories'],
            
            // Post Tag permissions
            ['name' => 'view_post_tags', 'display_name' => 'View Post Tags', 'module' => 'post_tags'],
            ['name' => 'create_post_tags', 'display_name' => 'Create Post Tags', 'module' => 'post_tags'],
            ['name' => 'edit_post_tags', 'display_name' => 'Edit Post Tags', 'module' => 'post_tags'],
            ['name' => 'delete_post_tags', 'display_name' => 'Delete Post Tags', 'module' => 'post_tags'],
            
            // Coupon permissions
            ['name' => 'view_coupons', 'display_name' => 'View Coupons', 'module' => 'coupons'],
            ['name' => 'create_coupons', 'display_name' => 'Create Coupons', 'module' => 'coupons'],
            ['name' => 'edit_coupons', 'display_name' => 'Edit Coupons', 'module' => 'coupons'],
            ['name' => 'delete_coupons', 'display_name' => 'Delete Coupons', 'module' => 'coupons'],
            
            // Settings permissions
            ['name' => 'view_settings', 'display_name' => 'View Settings', 'module' => 'settings'],
            ['name' => 'edit_settings', 'display_name' => 'Edit Settings', 'module' => 'settings'],
            
            // LMS Category permissions
            ['name' => 'view_lms_categories', 'display_name' => 'View LMS Categories', 'module' => 'lms_categories'],
            ['name' => 'create_lms_categories', 'display_name' => 'Create LMS Categories', 'module' => 'lms_categories'],
            ['name' => 'edit_lms_categories', 'display_name' => 'Edit LMS Categories', 'module' => 'lms_categories'],
            ['name' => 'delete_lms_categories', 'display_name' => 'Delete LMS Categories', 'module' => 'lms_categories'],
            
            // LMS Document permissions
            ['name' => 'view_lms', 'display_name' => 'View LMS Documents', 'module' => 'lms'],
            ['name' => 'create_lms', 'display_name' => 'Create LMS Documents', 'module' => 'lms'],
            ['name' => 'edit_lms', 'display_name' => 'Edit LMS Documents', 'module' => 'lms'],
            ['name' => 'delete_lms', 'display_name' => 'Delete LMS Documents', 'module' => 'lms'],
            
            // Amazon Category permissions
            ['name' => 'view_amazon_categories', 'display_name' => 'View Amazon Categories', 'module' => 'amazon_categories'],
            ['name' => 'create_amazon_categories', 'display_name' => 'Create Amazon Categories', 'module' => 'amazon_categories'],
            ['name' => 'edit_amazon_categories', 'display_name' => 'Edit Amazon Categories', 'module' => 'amazon_categories'],
            ['name' => 'delete_amazon_categories', 'display_name' => 'Delete Amazon Categories', 'module' => 'amazon_categories'],
            
            // Amazon Product permissions
            ['name' => 'view_amazon_products', 'display_name' => 'View Amazon Products', 'module' => 'amazon_products'],
            ['name' => 'create_amazon_products', 'display_name' => 'Create Amazon Products', 'module' => 'amazon_products'],
            ['name' => 'edit_amazon_products', 'display_name' => 'Edit Amazon Products', 'module' => 'amazon_products'],
            ['name' => 'delete_amazon_products', 'display_name' => 'Delete Amazon Products', 'module' => 'amazon_products'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
