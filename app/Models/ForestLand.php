<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForestLand extends Model
{
    use HasFactory;

    // Kolom yang diizinkan untuk diisi di MySQL XAMPP
    protected $fillable = ['user_id', 'nama_lahan', 'luas_hektar', 'status'];

    // Relasi: Satu lahan dimiliki oleh satu User (SaaS Multi-tenant)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}