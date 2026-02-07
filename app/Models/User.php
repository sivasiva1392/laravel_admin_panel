<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','photo','status','provider','provider_id','role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function orders(){
        return $this->hasMany('App\Models\Order');
    }
    
    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_id');
    }
    
    /**
     * Check if user has specific permission
     */
    public function hasPermission($permissionName)
    {
        if (!$this->role) {
            return false;
        }
        
        return $this->role->hasPermission($permissionName);
    }
    
    /**
     * Check if user can access a specific module
     */
    public function canAccessModule($module)
    {
        if (!$this->role) {
            return false;
        }
        
        // Super admin can access everything
        if ($this->role_id == 1) {
            return true;
        }
        
        // Check if role has any permission for this module
        return $this->role->permissions()->where('module', $module)->exists();
    }
    
}
