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
        Schema::create('penilaian_dpls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('data_mahasiswas')->onDelete('cascade');
            $table->decimal('persiapan_mengajar', 5, 2)->nullable();
            $table->decimal('praktek_mengajar', 5, 2)->nullable();
            $table->decimal('laporan_ppl', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_dpls');
    }
};
