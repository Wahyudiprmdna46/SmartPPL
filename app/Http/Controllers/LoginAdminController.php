<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

    public function FormLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $loginField = $request->input('login'); // Bisa email, NIM, NIP, NIK, atau NPSN

        // Tentukan jenis input yang diberikan
        if (filter_var($loginField, FILTER_VALIDATE_EMAIL)) {
            $fieldType = 'email';
        } elseif (is_numeric($loginField)) {
            // Jika angka, tentukan apakah itu NIM, NIP, NIK, atau NPSN berdasarkan panjangnya
            $length = strlen($loginField);

            if ($length === 16) {
                $fieldType = 'nik';
            } elseif ($length === 18) {
                $fieldType = 'nip';
            } elseif ($length === 7 || $length === 8) {
                // Cek urutan: nim > npsn
                if (Admin::where('nim', $loginField)->exists()) {
                    $fieldType = 'nim';
                } elseif (Admin::where('npsn', $loginField)->exists()) {
                    $fieldType = 'npsn';
                } else {
                    return back()->withErrors(['login' => 'Akun tidak ditemukan.']);
                }
            } else {
                return back()->withErrors(['login' => 'Panjang angka tidak sesuai format login yang dikenal.']);
            }
        } else {
            return back()->withErrors(['login' => 'Format login tidak valid. Gunakan Email, NIM, NIP, atau NPSN.']);
        }

        // Validasi input sesuai dengan field yang dipilih
        $credentials = $request->validate([
            'login' => 'required|exists:admins,' . $fieldType,
            'password' => 'required'
        ], [
            'login.exists' => 'Akun tidak ditemukan.',
        ]);

        // Coba login
        if (Auth::guard('admin')->attempt([$fieldType => $loginField, 'password' => $request->password], $request->has('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['login' => 'The provided credentials do not match our records']);
    }

    public function logout(Request $request)
    {
        // bisa pakai ini
        Auth::guard('admin')->logout();
        // Hapus session setelah logout
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}