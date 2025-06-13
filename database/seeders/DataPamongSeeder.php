<?php

namespace Database\Seeders;

use App\Models\DataPamong;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataPamongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataPamong::updateOrCreate(
            [
                'nip' => "112334"
            ],
            [
                "nama" => "Azrini, S.Pd",
                "golongan" => "X",
                "jabatan" => "Guru",
                "sekolah_id" => "1",
            ]
        );
    }
}
