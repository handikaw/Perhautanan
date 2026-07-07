<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'forest_land_id',
        'jenis',
        'tanggal',
        'tindak_lanjut',
        'petugas',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tindak_lanjut' => 'date',
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
            'jenis' => $this->jenis,
            'tanggal' => optional($this->tanggal)->format('Y-m-d'),
            'tindaklanjut' => optional($this->tindak_lanjut)->format('Y-m-d'),
            'petugas' => $this->petugas,
            'catatan' => $this->catatan,
        ];
    }
}
