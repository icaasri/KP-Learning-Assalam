<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder lain
        $this->call([
            JurusanSeeder::class,
            KelasSeeder::class,
        ]);

        // Buat 1 Admin
        User::create([
            'name' => 'Admin Sekolah',
            'username' => 'admin',
            'email' => 'admin@assalam.sch.id',
            'password' => Hash::make('password'), // passwordnya: password
            'role' => 'admin',
            'kelas_id' => null, // Admin tidak punya kelas
        ]);

        // Buat 2 Guru
        User::create([
            'name' => 'Budi Guru',
            'username' => 'budiguru',
            'email' => 'budi@assalam.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'kelas_id' => null, // Guru tidak terikat pada satu kelas saja
        ]);

        User::create([
            'name' => 'Ani Guru',
            'username' => 'aniguru',
            'email' => 'ani@assalam.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'kelas_id' => null,
        ]);

        // Buat 1 Siswa di kelas 10 PPLG A (kelas_id = 1)
        User::create([
            'name' => 'Siti Siswa',
            'username' => 'siti',
            'email' => 'siti@siswa.assalam.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'kelas_id' => 1, // Asumsi kelas 10 PPLG A punya id=1
        ]);

         // Buat 1 Siswa di kelas 11 MPLB B (kelas_id = 10)
         User::create([
            'name' => 'Joko Siswa',
            'username' => 'joko',
            'email' => 'joko@siswa.assalam.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'kelas_id' => 10, // Asumsi kelas 11 MPLB B punya id=10
        ]);
    }
}