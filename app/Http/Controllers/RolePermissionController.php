<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of roles with their permissions.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all()->groupBy('module');
        
        return view('backend.role_permissions.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for editing permissions for a specific role.
     */
    public function edit($roleId)
    {
        $role = Role::with('permissions')->findOrFail($roleId);
        $permissions = Permission::all()->groupBy('module');
        $rolePermissionIds = $role->permissions->pluck('id')->toArray();
        
        return view('backend.role_permissions.edit', compact('role', 'permissions', 'rolePermissionIds'));
    }

    /**
     * Update permissions for a specific role.
     */
    public function update(Request $request, $roleId)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::findOrFail($roleId);
        
        // Don't allow editing super admin permissions if current user is not super admin
        if ($role->name === 'super_admin' && auth()->user()->role_id !== 1) {
            return redirect()->route('role-permissions.index')
                ->with('error', 'You cannot modify Super Admin permissions.');
        }

        DB::beginTransaction();
        try {
            // Sync permissions for the role
            $role->permissions()->sync($request->permissions ?? []);
            
            DB::commit();
            
            return redirect()->route('role-permissions.index')
                ->with('success', "Permissions updated successfully for {$role->display_name} role.");
                
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Role permission update failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Failed to update permissions. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show role permissions overview.
     */
    public function show($roleId)
    {
        $role = Role::with('permissions')->findOrFail($roleId);
        $permissions = $role->permissions->groupBy('module');
        
        return view('backend.role_permissions.show', compact('role', 'permissions'));
    }

    /**
     * Get permissions by module for AJAX requests.
     */
    public function getPermissionsByModule($module)
    {
        $permissions = Permission::where('module', $module)->get();
        
        return response()->json([
            'permissions' => $permissions
        ]);
    }

    /**
     * Create a new role.
     */
    public function createRole()
    {
        return view('backend.role_permissions.create_role');
    }

    /**
     * Store a new role.
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        try {
            $role = Role::create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description
            ]);

            return redirect()->route('role-permissions.index')
                ->with('success', "Role '{$role->display_name}' created successfully.");
                
        } catch (\Exception $e) {
            \Log::error('Role creation failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Failed to create role. Please try again.')
                ->withInput();
        }
    }

    /**
     * Delete a role.
     */
    public function destroyRole($roleId)
    {
        $role = Role::findOrFail($roleId);
        
        // Don't allow deleting super admin role
        if ($role->name === 'super_admin') {
            return redirect()->route('role-permissions.index')
                ->with('error', 'Cannot delete Super Admin role.');
        }

        // Check if role has users
        if ($role->users()->count() > 0) {
            return redirect()->route('role-permissions.index')
                ->with('error', 'Cannot delete role with assigned users.');
        }

        try {
            $roleName = $role->display_name;
            $role->delete();
            
            return redirect()->route('role-permissions.index')
                ->with('success', "Role '{$roleName}' deleted successfully.");
                
        } catch (\Exception $e) {
            \Log::error('Role deletion failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Failed to delete role. Please try again.');
        }
    }
}
