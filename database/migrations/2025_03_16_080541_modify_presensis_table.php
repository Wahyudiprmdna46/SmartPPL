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
        Schema::table('presensis', function (Blueprint $table) {
            $table->date('tgl_presensi')->nullable()->change();
            $table->time('jam_in')->nullable()->change();
            $table->time('jam_out')->nullable()->change();
            $table->string('foto_in')->nullable()->change();
            $table->string('foto_out')->nullable()->change();
            $table->text('lokasi_in')->nullable()->change();
            $table->text('lokasi_out')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->date('tgl_presensi')->nullable(false)->change();
            $table->time('jam_in')->nullable(false)->change();
            $table->time('jam_out')->nullable(false)->change();
            $table->string('foto_in')->nullable(false)->change();
            $table->string('foto_out')->nullable(false)->change();
            $table->text('lokasi_in')->nullable(false)->change();
            $table->text('lokasi_out')->nullable(false)->change();
        });
    }
};
