<?php

namespace App\Services;

use App\Models\ForestLand;
use App\Models\PdfExport;
use App\Models\User;
use Carbon\Carbon;

class PlanLimitService
{
    /**
     * Batas jumlah lahan untuk paket Free.
     */
    const FREE_LAHAN_LIMIT = 10;

    /**
     * Batas cetak PDF per hari untuk paket Free.
     */
    const FREE_PDF_LIMIT_PER_DAY = 1;

    /**
     * Cek apakah user masih boleh menambah lahan baru.
     */
    public function canAddLahan(User $user): bool
    {
        if ($user->is_premium) {
            return true;
        }

        $jumlahLahan = ForestLand::where('user_id', $user->id)->count();

        return $jumlahLahan < self::FREE_LAHAN_LIMIT;
    }

    /**
     * Cek apakah user masih boleh cetak PDF hari ini.
     */
    public function canExportPdf(User $user): bool
    {
        if ($user->is_premium) {
            return true;
        }

        $jumlahHariIni = PdfExport::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        return $jumlahHariIni < self::FREE_PDF_LIMIT_PER_DAY;
    }

    /**
     * Catat 1 kali aktivitas cetak PDF. Panggil ini SETELAH proses cetak berhasil.
     */
    public function recordPdfExport(User $user): void
    {
        PdfExport::create(['user_id' => $user->id]);
    }

    /**
     * Pesan yang ditampilkan ketika limit tercapai.
     */
    public function lahanLimitMessage(): string
    {
        return 'Kamu sudah mencapai batas ' . self::FREE_LAHAN_LIMIT . ' lahan untuk paket Free. Upgrade ke Premium untuk menambah lahan tanpa batas.';
    }

    public function pdfLimitMessage(): string
    {
        return 'Kamu sudah mencapai batas cetak PDF hari ini untuk paket Free. Upgrade ke Premium untuk cetak tanpa batas.';
    }
}
