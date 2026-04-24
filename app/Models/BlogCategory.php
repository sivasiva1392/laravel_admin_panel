<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogCategory extends Model
{
    use HasFactory;
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            $category->slug = Str::slug($category->category_name);
        });
        
        static::updating(function ($category) {
            $category->slug = Str::slug($category->category_name);
        });
    }
    
    protected $fillable = [
        'category_name',
        'slug',
        'description',
        'image',
        'status',
        'is_show',
        'user_id'
    ];
    
    public function products()
    {
        return $this->hasMany(BlogProduct::class);
    }
    
    public function subCategories()
    {
        return $this->hasMany(BlogSubCategory::class, 'blog_category_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
