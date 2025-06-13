<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPpl extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'data_mahasiswa_id',
        'sekolah_id',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function dataMahasiswa()
    {
        return $this->belongsTo(DataMahasiswa::class, 'data_mahasiswa_id');
    }

    public function sekolah()
    {
        return $this->belongsTo(DataSekolah::class, 'sekolah_id');
    }
}
