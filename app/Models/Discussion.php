<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Discussion extends Model
{
	use Searchable;
	
    protected $fillable = [
        'title',
        'slug',
        'category',
        'content',
        'member'
    ];
}
