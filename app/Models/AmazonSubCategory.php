<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AmazonSubCategory extends Model
{
    use HasFactory;
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($subCategory) {
            $subCategory->slug = Str::slug($subCategory->sub_category_name);
        });
        
        static::updating(function ($subCategory) {
            $subCategory->slug = Str::slug($subCategory->sub_category_name);
        });
    }
    
    protected $fillable = [
        'amazon_category_id',
        'sub_category_name',
        'slug',
        'description',
        'image',
        'status',
        'user_id'
    ];
    
    public function category()
    {
        return $this->belongsTo(AmazonCategory::class, 'amazon_category_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function products()
    {
        return $this->hasMany(AmazonProduct::class, 'amazon_sub_category_id');
    }
}
