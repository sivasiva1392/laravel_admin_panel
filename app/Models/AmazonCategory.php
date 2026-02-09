<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmazonCategory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'category_name',
        'description',
        'image',
        'status',
        'user_id'
    ];
    
    public function products()
    {
        return $this->hasMany(AmazonProduct::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
