<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPamong extends Model
{
    use HasFactory;


    protected $fillable = [
        "nip",
        "nama",
        "jenis_kelamin",
        "golongan",
        "jabatan",
        "sekolah_id",
    ];

    public function dataSekolah()
    {
        return $this->belongsTo(DataSekolah::class, 'sekolah_id');
    }

    public function dataMahasiswa()
    {
        return $this->hasMany(DataMahasiswa::class, 'pamong_id');
    }

    public function laporanPpl()
    {
        return $this->hasOne(LaporanPpl::class, 'pamong_id');
    }
}
