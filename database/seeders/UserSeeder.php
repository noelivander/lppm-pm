<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'adm-lppm@ith.ac.id',
                'email_verified_at' => now(),
                'password' => Hash::make('Parepare01'),
                'remember_token' => Str::random(10),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::table('users')->insert([
            [
                'name' => 'Dosen',
                'email' => 'dos-lppm@ith.ac.id',
                'email_verified_at' => now(),
                'password' => Hash::make('Parepare01'),
                'remember_token' => Str::random(10),
                'role' => 'dosen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::table('users')->insert([
            [
                'name' => 'Reviewer',
                'email' => 'rev-lppm@ith.ac.id',
                'email_verified_at' => now(),
                'password' => Hash::make('Parepare01'),
                'remember_token' => Str::random(10),
                'role' => 'reviewer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::table('users')->insert([
            [
                'name' => 'Auditor',
                'email' => 'aud-lppm@ith.ac.id',
                'email_verified_at' => now(),
                'password' => Hash::make('Parepare01'),
                'remember_token' => Str::random(10),
                'role' => 'auditor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
