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
        
        // Admin gets limited permissions (example: can manage products, categories, brands, but not users or settings)
        if ($adminRole) {
            $adminPermissions = [
                'view_dashboard',
                'view_products', 'create_products', 'edit_products', 'delete_products',
                'view_categories', 'create_categories', 'edit_categories', 'delete_categories',
                'view_brands', 'create_brands', 'edit_brands', 'delete_brands',
                'view_banners', 'create_banners', 'edit_banners', 'delete_banners',
                'view_posts', 'create_posts', 'edit_posts', 'delete_posts',
                'view_post_categories', 'create_post_categories', 'edit_post_categories', 'delete_post_categories',
                'view_post_tags', 'create_post_tags', 'edit_post_tags', 'delete_post_tags',
                'view_coupons', 'create_coupons', 'edit_coupons', 'delete_coupons',
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
