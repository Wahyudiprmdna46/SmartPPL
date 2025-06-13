<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPpl extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_tugas', // Hanya ini yang bisa diedit oleh mahasiswa
    ];

    protected $guarded = [
        'id_laporan',
        'mahasiswa_id',
        'sekolah_id',
        'pamong_id',
        'dpl_id',
        'status',
        'komentar',
        'created_at',
        'updated_at'
    ];

    // Relasi ke tabel Sekolah
    public function dataSekolah()
    {
        return $this->belongsTo(DataSekolah::class, 'sekolah_id');
    }

    // Relasi ke DataPamong
    public function dataPamong()
    {
        return $this->belongsTo(DataPamong::class, 'pamong_id');
    }

    // Relasi ke tabel DPL
    public function dataDpl()
    {
        return $this->belongsTo(DataDpl::class, 'dpl_id');
    }

    // Relasi ke tabel Mahasiswa
    public function dataMahasiswa()
    {
        return $this->belongsTo(DataMahasiswa::class, 'mahasiswa_id');
    }
}
