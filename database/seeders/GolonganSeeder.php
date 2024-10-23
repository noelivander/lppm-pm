<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PangkatGolonganRuang;

class GolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PangkatGolonganRuang::create(['kode' => 'i-a', 'pangkat' => 'Juru Muda', 'golongan' => 'I', 'ruang' => 'a']); #1
        PangkatGolonganRuang::create(['kode' => 'i-b', 'pangkat' => 'Juru Muda Tingkat I', 'golongan' => 'I', 'ruang' => 'b']);
        PangkatGolonganRuang::create(['kode' => 'i-c', 'pangkat' => 'Juru', 'golongan' => 'I', 'ruang' => 'c']);
        PangkatGolonganRuang::create(['kode' => 'i-d', 'pangkat' => 'Juru Tingkat I', 'golongan' => 'I', 'ruang' => 'd']);

        PangkatGolonganRuang::create(['kode' => 'ii-a', 'pangkat' => 'Pengatur Muda', 'golongan' => 'II', 'ruang' => 'a']); #5
        PangkatGolonganRuang::create(['kode' => 'ii-b', 'pangkat' => 'Pengatur Muda Tingkat I', 'golongan' => 'II', 'ruang' => 'b']);
        PangkatGolonganRuang::create(['kode' => 'ii-c', 'pangkat' => 'Pengatur', 'golongan' => 'II', 'ruang' => 'c']);
        PangkatGolonganRuang::create(['kode' => 'ii-d', 'pangkat' => 'Pengatur Tingkat I', 'golongan' => 'II', 'ruang' => 'd']);

        PangkatGolonganRuang::create(['kode' => 'iii-a', 'pangkat' => 'Penata Muda', 'golongan' => 'III', 'ruang' => 'a']); #9
        PangkatGolonganRuang::create(['kode' => 'iii-b', 'pangkat' => 'Penata Muda Tingkat I', 'golongan' => 'III', 'ruang' => 'b']);
        PangkatGolonganRuang::create(['kode' => 'iii-c', 'pangkat' => 'Penata', 'golongan' => 'III', 'ruang' => 'c']);
        PangkatGolonganRuang::create(['kode' => 'iii-d', 'pangkat' => 'Penata Tingkat I', 'golongan' => 'III', 'ruang' => 'd']);

        PangkatGolonganRuang::create(['kode' => 'iv-a', 'pangkat' => 'Pembina', 'golongan' => 'IV', 'ruang' => 'a']); #13
        PangkatGolonganRuang::create(['kode' => 'iv-b', 'pangkat' => 'Pembina Tingkat I', 'golongan' => 'IV', 'ruang' => 'b']);
        PangkatGolonganRuang::create(['kode' => 'iv-c', 'pangkat' => 'Pembina Utama Muda', 'golongan' => 'IV', 'ruang' => 'c']);
        PangkatGolonganRuang::create(['kode' => 'iv-d', 'pangkat' => 'Pembina Utama Madya', 'golongan' => 'IV', 'ruang' => 'd']);
        PangkatGolonganRuang::create(['kode' => 'iv-e', 'pangkat' => 'Pembina Utama', 'golongan' => 'IV', 'ruang' => 'e']); #17
    }
}
