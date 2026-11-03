<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'authors',
        'category_id',
        'abstract',
        'keywords',
        'content',
        'pdf_file',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    // Relation to user who submitted
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation to category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relation to admin who reviewed
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
