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
        'name', 'email', 'password','role','photo','status','provider','provider_id','role_id',
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

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['role'];

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
     * Get the role name attribute.
     */
    public function getRoleNameAttribute()
    {
        // Use the role column as fallback if relationship doesn't work
        if ($this->role_id) {
            $role = \App\Models\Role::find($this->role_id);
            return $role ? $role->name : $this->role;
        }
        return $this->role;
    }
    
    /**
     * Check if user has specific role
     */
    public function hasRole($roleName)
    {
        return $this->role_name === $roleName;
    }
    
    /**
     * Check if user is admin or master
     */
    public function isAdminOrMaster()
    {
        return $this->hasRole('admin') || $this->hasRole('master');
    }
}
