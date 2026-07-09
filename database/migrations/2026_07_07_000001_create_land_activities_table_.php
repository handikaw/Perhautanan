<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('land_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forest_land_id')
                ->constrained('forest_lands')
                ->onDelete('cascade');
            $table->enum('jenis', ['Penanaman', 'Pemeliharaan', 'Penebangan', 'Panen', 'Inspeksi', 'Lainnya']);
            $table->date('tanggal');
            $table->date('tindak_lanjut')->nullable();
            $table->string('petugas');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['forest_land_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('land_activities');
    }
};
