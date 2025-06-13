<?php

namespace App\Http\Controllers;

use App\Models\DataDpl;
use App\Models\DataMahasiswa;
use App\Models\DataPamong;
use App\Models\DataSekolah;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate as FacadesGate;

class TasksController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admin')->user(); // default pakai guard admin
        $role = $user->role;
        $tasks = collect(); // Default kosong

        if ($role === 'dpl') {
            // Cari data_dpl berdasarkan nip
            $dpl = DataDpl::where('nip', $user->nip)->first();

            if ($dpl) {
                $nims = DataMahasiswa::where('dpl_id', $dpl->id)->pluck('nim');
                $tasks = Tasks::whereIn('nim', $nims)->paginate(10);
            }
        } elseif ($role === 'pamong') {
            $pamong = DataPamong::where(function ($query) use ($user) {
                $query->where('nip', $user->nip)
                      ->orWhere('nip', $user->nik);
            })->first();

            if ($pamong) {
                $nims = DataMahasiswa::where('pamong_id', $pamong->id)->pluck('nim');
                $tasks = Tasks::whereIn('nim', $nims)->paginate(10);
            }
        } elseif ($role === 'sekolah') {
            $sekolah = DataSekolah::where('npsn', $user->npsn)->first();

            if ($sekolah) {
                $nims = DataMahasiswa::where('sekolah_id', $sekolah->id)->pluck('nim');
                $tasks = Tasks::whereIn('nim', $nims)->paginate(10);
            }
        } elseif ($role === 'mahasiswa') {
            $tasks = Tasks::where('nim', $user->nim)->paginate(10); // hanya tugas sendiri
        } else {
            $tasks = Tasks::paginate(10); // default: semua data
        }


        return view('pages.tasks.index', [
            "tasks" => $tasks,
            'isMahasiswa' => $role === 'mahasiswa',
            'isAdminMahasiswa' => in_array($role, ['admin', 'mahasiswa']),
        ]);
    }

    // Proses simpan tugas
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tasks' => 'required|string'
        ]);

        $user = Auth::user(); // ambil user yang login

        // Cek apakah mahasiswa sudah pernah upload tugas
        $existingTask = Tasks::where('nim', $user->nim)->first();
        if ($existingTask) {
            return redirect()->route('tasks.index')->with([
                'error' => 'Anda sudah mengupload tugas. Tidak bisa upload lebih dari satu kali.',
                // 'open_modal' => true
            ]);
        }

        $nimAwal = substr($user->nim, 0, 2); // ambil 2 digit awal NIM

        // tabel tasks tidak ada field jurusan, Mapping jurusan dari nim
        $jurusanMap = [
            '21' => 'PAI',
            '22' => 'PBA',
            '23' => 'PBI',
            '24' => 'PMTK',
            '25' => 'PTIK',
            '26' => 'BK',
        ];

        $jurusan = $jurusanMap[$nimAwal] ?? 'Tidak Diketahui';

        // Simpan ke database pakai Eloquent
        Tasks::create([
            'nim'     => $user->nim,
            'nama'    => $user->name, // atau $user->nama
            'jurusan' => $jurusan,
            'link' => $validated['tasks']
        ]);

        return redirect()->route('tasks.index')->with([
            'success' => 'Tugas berhasil diupload!',
            // 'open_modal' => true
        ]);
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $tasks = Tasks::findOrFail($id);
        return view('pages.tasks.edit', [
            "tasks" => $tasks,
        ]);
    }

    // Proses update
    public function update(Request $request, $id)
    {
        $task = Tasks::findOrFail($id);

        $validated = $request->validate([
            'link' => 'required|string'
        ], [
            'link.required' => 'Link harus diisi!',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    // proses delete
    public function delete($id)
    {
        $task = Tasks::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus!');
    }
}