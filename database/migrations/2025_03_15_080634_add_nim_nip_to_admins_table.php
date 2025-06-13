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
        Schema::table('admins', function (Blueprint $table) {
            $table->string('nim')->unique()->nullable()->after('email'); // Tambah NIM setelah email
            $table->string('nip')->unique()->nullable()->after('nim'); // Tambah NIP setelah NIM
            $table->string('npsn')->unique()->nullable()->after('nip'); // Tambah NPSN setelah NIP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['nim', 'nip', 'npsn']);
        });
    }
};
