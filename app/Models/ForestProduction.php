<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForestProduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'forest_land_id',
        'komoditas',
        'jumlah',
        'satuan',
        'tanggal',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    public function forestLand()
    {
        return $this->belongsTo(ForestLand::class);
    }

    /**
     * Shape the model the way the dashboard's front-end JavaScript expects it,
     * so the Blade view can consume it directly without further mapping.
     */
    public function toDashboardArray(): array
    {
        return [
            'id' => $this->id,
            'lahan_id' => $this->forest_land_id,
            'lahan_nama' => $this->forestLand->nama_lahan ?? '-',
            'komoditas' => $this->komoditas,
            'jumlah' => (float) $this->jumlah,
            'satuan' => $this->satuan,
            'tanggal' => optional($this->tanggal)->format('Y-m-d'),
            'catatan' => $this->catatan,
        ];
    }
}
