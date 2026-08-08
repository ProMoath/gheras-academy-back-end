<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'file_url', 'placeholders', 'font_size', 'font_color', 'program_id'])]
class CertificateTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $attributes = [
        'font_size' => 16,
        'font_color' => '#000000',
    ];

    protected function casts(): array
    {
        return [
            'placeholders' => 'array',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
}
