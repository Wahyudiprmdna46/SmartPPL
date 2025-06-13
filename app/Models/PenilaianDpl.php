<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianDpl extends Model
{
    protected $table = 'penilaian_dpls'; // nama tabel

    protected $fillable = [
        'mahasiswa_id',
        'dpl_id',
        'persiapan_mengajar',
        'praktek_mengajar',
        'laporan_ppl',
        'nilai_akhir',
        'catatan',
    ];

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(DataMahasiswa::class, 'mahasiswa_id');
    }

    // Relasi ke DPL
    public function dpl()
    {
        return $this->belongsTo(DataDpl::class, 'dpl_id');
    }
}
