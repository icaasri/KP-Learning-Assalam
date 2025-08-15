<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jurusan::create([
            'nama_jurusan' => 'Pengembangan Perangkat Lunak dan Gim',
            'singkatan' => 'PPLG',
        ]);
        Jurusan::create([
            'nama_jurusan' => 'Manajemen Perkantoran dan Layanan Bisnis',
            'singkatan' => 'MPLB',
        ]);
        Jurusan::create([
            'nama_jurusan' => 'Teknik Kendaraan Ringan dan Otomotif',
            'singkatan' => 'TKRO',
        ]);
        Jurusan::create([
            'nama_jurusan' => 'Teknik dan Bisnis Sepeda Motor',
            'singkatan' => 'TBSM',
        ]);
        Jurusan::create([
            'nama_jurusan' => 'Geologi Pertambangan',
            'singkatan' => 'GP',
        ]);
    }
}