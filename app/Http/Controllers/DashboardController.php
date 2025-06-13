<?php

namespace App\Http\Controllers;

use App\Models\DataDpl;
use App\Models\DataMahasiswa;
use App\Models\DataPamong;
use App\Models\DataSekolah;
use App\Models\presensi;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $user = Auth::guard('admin')->user(); // Mengambil user yang login

        // Inisialisasi jumlah mahasiswa
        $totalMahasiswa = 0;
        $totalSekolah = 0; // Inisialisasi awal
        $totalPamong = 0;
        $totalAbsen = 0;
        $totalTasks = 0;

        // Hitung jumlah mahasiswa berdasarkan role
        if ($user->role == 'admin') {
            $totalMahasiswa = DataMahasiswa::count();
        } elseif ($user->role == 'dpl') {
            // Ambil ID DPL berdasarkan NIP
            $dpl = DataDpl::where('nip', $user->nip)->first();
            if ($dpl) {
                $totalMahasiswa = DataMahasiswa::where('dpl_id', $dpl->id)->count();
            }
        } elseif ($user->role == 'sekolah') {
            // Ambil ID Sekolah berdasarkan NPSN
            $sekolah = DataSekolah::where('npsn', $user->npsn)->first();
            if ($sekolah) {
                $totalMahasiswa = DataMahasiswa::where('sekolah_id', $sekolah->id)->count();
            }
        } elseif ($user->role == 'pamong') {
            // Ambil ID Sekolah berdasarkan NIP dan NIK di Admins
            $pamong = DataPamong::where(function ($query) use ($user) {
                $query->where('nip', $user->nip)
                    ->orWhere('nip', $user->nik);
            })->first();

            if ($pamong) {
                $totalMahasiswa = DataMahasiswa::where('pamong_id', $pamong->id)->count();
            }
        }

        // menghitung jumlah tugas mahasiswa berdasarkan role
        if ($user->role == 'admin') {
            $totalTasks = Tasks::count();
        } elseif ($user->role === 'dpl') {
            $dpl = DataDpl::where('nip', $user->nip)->first();
            if ($dpl) {
                // Ambil semua NIM mahasiswa yang dpl_id = ID DPL sekarang
                $nims = DataMahasiswa::where('dpl_id', $dpl->id)->pluck('nim');

                // Hitung jumlah tasks yang nim-nya termasuk dalam daftar di atas
                $totalTasks = Tasks::whereIn('nim', $nims)->count();
            } else {
                $totalTasks = 0;
            }
        } elseif ($user->role === 'pamong') {
            $pamong = DataPamong::where(function ($query) use ($user) {
                $query->where('nip', $user->nip)
                    ->orWhere('nip', $user->nik);
            })->first();

            if ($pamong) {
                $nims = DataMahasiswa::where('pamong_id', $pamong->id)->pluck('nim');
                $totalTasks = Tasks::whereIn('nim', $nims)->count();
            } else {
                $totalTasks = 0;
            }
        } elseif ($user->role === 'sekolah') {
            $sekolah = DataSekolah::where('npsn', $user->npsn)->first();
            if ($sekolah) {
                $nims = DataMahasiswa::where('sekolah_id', $sekolah->id)->pluck('nim');
                $totalTask = Tasks::whereIn('nim', $nims)->count();
            } else {
                $totalTask = 0;
            }
        }

        // Menghitung jumlah Sekolah berdasarkan role
        if ($user->role == 'admin') {
            $totalSekolah = DataSekolah::count();
        } elseif ($user->role == 'dpl') {
            // Ambil ID DPL berdasarkan NIP
            $dpl = DataDpl::where('nip', $user->nip)->first();
            if ($dpl) {
                $totalSekolah = DataSekolah::where('dpl_id', $dpl->id)->count();
            }
        }

        // // Menghitung Jumlah absen mahasiswa berdasarkan role
        if ($user->role == 'dpl') {
            // Ambil ID DPL berdasarkan NIP user yang login
            $dpl = DataDpl::where('nip', $user->nip)->first();
            if ($dpl) {
                // Hitung jumlah presensi mahasiswa yang memiliki dpl_id sesuai dengan DPL yang login
                $totalAbsen = DB::table('presensis')
                    ->join('data_mahasiswas', 'presensis.nim', '=', 'data_mahasiswas.nim')
                    ->where('data_mahasiswas.dpl_id', $dpl->id)
                    ->count();
            } else {
                $totalAbsen = 0; // Jika DPL tidak ditemukan, set default 0
            }
        }

        // Menghitung jumlah DPL
        $totalDpl = DataDpl::count();
        // Menghitung jumlah Pamong 
        if ($user->role == 'admin') {
            $totalPamong = DataPamong::count();
        } elseif ($user->role == 'sekolah') {
            // Ambil ID Sekolah berdasarkan NPSN
            $sekolah = DataSekolah::where('npsn', $user->npsn)->first();
            if ($sekolah) {
                $totalPamong = DataPamong::where('sekolah_id', $sekolah->id)->count();
            }
        } elseif ($user->role == 'dpl') {
            $dpl = DataDpl::where('nip', $user->nip)->first();

            if ($dpl) {
                // Hitung jumlah pamong melalui relasi sekolah yang punya dpl_id sesuai
                $totalPamong = DataPamong::whereHas('dataSekolah', function ($query) use ($dpl) {
                    $query->where('dpl_id', $dpl->id);
                })->count();
            } else {
                $totalPamong = 0;
            }
        }

        $hariini = date("Y-m-d");
        $bulanini = date("m") * 1;
        $tahunini = date("Y");
        $nim = Auth::guard('admin')->user()->nim;
        $presensihariini = DB::table('presensis')->where('nim', $nim)->where('tgl_presensi', $hariini)->where('nim', $nim)->first();
        $historibulanini = DB::table('presensis')
            ->where('nim', $nim)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
            ->orderBy('tgl_presensi')
            ->get();

        $rekappresensi = DB::table('presensis')
            ->selectRaw('COUNT(nim) as jmlhadir, SUM(IF(jam_in > "07:30",1,0)) as jmlterlambat')
            ->where('nim', $nim)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
            ->first();

        $leaderboardQuery = DB::table('presensis')
            ->join('data_mahasiswas', 'presensis.nim', '=', 'data_mahasiswas.nim')
            ->join('data_sekolahs', 'data_mahasiswas.sekolah_id', '=', 'data_sekolahs.id')
            ->where('presensis.tgl_presensi', $hariini)
            ->select(
                'presensis.nim',
                'data_mahasiswas.nama',
                'data_sekolahs.nama_sekolah',
                'presensis.tgl_presensi',
                'presensis.jam_in',
                'presensis.jam_out',
                'presensis.lokasi_in',
                'presensis.lokasi_out',
                'presensis.foto_in'
            );

        if ($user->role === 'dpl') {
            $dpl = DataDpl::where('nip', $user->nip)->first();
            if ($dpl) {
                $leaderboardQuery->where('data_mahasiswas.dpl_id', $dpl->id);
            }
        } elseif ($user->role === 'sekolah') {
            $sekolah = DataSekolah::where('npsn', $user->npsn)->first();
            if ($sekolah) {
                $leaderboardQuery->where('data_mahasiswas.sekolah_id', $sekolah->id);
            }
        } elseif ($user->role === 'pamong') {
            $pamong = DataPamong::where(function ($query) use ($user) {
                $query->where('nip', $user->nip)
                    ->orWhere('nip', $user->nik);
            })->first();
            if ($pamong) {
                $leaderboardQuery->where('data_mahasiswas.pamong_id', $pamong->id);
            }
        }

        $leaderboard = $leaderboardQuery->orderBy('presensis.jam_in')->get();


        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Noveber", "Desember"];

        //untuk gis map sekolah
        $sekolahs = DataSekolah::withCount('dataMahasiswa')->get();

        return view('dashboard', compact(
            'presensihariini',
            'historibulanini',
            'namabulan',
            'bulanini',
            'tahunini',
            'rekappresensi',
            'leaderboard',
            'totalDpl',
            'totalMahasiswa',
            'totalSekolah',
            'totalPamong',
            'totalAbsen',
            'totalTasks',
            'sekolahs',
        ));
    }
}