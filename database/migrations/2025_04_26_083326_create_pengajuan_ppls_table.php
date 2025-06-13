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
        Schema::create('pengajuan_ppls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id'); // ID dari tabel admins
            $table->unsignedBigInteger('data_mahasiswa_id'); // ID dari tabel data_mahasiswas
            $table->unsignedBigInteger('sekolah_id'); // Pilihan sekolah tujuan
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('data_mahasiswa_id')->references('id')->on('data_mahasiswas')->onDelete('cascade');
            $table->foreign('sekolah_id')->references('id')->on('data_sekolahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_ppls');
    }
};
