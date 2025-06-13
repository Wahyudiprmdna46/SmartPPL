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
        Schema::table('data_pamongs', function (Blueprint $table) {
            $table->dropColumn('pangkat'); // Hapus kolom pangkat
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_pamongs', function (Blueprint $table) {
            $table->string('pangkat');
        });
    }
};
