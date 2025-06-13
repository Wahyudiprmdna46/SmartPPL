<?php

namespace App\Imports;

use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ValidatePamongHeader implements OnEachRow, WithHeadingRow
{
    public $isValid = true;
    public $errors = [];

    private $expectedHeaders = ['nip_atau_nik', 'nama', 'jenis_kelamin', 'golongan', 'jabatan', 'npsn_sekolah'];

    public function onRow(Row $row)
    {
        if ($row->getIndex() === 1) {
            $headers = array_keys($row->toArray());

            foreach ($this->expectedHeaders as $header) {
                if (!in_array($header, $headers)) {
                    $this->isValid = false;
                    $this->errors[] = "Kolom \"$header\" tidak ditemukan di file Excel.";
                }
            }
        }
    }
}
