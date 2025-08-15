<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
public function kelas()
{
    return $this->hasMany(Kelas::class);
}
}
