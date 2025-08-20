<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;

    /**
     * Mengizinkan semua kolom untuk diisi secara massal.
     */
    protected $guarded = [];

    /**
     * Mendefinisikan relasi "satu jawaban milik satu pertanyaan".
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
