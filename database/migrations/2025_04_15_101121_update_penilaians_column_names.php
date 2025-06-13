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
        Schema::table('penilaians', function (Blueprint $table) {
            $table->renameColumn('nilai_kompetensi', 'persiapan_mengajar');
            $table->renameColumn('nilai_sikap', 'praktek_mengajar');
            $table->renameColumn('nilai_kedisiplinan', 'laporan_ppl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->renameColumn('persiapan_mengajar', 'nilai_kompetensi');
            $table->renameColumn('praktek_mengajar', 'nilai_sikap');
            $table->renameColumn('laporan_ppl', 'nilai_kedisiplinan');
        });
    }
};
