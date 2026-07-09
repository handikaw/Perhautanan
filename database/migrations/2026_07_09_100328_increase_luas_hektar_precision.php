<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE forest_lands MODIFY COLUMN luas_hektar DECIMAL(12, 2) NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE forest_lands MODIFY COLUMN luas_hektar DECIMAL(8, 2) NOT NULL');
    }
};
