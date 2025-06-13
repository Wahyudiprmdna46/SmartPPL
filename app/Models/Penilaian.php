<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'persiapan_mengajar',
        'praktek_mengajar',
        'laporan_ppl',
        'nilai_akhir',
        'catatan',
    ];

    public function dataMahasiswa()
    {
        return $this->belongsTo(DataMahasiswa::class, 'mahasiswa_id');
    }
}
