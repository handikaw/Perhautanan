<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan perintah untuk membuat tabel di MySQL.
     */
    public function up(): void
    {
        Schema::create('forest_lands', function (Blueprint $table) {
            $table->id();
            // Menghubungkan data lahan dengan akun user/perusahaan yang login (Prinsip SaaS)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_lahan');
            $table->decimal('luas_hektar', 8, 2);
            $table->enum('status', ['Konservasi', 'Produksi', 'Reboisasi'])->default('Produksi');
            $table->timestamps();
        });
    }

    /**
     * Batalkan perintah (Rollback) jika diperlukan.
     */
    public function down(): void
    {
        Schema::dropIfExists('forest_lands');
    }
};