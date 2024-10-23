<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        Pegawai::create(['nama'=>'Prof. Dr. Ir. ANSAR SUYUTI, MT., IPU., ASEAN.Eng.', 'nip'=>'196712311992021001', 'pangkat_golongan_ruang_id' => 17]);
        Pegawai::create(['nama'=>'DR. Ir. MOHAMMAD MOCHSEN SIR, S.T., M.T.', 'nip'=>'196904071996031003', 'pangkat_golongan_ruang_id' => 13]);
        Pegawai::create(['nama'=>'DR.Eng. ARMIN LAWI, S.Si., M.Eng.', 'nip'=>'197204231995121001', 'pangkat_golongan_ruang_id' => 13]);
        Pegawai::create(['nama'=>'DR.Eng. INTAN SARI ARENI, S.T., M.T.', 'nip'=>'197502032000122002', 'pangkat_golongan_ruang_id' => 15]);
        Pegawai::create(['nama'=>'DR. ANDI ILHAM LATUNRA, M.Si.', 'nip'=>'196702071991031001', 'pangkat_golongan_ruang_id' => 14]);
        Pegawai::create(['nama'=>'DR. INDAR CHAERAH GUNADIN, S.T., M.T.', 'nip'=>'197311181998032001', 'pangkat_golongan_ruang_id' => 13]);

        Pegawai::create(['nama'=>'DR. Ir. Abdullah B., M.M.', 'nip'=>'196612311997031039', 'pangkat_golongan_ruang_id' => 10]);
        Pegawai::create(['nama'=>'PUTRI AYU MAHARANI, S.T., M.Sc.', 'nip'=>'199406112022032020', 'pangkat_golongan_ruang_id' => 10, 'program_studi_id' => 2]);
        Pegawai::create(['nama'=>'NAILI SURI INTIZHAMI, S.Kom., M.Kom.', 'nip'=>'199503082022032016', 'pangkat_golongan_ruang_id' => 10, 'program_studi_id' => 2]);
        Pegawai::create(['nama'=>'EKA QADRI NURANTI B., S.Kom., M.Kom.', 'nip'=>'199502082022032010', 'pangkat_golongan_ruang_id' => 10, 'program_studi_id' => 2]);
        Pegawai::create(['nama'=>'MARDHIYYAH RAFRIN, S.T., M.Sc.', 'nip'=>'199009212022032011', 'pangkat_golongan_ruang_id' => 10, 'program_studi_id' => 2]);
        Pegawai::create(['nama'=>'MUH. AGUS, S.Kom., M.Kom.', 'nip'=>'199508212022031011', 'pangkat_golongan_ruang_id' => 10, 'program_studi_id' => 2]);
        Pegawai::create(['nama'=>'NUR RAHMI, S.Pd., M.Si.', 'nip'=>'199210062022032015', 'pangkat_golongan_ruang_id' => 10, 'program_studi_id' => 1]);
        Pegawai::create(['nama'=>'WAHYUNI EKASASMITA, S.Pd., M.Sc.', 'nip'=>'199104132022032015', 'pangkat_golongan_ruang_id' => 10, 'program_studi_id' => 1]);
        Pegawai::create(['nama'=>'AHMAD FAJRI S., S.Si., M.Si.', 'nip'=>'199505082022031009', 'pangkat_golongan_ruang_id' => 10, 'program_studi_id' => 1]);
        Pegawai::create(['nama'=>'MIFTAHULKHAIRAH, M.Sc.', 'nip'=>'198809222022032002', 'pangkat_golongan_ruang_id' => 10, 'program_studi_id' => 1]);
        Pegawai::create(['nama'=>'NURUL FUADY ADHALIA H, S.Pd., M.Si.', 'nip'=>'199012102022032007', 'pangkat_golongan_ruang_id' => 10, 'program_studi_id' => 1]);
        Pegawai::create(['nama'=>'MAR\'ATUTTAHIRAH, S.Pd., M.T.', 'nip'=>'199407012022032017', 'pangkat_golongan_ruang_id' => 10, 'program_studi_id' => 3]);
        Pegawai::create(['nama'=>'ROSMIATI, S.Kom., M.Kom.', 'nip'=>'199003282022032006', 'pangkat_golongan_ruang_id' => 10, 'program_studi_id' => 3]);
        Pegawai::create(['nama'=>'KHAERA TUNNISA, S.Tr.Kom., M.Kom.', 'nip'=>'199605062022032021', 'pangkat_golongan_ruang_id' => 10, 'program_studi_id' => 3]);
        Pegawai::create(['nama'=>'RAKHMADI RAHMAN, M.Kom.', 'nip'=>'199003162022031006', 'pangkat_golongan_ruang_id' => 10, 'program_studi_id' => 3]);
        Pegawai::create(['nama'=>'ALVIAN TRI PUTRA DARTI AKHSA, S.Kom., M.Kom.', 'nip'=>'199402192022031007', 'pangkat_golongan_ruang_id' => 10, 'program_studi_id' => 3]);
        
        Pegawai::create(['nama'=>'MUH. ALIFAKHMI, S.Sos., M.M.', 'nip'=>'197708032006041008','pangkat_golongan_ruang_id'=>13]);
        Pegawai::create(['nama'=>'MUHAMMAD IRSYAD A. RAHMAN, S.E., M.Eng.', 'nip'=>'197310282006041010','pangkat_golongan_ruang_id'=>12]);
        Pegawai::create(['nama'=>'MULIANI BACO, S.E.', 'nip'=>'197809142007012016','pangkat_golongan_ruang_id'=>12]);
        Pegawai::create(['nama'=>'AMSIR, S.T.', 'nip'=>'197806272009041003','pangkat_golongan_ruang_id'=>12]);
        Pegawai::create(['nama'=>'LILIS, S.E., M.M.', 'nip'=>'198407072007011002','pangkat_golongan_ruang_id'=>11]);
        Pegawai::create(['nama'=>'SITTI MULYANA M, S.Pd.', 'nip'=>'198608012010012011','pangkat_golongan_ruang_id'=>9]);
        Pegawai::create(['nama'=>'DWIRATY SESARI WALALANGI, A.Md.', 'nip'=>'199103222022032011','pangkat_golongan_ruang_id'=>7]);
        Pegawai::create(['nama'=>'MUSFADLI, A.Ma.', 'nip'=>'198901252022031004','pangkat_golongan_ruang_id'=>7]);
        Pegawai::create(['nama'=>'HASMI SISWANTI HANDAYANI S, A.Ma., Ak.', 'nip'=>'200010222022032001','pangkat_golongan_ruang_id'=>7]);
        Pegawai::create(['nama'=>'AYU ANUGRAH, A.Ma., M', 'nip'=>'199901282022032010','pangkat_golongan_ruang_id'=>7]);

    }
}
