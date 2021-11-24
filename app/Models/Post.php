<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'caption',
        'image',
    ];

    protected $with = ['user'];

    public function getImageAttribute($value) //Accessor
    {
        return '/storage/' . $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
