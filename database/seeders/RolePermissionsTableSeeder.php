<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all roles
        $superAdminRole = Role::where('name', 'super_admin')->first();
        $adminRole = Role::where('name', 'admin')->first();
        
        // Get all permissions
        $allPermissions = Permission::all();
        
        // Super Admin gets all permissions
        if ($superAdminRole) {
            foreach ($allPermissions as $permission) {
                $superAdminRole->permissions()->syncWithoutDetaching([$permission->id]);
            }
        }
        
        // Admin gets limited permissions (example: can manage LMS, Amazon and Blog modules)
        if ($adminRole) {
            $adminPermissions = [
                'view_dashboard',
                'view_banners', 'create_banners', 'edit_banners', 'delete_banners',
                'view_lms_categories', 'create_lms_categories', 'edit_lms_categories', 'delete_lms_categories',
                'view_lms', 'create_lms', 'edit_lms', 'delete_lms',
                'view_amazon_categories', 'create_amazon_categories', 'edit_amazon_categories', 'delete_amazon_categories',
                'view_amazon_subcategories', 'create_amazon_subcategories', 'edit_amazon_subcategories', 'delete_amazon_subcategories',
                'view_amazon_products', 'create_amazon_products', 'edit_amazon_products', 'delete_amazon_products',
                'view_blog_categories', 'create_blog_categories', 'edit_blog_categories', 'delete_blog_categories',
                'view_blog_subcategories', 'create_blog_subcategories', 'edit_blog_subcategories', 'delete_blog_subcategories',
                'view_blog_products', 'create_blog_products', 'edit_blog_products', 'delete_blog_products',
            ];
            
            foreach ($adminPermissions as $permissionName) {
                $permission = Permission::where('name', $permissionName)->first();
                if ($permission) {
                    $adminRole->permissions()->syncWithoutDetaching([$permission->id]);
                }
            }
        }
    }
}
