<?php

namespace Database\Seeders;

use App\Models\PlanFeature;
use Illuminate\Database\Seeder;

class PlanFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'feature_name' => 'Jumlah lahan terdaftar',
                'value_type' => 'text',
                'free_text' => '10 lahan',
                'premium_text' => 'Tanpa batas',
                'sort_order' => 1,
            ],
            [
                'feature_name' => 'Jumlah pengguna / tim',
                'value_type' => 'text',
                'free_text' => '1 pengguna',
                'premium_text' => 'Tanpa batas',
                'sort_order' => 2,
            ],
            [
                'feature_name' => 'Grafik analisis',
                'value_type' => 'text',
                'free_text' => 'Dasar (pie & bar)',
                'premium_text' => 'Lengkap + insight otomatis',
                'sort_order' => 3,
            ],
            [
                'feature_name' => 'Export CSV',
                'value_type' => 'text',
                'free_text' => '1x / hari',
                'premium_text' => 'Tanpa batas',
                'sort_order' => 4,
            ],
            [
                'feature_name' => 'Cetak laporan & unduh grafik',
                'value_type' => 'boolean',
                'free_bool' => false,
                'premium_bool' => true,
                'sort_order' => 5,
            ],
            [
                'feature_name' => 'Dukungan pelanggan',
                'value_type' => 'text',
                'free_text' => 'Email (3-5 hari)',
                'premium_text' => 'Prioritas 24/7',
                'sort_order' => 6,
            ],
        ];

        foreach ($rows as $row) {
            PlanFeature::create($row);
        }
    }
}
