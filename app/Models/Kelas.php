<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function students()
    {
        return $this->hasMany(User::class);
    }
}
