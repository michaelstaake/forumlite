<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Laravel\Scout\Attributes\SearchUsingFullText;

class Comment extends Model
{
	use Searchable;
	
    protected $fillable = [
        'discussion',
        'category',
        'member',
        'content'
    ];

       /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    #[SearchUsingFullText(['content'])]
    public function toSearchableArray(): array
    {
        return [
            'content' => $this->content,
        ];
    }
}
