<?php

namespace App\Imports;

use App\Models\DataDpl;
use App\Models\DataSekolah;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataSekolahImport implements ToModel, WithHeadingRow
{
    use SkipsFailures;

    public function model(array $row)
    {

        // Mencari DataDpl berdasarkan nama
        $dpl = DataDpl::where('nip', $row['nip_dpl'])->first();

        // Cek apakah NPSN sudah ada di database
        if (DataSekolah::where('npsn', $row['npsn'])->exists()) {
            // Simpan error ke session flash (gunakan array agar bisa dikumpulkan semua)
            $dupes = Session::get('duplicate_error', []);
            $dupes[] = "NPSN {$row['npsn']} sudah ada di database.";
            Session::flash('duplicate_error', $dupes);

            return null;
        }

        return new DataSekolah([
            'npsn' => $row['npsn'],
            'nama_sekolah' => $row['nama_sekolah'],
            'dpl_id' => $dpl?->id,
            'alamat' => $row['alamat'],
            'kota' => $row['kota'],
            'provinsi' => $row['provinsi'],
            'latitude' => $row['latitude'] ?? null,
            'longitude' => $row['longitude'] ?? null,
        ]);
    }
}
