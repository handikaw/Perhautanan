<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_features', function (Blueprint $table) {
            $table->id();
            $table->string('feature_name');

            // Tipe nilai: 'text' (mis. "10 lahan") atau 'boolean' (tampil ceklis/silang)
            $table->enum('value_type', ['text', 'boolean'])->default('text');

            // Untuk value_type = text
            $table->string('free_text')->nullable();
            $table->string('premium_text')->nullable();

            // Untuk value_type = boolean
            $table->boolean('free_bool')->nullable();
            $table->boolean('premium_bool')->nullable();

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_features');
    }
};
