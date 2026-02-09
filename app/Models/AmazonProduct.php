<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmazonProduct extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'amazon_category_id',
        'product_name',
        'description',
        'image',
        'link',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
        'user_id'
    ];
    
    public function category()
    {
        return $this->belongsTo(AmazonCategory::class, 'amazon_category_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
