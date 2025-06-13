<?php

namespace App\Imports;

use App\Models\DataDpl;
use App\Models\DataMahasiswa;
use App\Models\DataPamong;
use App\Models\DataSekolah;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataMahasiswaImport implements ToModel, WithHeadingRow
{
    use SkipsFailures;

    public function model(array $row)
    {
        // Mencari DataDpl berdasarkan nip
        $dpl = DataDpl::where('nip', $row['nip_dpl'])->first();

        // Mencari DataSekolah berdasarkan npsn
        $sekolah = DataSekolah::where('npsn', $row['npsn_sekolah'])->first();

        // Mencari DataPamong berdasarkan nip
        $pamong = DataPamong::where('nip', $row['nip_pamong'])->first();

        // Cek apakah NIP sudah ada di database
        if (DataMahasiswa::where('nim', $row['nim'])->exists()) {
            // Simpan error ke session flash (gunakan array agar bisa dikumpulkan semua)
            $dupes = Session::get('duplicate_error', []);
            $dupes[] = "NIM {$row['nim']} sudah ada di database.";
            Session::flash('duplicate_error', $dupes);

            return null;
        }

        // $kode = substr($row[2], 0, 2); // contoh jika NIM di kolom C
        $kode = substr($row['nim'], 0, 2);
        $jurusan = match ($kode) {
            '21' => 'PAI',
            '22' => 'PBA',
            '23' => 'PBI',
            '24' => 'PMTK',
            '25' => 'PTIK',
            default => 'BK',
        };

        return new DataMahasiswa([
            'nim' => $row['nim'],
            'nama' => $row['nama'],
            'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
            'jurusan' => $jurusan,
            'dpl_id' => $dpl?->id,
            'sekolah_id' => $sekolah?->id,
            'pamong_id' => $pamong?->id,
        ]);
    }
}
