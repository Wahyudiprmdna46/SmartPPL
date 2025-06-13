<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMahasiswa extends Model
{
    use HasFactory;


    protected $fillable = [
        "nim",
        "nama",
        "jenis_kelamin",
        "jurusan",
        "dpl_id",
        "sekolah_id",
        "pamong_id",
    ];

    // Relasi ke DataDpl
    public function dataDpl()
    {
        return $this->belongsTo(DataDpl::class, 'dpl_id');
    }

    // Relasi ke DataSekolah
    public function dataSekolah()
    {
        return $this->belongsTo(DataSekolah::class, 'sekolah_id');
    }

    // Relasi ke DataPamong
    public function dataPamong()
    {
        return $this->belongsTo(DataPamong::class, 'pamong_id');
    }

    public function laporanPpl()
    {
        return $this->hasMany(LaporanPpl::class, 'mahasiswa_id');
    }

    // relasi ke penilaian
    public function penilaian()
    {
        return $this->hasOne(Penilaian::class, 'mahasiswa_id');
    }

    // relasi ke penilaian
    public function penilaianDpl()
    {
        return $this->hasOne(PenilaianDpl::class, 'mahasiswa_id');
    }
}
