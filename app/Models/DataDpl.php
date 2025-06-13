<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDpl extends Model
{
    use HasFactory;

    protected $fillable = [
        "nip",
        "nama",
        "golongan",
        "jabatan",
        "jenis_kelamin",
    ];

    public function dataMahasiswa()
    {
        return $this->hasMany(DataMahasiswa::class, 'dpl_id');
    }

    public function dataSekolah()
    {
        return $this->hasMany(DataMahasiswa::class, 'dpl_id');
    }

    public function laporanPpl()
    {
        return $this->hasMany(DataMahasiswa::class, 'dpl_id');
    }
}
