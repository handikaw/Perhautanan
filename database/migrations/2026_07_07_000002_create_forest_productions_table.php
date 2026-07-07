<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forest_productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forest_land_id')
                ->constrained('forest_lands')
                ->onDelete('cascade');
            $table->string('komoditas');
            $table->decimal('jumlah', 12, 2);
            $table->enum('satuan', ['m3', 'kg', 'batang', 'liter']);
            $table->date('tanggal');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['forest_land_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forest_productions');
    }
};
