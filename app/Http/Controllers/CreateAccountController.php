<?php

namespace App\Http\Controllers;

use App\Imports\AdminsImport;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Svg\Tag\Rect;

class CreateAccountController extends Controller
{
    public function showImportForm()
    {
        return view('pages.accountadd.index');
    }


    public function importAccount(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);
    
        $file = $request->file('file');
        Excel::import(new AdminsImport, $file);
    
        return back()->with('success', 'Data berhasil diimpor!');
    }

    public function Account(Request $request){
        // Ambil data dari database
        $search = $request->input('search');

        $query = DB::table('admins');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('npsn', 'like', "%{$search}%");
            });
        }

        // $datadpls = $query->paginate(10)->withQueryString();
        $dataaccounts = $query->paginate(10);
        $dataaccounts->appends(request()->query());

        // Kirim ke view
        return view('pages.datausers.dataaccount.index', [
            "dataaccounts" => $dataaccounts,
        ]);
    }

    public function Create()
    {
        // Kirim ke view
        return view('pages.datausers.dataaccount.create');
    }

    public function Store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'nim' => 'nullable|string|max:7|unique:admins,nim',
            'nip' => 'nullable|string|max:18|unique:admins,nip',
            'nik' => 'nullable|string|max:16|unique:admins,nik',
            'npsn' => 'nullable|string|max:8|unique:admins,npsn',
            'role' => 'required|in:admin,dpl,mahasiswa,sekolah,pamong',
            'password' => 'required|min:5',
        ], [
            'name.required' => 'Nama harus diisi!',
            'name.string' => 'Nama harus berupa huruf!',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email sudah terdaftar!',
            'nim.max' => 'NIM maksimal 7 karakter',
            'nim.unique' => 'NIM sudah terdaftar, silakan gunakan NIM lain!',
            'nip.max' => 'NIP maksimal 18 karakter',
            'nip.unique' => 'NIP sudah terdaftar, silakan gunakan NIP lain!',
            'nik.max' => 'NIK maksimal 16 karakter',
            'nik.unique' => 'NIK sudah terdaftar, silakan gunakan NIK lain!',
            'npsn.max' => 'NPSN maksimal 8 karakter',
            'npsn.unique' => 'NPSN sudah terdaftar, silakan gunakan NPSN lain!',
            'password.required' => 'Password harus diisi!',
            'password.min' => 'PASSWORD minimal 5 karakter',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Admin::create($validated);

        // return redirect('/admin/datadpl');
        return redirect()->route('admin.account');
    }

    public function Edit($id)
    {
        $dataaccounts = Admin::findOrFail($id);

        // Kirim ke view
        return view('pages.datausers.dataaccount.edit', [
            "dataaccounts" => $dataaccounts,
        ]);
    }

    public function Update(Request $request, $id)
    {
        $dataaccounts = Admin::findOrFail($id);

        $validated = $request->validate([
            'nim' => [
                'nullable',
                'string',
                'max:7',
                Rule::unique('admins', 'nim')->ignore($dataaccounts->id),
            ],
            'nip' => [
                'nullable',
                'string',
                'max:18',
                Rule::unique('admins', 'nip')->ignore($dataaccounts->id),
            ],
            'nik' => [
                'nullable',
                'string',
                'max:16',
                Rule::unique('admins', 'nik')->ignore($dataaccounts->id),
            ],
            'npsn' => [
                'nullable',
                'string',
                'max:8',
                Rule::unique('admins', 'npsn')->ignore($dataaccounts->id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('admins', 'email')->ignore($dataaccounts->id),
            ],
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,dpl,mahasiswa,sekolah,pamong',
            'password' => 'required|min:5',
        ], [
            'name.required' => 'Nama harus diisi!',
            'name.string' => 'Nama harus berupa huruf!',
            'email.required' => 'Email harus diisi!',
            'email.email' => 'Format email tidak valid!',
            'email.unique' => 'Email sudah terdaftar!',
            'nim.max' => 'NIM maksimal 7 karakter',
            'nim.unique' => 'NIM sudah terdaftar, silakan gunakan NIM lain!',
            'nip.max' => 'NIP maksimal 18 karakter',
            'nip.unique' => 'NIP sudah terdaftar, silakan gunakan NIP lain!',
            'nik.max' => 'NIK maksimal 16 karakter',
            'nik.unique' => 'NIK sudah terdaftar, silakan gunakan NIK lain!',
            'npsn.max' => 'NPSN maksimal 8 karakter',
            'npsn.unique' => 'NPSN sudah terdaftar, silakan gunakan NPSN lain!',
            'password.required' => 'Password harus diisi!',
            'password.min' => 'PASSWORD minimal 5 karakter',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        
        $dataaccounts->update($validated);

        
        return redirect()->route('admin.account')->with('success', 'Account berhasil diperbarui!');
    }

    public function Delete($id)
    {
        $dataaccounts = Admin::findOrFail($id);
        $dataaccounts->delete();

        return redirect()->route('admin.account')->with('success', 'Account berhasil dihapus!');
    }
}
