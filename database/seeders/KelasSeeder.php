<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusans = Jurusan::all();
        $tingkat = ['10', '11', '12'];
        $namaKelas = ['A', 'B'];

        foreach ($jurusans as $jurusan) {
            foreach ($tingkat as $t) {
                foreach ($namaKelas as $nk) {
                    Kelas::create([
                        'jurusan_id' => $jurusan->id,
                        'tingkat' => $t,
                        'nama_kelas' => $nk,
                    ]);
                }
            }
        }
    }
}