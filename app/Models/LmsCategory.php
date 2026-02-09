<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LmsCategory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'category_name',
        'status',
        'user_id'
    ];
    
    public function lms()
    {
        return $this->hasMany(Lms::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
