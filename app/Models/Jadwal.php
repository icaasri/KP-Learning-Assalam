<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    use HasFactory;

    /**
     * Mengizinkan semua kolom untuk diisi secara massal.
     * Ini akan memperbaiki error 'MassAssignmentException'.
     */
    protected $guarded = [];

    /**
     * Mendefinisikan relasi "satu jadwal milik satu kelas".
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Mendefinisikan relasi "satu jadwal diajar oleh satu guru".
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}