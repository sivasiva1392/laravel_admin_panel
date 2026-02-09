<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lms extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'lms_category_id',
        'title',
        'description',
        'document',
        'status',
        'user_id'
    ];
    
    public function category()
    {
        return $this->belongsTo(LmsCategory::class, 'lms_category_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
