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
        Schema::create('kebutuhan_ppls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('data_sekolahs')->onDelete('cascade');
            $table->string('tahun_ajaran');
            $table->string('jurusan');
            $table->integer('jumlah_mahasiswa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebutuhan_ppls');
    }
};
