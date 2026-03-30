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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('name');
            $table->string('foto')->nullable()->after('password');
            $table->string('jabatan')->nullable()->after('email');
            $table->string('nomor')->nullable()->after('jabatan');
            $table->string('alamat')->nullable()->after('nomor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'foto', 'jabatan', 'nomor', 'alamat']);
        });
    }
};
