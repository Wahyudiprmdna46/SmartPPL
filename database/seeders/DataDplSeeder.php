<?php

namespace Database\Seeders;

use App\Models\DataDpl;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataDplSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataDpl::updateOrCreate(
            ['nip' => '1122334455'], // Cek apakah NIP ini sudah ada
            [
                "nama" => "Prof. Dr. Zulfani Sesmiarni, S.Pd, M.Pd",
                "golongan" => "IV/C",
                "jabatan" => "Lektor Kepala",
                "jenis_kelamin" => "P",
            ]
        );
    }
}
