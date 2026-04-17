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
        Schema::create('keterampilans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('wargas')->onDelete('cascade');
            $table->foreignId('kategori_keterampilan_id')->constrained('kategori_keterampilans')->onDelete('cascade');
            $table->string('nama_keterampilan');
            $table->enum('tingkat_keahlian', ['Pemula', 'Menengah', 'Mahir'])->nullable();
            $table->string('pengalaman')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keterampilans');
    }
};
