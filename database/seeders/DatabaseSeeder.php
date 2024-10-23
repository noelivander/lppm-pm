<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Pengumuman;
use App\Models\Berita;
use App\Models\LabelDokumenPenting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create(); 

        // $user = User::factory()->create([
        //             'name' => 'Admin',
        //             'email' => 'adm-lppm@ith.ac.id',
        //             'password' => bcrypt('Parepare01'),
        //             'remember_token' => Str::random(10)
        //         ]);

        $this->call(GolonganSeeder::class);
        $this->call(ProgramStudiSeeder::class);
        $this->call(PegawaiSeeder::class);
        $this->call(PpmSeeder::class);
        $this->call(RelatedLinkSeeder::class);

        $this->call(DokumenPentingSeeder::class);

        // Berita::factory()->count(5)->for($user)->create();
        // Pengumuman::factory()->count(5)->for($user)->create();
            $this->call([
        UserSeeder::class,
        // Seeder lainnya dapat ditambahkan di sini
    ]);

        
    }
    
}
