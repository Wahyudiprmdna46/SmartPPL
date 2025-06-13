<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSekolah extends Model
{
    use HasFactory;


    protected $fillable = [
        "npsn",
        "nama_sekolah",
        "dpl_id",
        "alamat",
        "kota",
        "provinsi",
        "latitude",
        "longitude",
    ];
    
    // Relasi: 1 sekolah hanya memiliki 1 DPL
    public function dataDpl()
    {
        return $this->belongsTo(DataDpl::class, 'dpl_id');
    }

    public function dataPamong()
    {
        return $this->hasMany(DataPamong::class, 'sekolah_id');
    }

    public function dataMahasiswa()
    {
        return $this->hasMany(DataMahasiswa::class, 'sekolah_id');
    }
    public function laporanPpl()
    {
        return $this->hasMany(LaporanPpl::class, 'sekolah_id');
    }

}
