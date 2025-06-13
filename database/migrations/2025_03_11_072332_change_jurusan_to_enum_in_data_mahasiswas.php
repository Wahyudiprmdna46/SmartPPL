<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('data_mahasiswas', function (Blueprint $table) {
            $table->dropColumn('jurusan'); // Hapus kolom lama
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_mahasiswas', function (Blueprint $table) {
            $table->dropColumn('jurusan'); // Hapus ENUM jika rollback
        });

        Schema::table('data_mahasiswas', function (Blueprint $table) {
            $table->string('jurusan')->after('jenis_kelamin'); // Kembalikan ke string jika rollback
        });
    }
};
