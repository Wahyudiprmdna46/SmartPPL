<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KebutuhanPpl extends Model
{
    use HasFactory;
    protected $fillable = ['sekolah_id', 'tahun_ajaran', 'jurusan', 'jumlah_mahasiswa'];

    public const JURUSAN_LIST = ['PAI', 'PBA', 'PBI', 'PMTK', 'PTIK', 'BK'];
    
    public function sekolah()
    {
        return $this->belongsTo(DataSekolah::class, 'sekolah_id', 'id');
    }
}
