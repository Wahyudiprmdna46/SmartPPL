<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@gmail.com'], // ✅ Kriteria pencarian (dicari berdasarkan email)
            [
                'name' => 'Administrator',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'bukzulfani@gmail.com'],
            [
                'name' => 'Prof. Dr. Zulfani Sesmiarni, S.Pd, M.Pd',
                'role' => 'dpl',
                'password' => bcrypt('password'),
                'nip' => '123456789101112101',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'pakman@gmail.com'],
            [
                'name' => 'Dr. Supratman, M.Kom, M.Pd',
                'role' => 'dpl',
                'password' => bcrypt('password'),
                'nip' => '123456789101112103',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'bukelin@gmail.com'],
            [
                'name' => 'Yulifda Elin Yuspita, M.Kom',
                'role' => 'dpl',
                'password' => bcrypt('password'),
                'nip' => '123456789101112104',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'pakarif@gmail.com'],
            [
                'name' => 'Dr. Arifmiboy, S.Ag, M.Pd',
                'role' => 'dpl',
                'password' => bcrypt('password'),
                'nip' => '123456789101112102',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'wahyudi@gmail.com'],
            [
                'name' => 'Wahyudi Primadana',
                'role' => 'mahasiswa',
                'password' => bcrypt('password'),
                'nim' => '2521012',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'nanda@gmail.com'],
            [
                'name' => 'Nanda Pratama A',
                'role' => 'mahasiswa',
                'password' => bcrypt('password'),
                'nim' => '2521007',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'fitri@gmail.com'],
            [
                'name' => 'Fitri Khairani',
                'role' => 'mahasiswa',
                'password' => bcrypt('password'),
                'nim' => '2321081',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'ali@gmail.com'],
            [
                'name' => 'Ali Usman',
                'role' => 'mahasiswa',
                'password' => bcrypt('password'),
                'nim' => '2121189',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'smp7bukittinggi@gmail.com'],
            [
                'name' => 'Smpn 7 Bukittinggi',
                'role' => 'sekolah',
                'password' => bcrypt('password'),
                'npsn' => '10307977',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'smp6bukittinggi@gmail.com'],
            [
                'name' => 'Smpn 6 Bukittinggi',
                'role' => 'sekolah',
                'password' => bcrypt('password'),
                'npsn' => '12345606',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'smp8bukittinggi@gmail.com'],
            [
                'name' => 'Smpn 8 Bukittinggi',
                'role' => 'sekolah',
                'password' => bcrypt('password'),
                'npsn' => '10307941',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'mtsn12agam@gmail.com'],
            [
                'name' => 'Mtsn 12 Agam',
                'role' => 'sekolah',
                'password' => bcrypt('password'),
                'npsn' => '10311231',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'Sman1Bukittinggi@gmail.com'],
            [
                'name' => 'Sman 1 Bukittinggi',
                'role' => 'sekolah',
                'password' => bcrypt('password'),
                'npsn' => '10307523',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'bukazrini@gmail.com'],
            [
                'name' => 'Azrini, S.Pd',
                'role' => 'pamong',
                'password' => bcrypt('password'),
                'nip' => '123456789101112132',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'idriansyah@gmail.com'],
            [
                'name' => 'Idriansyah, S.Pd',
                'role' => 'pamong',
                'password' => bcrypt('password'),
                'nip' => '123456789101112135',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'eldawati@gmail.com'],
            [
                'name' => 'Eldawati, S.Si',
                'role' => 'pamong',
                'password' => bcrypt('password'),
                'nip' => '123456789101112133',
            ]
        );
        Admin::updateOrCreate(
            ['email' => 'taufik@gmail.com'],
            [
                'name' => 'Taufik Hidayat, S.Pd',
                'role' => 'pamong',
                'password' => bcrypt('password'),
                'nip' => '123456789101112131',
            ]
        );
    }
}
