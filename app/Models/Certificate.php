<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'program_id', 'template_id', 'certificate_number', 'issued_at', 'is_manual', 'issued_by'])]
class Certificate extends Model
{
    use HasFactory, SoftDeletes;

    protected $attributes = [
        'is_manual' => false,
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
            'is_manual' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(CertificateTemplate::class, 'template_id');
    }

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}
