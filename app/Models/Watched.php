<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watched extends Model
{
    use HasFactory;

    protected $table = 'watched';

    protected $fillable = [
        'member',
        'discussion'
    ];
}
