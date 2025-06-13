<?php

namespace Database\Seeders;

use App\Models\DataSekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataSekolah::updateOrCreate(
            ['npsn' => "122344"],
            [
                "nama_sekolah" => "Smpn 7 Bukittinggi",
                "alamat" => "Jl.Kurai",
                "kota" => "Bukittinggi",
                "provinsi" => "Sumatera Barat",
                "latitude" => "-0.3106781114140952",
                "longitude" => "100.39052702433807",
            ]
        );
    }
}
