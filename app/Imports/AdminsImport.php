<?php

namespace App\Imports;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdminsImport implements ToModel, WithHeadingRow
{
    
    public function model(array $row)
    {
        $dupes = Session::get('duplicate_error', []);

        // Cek duplikat per kolom
        if (!empty($row['name']) && Admin::where('name', $row['name'])->exists()) {
            $dupes[] = "Nama '{$row['name']}' sudah ada di database.";
        }
        if (!empty($row['email']) && Admin::where('email', $row['email'])->exists()) {
            $dupes[] = "Email '{$row['email']}' sudah ada di database.";
        }

        if (!empty($row['nip']) && Admin::where('nip', $row['nip'])->exists()) {
            $dupes[] = "NIP '{$row['nip']}' sudah ada di database.";
        }

        if (!empty($row['nim']) && Admin::where('nim', $row['nim'])->exists()) {
            $dupes[] = "NIM '{$row['nim']}' sudah ada di database.";
        }

        if (!empty($row['nik']) && Admin::where('nik', $row['nik'])->exists()) {
            $dupes[] = "NIK '{$row['nik']}' sudah ada di database.";
        }

        if (!empty($row['npsn']) && Admin::where('npsn', $row['npsn'])->exists()) {
            $dupes[] = "NPSN '{$row['npsn']}' sudah ada di database.";
        }

        if (!empty($dupes)) {
            Session::flash('duplicate_error', $dupes);
            return null; // Jangan import baris ini
        }

        return new Admin([
            'name' => $row['name'],
            'email' => $row['email'],
            'nim' => $row['nim'] ?? null,
            'nip' => $row['nip'] ?? null,
            'nik' => $row['nik'] ?? null,
            'npsn' => $row['npsn'] ?? null,
            'role' => $row['role'],
            'password' => Hash::make($row['password']),
        ]);
    }
}
