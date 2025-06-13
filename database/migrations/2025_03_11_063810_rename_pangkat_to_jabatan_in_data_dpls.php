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
        Schema::table('data_dpls', function (Blueprint $table) {
            $table->renameColumn('pangkat', 'jabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_dpls', function (Blueprint $table) {
            $table->renameColumn('jabatan', 'pangkat');
        });
    }
};
