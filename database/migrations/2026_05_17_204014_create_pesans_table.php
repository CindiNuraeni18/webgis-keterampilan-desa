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
        Schema::create('pesans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');

            $table->string('email')->nullable();

            $table->string('nomor_hp');

            $table->string('dusun');

            $table->string('rw')->nullable();

            $table->string('rt')->nullable();
            $table->string('keterampilan')->nullable();
            $table->text('pesan');
            $table->string('status')->default('Belum Ditindaklanjuti');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesans');
    }
};
