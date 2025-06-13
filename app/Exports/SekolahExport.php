<?php

namespace App\Exports;

use App\Models\DataSekolah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SekolahExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return DataSekolah::all();
        return DataSekolah::with('dataDpl')->get()->map(function ($sklh) {
            return [
                'npsn' => $sklh->npsn,
                'nama_sekolah' => $sklh->nama_sekolah,
                'dpl' => optional($sklh->dataDpl)->nama ?? '-',
                'alamat' => $sklh->alamat,
                'kota' => $sklh->kota,
                'provinsi' => $sklh->provinsi,
                'latitude' => $sklh->latitude ?? '-',
                'longitude' => $sklh->longitude ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NPSN',
            'Nama Sekolah',
            'Nama DPL',
            'Alamat',
            'Kota',
            'Provinsi',
            'Latitude',
            'Longitude',
        ];
    }
}
