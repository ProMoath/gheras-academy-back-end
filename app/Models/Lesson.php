<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'description', 'video_url', 'video_source', 'text_content', 'pdf_url', 'duration', 'order_index', 'is_sequential', 'required_completion', 'course_id'])]
class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $attributes = [
        'video_source' => 'youtube',
        'is_sequential' => true,
        'required_completion' => 80,
        'order_index' => 0,
        'duration' => 0,
    ];

    protected function casts(): array
    {
        return [
            'is_sequential' => 'boolean',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }
}
