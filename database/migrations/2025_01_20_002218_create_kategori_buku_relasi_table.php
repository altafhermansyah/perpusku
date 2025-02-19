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
        Schema::create('kategoriBuku_relasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bukuId')->references('id')->on('buku');
            $table->foreignId('kategoriId')->references('id')->on('kategoriBuku');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategoriBuku_relasi');
    }
};
