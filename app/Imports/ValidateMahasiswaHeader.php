<?php

namespace App\Imports;

use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ValidateMahasiswaHeader implements OnEachRow, WithHeadingRow
{
    public $isValid = true;
    public $errors = [];

    private $expectedHeaders = ['nim', 'nama', 'jenis_kelamin', 'nip_dpl', 'npsn_sekolah', 'nip_pamong'];

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
