<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'parent',
        'section',
        'name',
        'description',
        'slug',
        'order',
        'is_readonly',
        'is_hidden',
    ];
}
