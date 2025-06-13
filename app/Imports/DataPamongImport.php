<?php

namespace App\Imports;

use App\Models\DataPamong;
use App\Models\DataSekolah;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataPamongImport implements ToModel, WithHeadingRow
{
    use SkipsFailures;

    public function model(array $row)
    {
        // Mencari DataSekolah berdasarkan npsn
        $sekolah = DataSekolah::where('npsn', $row['npsn_sekolah'])->first();

        // Cek apakah NIP sudah ada di database
        if (DataPamong::where('nip', $row['nip_atau_nik'])->exists()) {
            // Simpan error ke session flash (gunakan array agar bisa dikumpulkan semua)
            $dupes = Session::get('duplicate_error', []);
            $dupes[] = "NIP {$row['nip_atau_nik']} sudah ada di database.";
            Session::flash('duplicate_error', $dupes);

            return null;
        }

        return new DataPamong([
            'nip' => $row['nip_atau_nik'],
            'nama' => $row['nama'],
            'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
            'golongan' => $row['golongan'] ?? null,
            'jabatan' => $row['jabatan'] ?? null,
            'sekolah_id' => $sekolah?->id,
        ]);
    
    }
}
