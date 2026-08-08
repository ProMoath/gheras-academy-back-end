<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'lesson_id', 'watched_percentage', 'last_position', 'first_watched_at', 'last_watched_at', 'completed_at'])]
class LessonProgress extends Model
{
    use HasFactory, SoftDeletes;

    protected $attributes = [
        'watched_percentage' => 0,
        'last_position' => 0,
    ];

    protected function casts(): array
    {
        return [
            'first_watched_at' => 'datetime',
            'last_watched_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
