<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::with('role')->orderBy('id','ASC')->paginate(10);
        return view('backend.users.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = \App\Models\Role::all();
        $permissions = \App\Models\Permission::orderBy('module')->orderBy('display_name')->get();
        return view('backend.users.create')->with('roles', $roles)->with('permissions', $permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('users', $filename, 'public');
                $validated['photo'] = 'storage/' . $path;
            }

            $validated['password'] = Hash::make($validated['password']);
            $user = User::create($validated);
            
            // Handle permissions if role is not super admin
            if ($user->role_id != 1 && $request->has('permissions')) {
                $user->role->permissions()->sync($request->permissions);
            }
            
            return redirect()->route('users.index')
                ->with('success', 'Successfully added user');
        } catch (\Exception $e) {
            \Log::error('User creation failed: ' . $e->getMessage());
            return redirect()->route('users.index')
                ->with('error', 'Error occurred while adding user');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findOrFail($id);
        $roles = \App\Models\Role::all();
        $permissions = \App\Models\Permission::orderBy('module')->orderBy('display_name')->get();
        
        // Get user's current permissions
        $userPermissions = [];
        if ($user->role && $user->role_id != 1) {
            $userPermissions = $user->role->permissions->pluck('id')->toArray();
        }
        
        return view('backend.users.edit')
            ->with('user', $user)
            ->with('roles', $roles)
            ->with('permissions', $permissions)
            ->with('userPermissions', $userPermissions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('photo')) {
                // Delete old image if exists
                if ($user->photo && file_exists(public_path($user->photo))) {
                    unlink(public_path($user->photo));
                }
                
                $image = $request->file('photo');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('users', $filename, 'public');
                $validated['photo'] = 'storage/' . $path;
            } else {
                // Keep existing photo if no new file uploaded
                $validated['photo'] = $user->photo;
            }

            // Only update password if provided
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }
            
            $status = $user->update($validated);
            
            // Handle permissions if role is not super admin
            if ($user->role_id != 1) {
                if ($request->has('permissions')) {
                    $user->role->permissions()->sync($request->permissions);
                } else {
                    $user->role->permissions()->detach();
                }
            }
            
            return redirect()->route('users.index')
                ->with($status ? 'success' : 'error',
                    $status ? 'Successfully updated' : 'Error occurred while updating');
        } catch (\Exception $e) {
            \Log::error('User update failed: ' . $e->getMessage());
            return redirect()->route('users.index')
                ->with('error', 'Error occurred while updating');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deleting own account
            if ($user->id === auth()->id()) {
                return redirect()->route('users.index')
                    ->with('error', 'You cannot delete your own account');
            }
            
            $status = $user->delete();
            
            return redirect()->route('users.index')
                ->with($status ? 'success' : 'error',
                    $status ? 'User successfully deleted' : 'There is an error while deleting user');
        } catch (\Exception $e) {
            \Log::error('User deletion failed: ' . $e->getMessage());
            return redirect()->route('users.index')
                ->with('error', 'There is an error while deleting user');
        }
    }
}
