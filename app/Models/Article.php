<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'authors',
        'category_id',
        'abstract',
        'keywords',
        'content',
        'pdf_file',
        'publication_date',
        'status',
    ];

    protected $casts = [
        'publication_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
