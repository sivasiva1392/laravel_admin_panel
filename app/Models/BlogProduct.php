<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogProduct extends Model
{
    use HasFactory;
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            $product->slug = Str::slug($product->product_name);
        });
        
        static::updating(function ($product) {
            $product->slug = Str::slug($product->product_name);
        });
    }
    
    protected $fillable = [
        'blog_category_id',
        'blog_sub_category_id',
        'product_name',
        'slug',
        'description',
        'short_description',
        'image',
        'image_url',
        'link',
        'affiliate_url',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
        'user_id'
    ];
    
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
    
    public function subCategory()
    {
        return $this->belongsTo(BlogSubCategory::class, 'blog_sub_category_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
