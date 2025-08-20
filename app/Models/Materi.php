<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materi extends Model
{
    use HasFactory;

    /**
     * Mengizinkan semua kolom untuk diisi secara massal.
     */
    protected $guarded = [];

    /**
     * Mendefinisikan relasi "satu materi milik satu kelas".
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Mendefinisikan relasi "satu materi dibuat oleh satu guru".
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
