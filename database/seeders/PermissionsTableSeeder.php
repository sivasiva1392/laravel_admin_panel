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
            
            // Banner permissions
            ['name' => 'view_banners', 'display_name' => 'View Banners', 'module' => 'banners'],
            ['name' => 'create_banners', 'display_name' => 'Create Banners', 'module' => 'banners'],
            ['name' => 'edit_banners', 'display_name' => 'Edit Banners', 'module' => 'banners'],
            ['name' => 'delete_banners', 'display_name' => 'Delete Banners', 'module' => 'banners'],
            
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
            
            // Amazon Subcategory permissions
            ['name' => 'view_amazon_subcategories', 'display_name' => 'View Amazon Subcategories', 'module' => 'amazon_subcategories'],
            ['name' => 'create_amazon_subcategories', 'display_name' => 'Create Amazon Subcategories', 'module' => 'amazon_subcategories'],
            ['name' => 'edit_amazon_subcategories', 'display_name' => 'Edit Amazon Subcategories', 'module' => 'amazon_subcategories'],
            ['name' => 'delete_amazon_subcategories', 'display_name' => 'Delete Amazon Subcategories', 'module' => 'amazon_subcategories'],
            
            // Blog Category permissions
            ['name' => 'view_blog_categories', 'display_name' => 'View Blog Categories', 'module' => 'blog_categories'],
            ['name' => 'create_blog_categories', 'display_name' => 'Create Blog Categories', 'module' => 'blog_categories'],
            ['name' => 'edit_blog_categories', 'display_name' => 'Edit Blog Categories', 'module' => 'blog_categories'],
            ['name' => 'delete_blog_categories', 'display_name' => 'Delete Blog Categories', 'module' => 'blog_categories'],
            
            // Blog Subcategory permissions
            ['name' => 'view_blog_subcategories', 'display_name' => 'View Blog Subcategories', 'module' => 'blog_subcategories'],
            ['name' => 'create_blog_subcategories', 'display_name' => 'Create Blog Subcategories', 'module' => 'blog_subcategories'],
            ['name' => 'edit_blog_subcategories', 'display_name' => 'Edit Blog Subcategories', 'module' => 'blog_subcategories'],
            ['name' => 'delete_blog_subcategories', 'display_name' => 'Delete Blog Subcategories', 'module' => 'blog_subcategories'],
            
            // Blog Product permissions
            ['name' => 'view_blog_products', 'display_name' => 'View Blog Products', 'module' => 'blog_products'],
            ['name' => 'create_blog_products', 'display_name' => 'Create Blog Products', 'module' => 'blog_products'],
            ['name' => 'edit_blog_products', 'display_name' => 'Edit Blog Products', 'module' => 'blog_products'],
            ['name' => 'delete_blog_products', 'display_name' => 'Delete Blog Products', 'module' => 'blog_products'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
