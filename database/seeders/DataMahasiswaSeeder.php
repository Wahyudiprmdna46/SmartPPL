<?php

namespace Database\Seeders;

use App\Models\DataMahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataMahasiswa::create([
            "nim"=>"2521012",
            "nama"=>"wahyudi primadana",
            "jenis_kelamin"=>"L",
            "jurusan"=>"PTIK",
            "dpl_id"=>"1",
            "sekolah_id"=>"1",
            "pamong_id"=>"1",
        ]);
    }
}
