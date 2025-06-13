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
        Schema::create('laporan_ppls', function (Blueprint $table) {
            $table->id();
            $table->text('link_tugas');
            $table->foreignId('mahasiswa_id')->nullable()->constrained('data_mahasiswas')->onDelete('cascade');
            $table->foreignId('dpl_id')->nullable()->constrained('data_dpls')->onDelete('cascade');
            $table->foreignId('sekolah_id')->nullable()->constrained('data_sekolahs')->onDelete('cascade');
            $table->foreignId('pamong_id')->nullable()->constrained('data_pamongs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_ppls');
    }
};
