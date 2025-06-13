<?php

namespace App\Imports;

use App\Models\DataDpl;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataDplImport implements ToModel, WithHeadingRow
{
    use SkipsFailures;

    public function model(array $row)
    {

        // Jika nip kosong, lewati baris ini
        if (empty($row['nip'])) {
            return null;
        }

        // Cek apakah NIP sudah ada di database
        if (DataDpl::where('nip', $row['nip'])->exists()) {
            // Simpan error ke session flash (gunakan array agar bisa dikumpulkan semua)
            $dupes = Session::get('duplicate_error', []);
            $dupes[] = "NIP {$row['nip']} sudah ada di database.";
            Session::flash('duplicate_error', $dupes);

            return null;
        }

        return new DataDpl([
            'nip' => $row['nip'],
            'nama' => $row['nama'],
            'golongan' => $row['golongan'],
            'jabatan' => $row['jabatan'],
            'jenis_kelamin' => $row['jenis_kelamin'],
        ]);
    }
    
}
