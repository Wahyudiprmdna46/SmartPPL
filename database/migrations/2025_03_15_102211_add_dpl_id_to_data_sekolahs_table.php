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
        Schema::table('data_sekolahs', function (Blueprint $table) {
            $table->unsignedBigInteger('dpl_id')->nullable()->after('nama_sekolah');

            // Tambahkan foreign key constraint
            $table->foreign('dpl_id')->references('id')->on('data_dpls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_sekolahs', function (Blueprint $table) {
            $table->dropForeign(['dpl_id']);
            $table->dropColumn('dpl_id');
        });
    }
};
