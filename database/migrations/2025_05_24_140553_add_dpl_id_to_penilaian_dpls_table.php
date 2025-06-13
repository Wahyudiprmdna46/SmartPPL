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
        Schema::table('penilaian_dpls', function (Blueprint $table) {
            $table->unsignedBigInteger('dpl_id')->nullable()->after('mahasiswa_id');

            // Tambahkan foreign key jika kamu mau:
            $table->foreign('dpl_id')->references('id')->on('data_dpls')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian_dpls', function (Blueprint $table) {
            $table->dropForeign(['dpl_id']);
            $table->dropColumn('dpl_id');
        });
    }
};
