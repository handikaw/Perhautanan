<?php

namespace App\Http\Controllers;

use App\Models\PlanFeature;
use Illuminate\Support\Facades\Auth;

class PricingController extends Controller
{
    public function index()
    {
        $features = PlanFeature::orderBy('sort_order')->get();

        return view('pricing', compact('features'));
    }

    // Aktivasi Premium langsung tanpa pembayaran (sementara, buat demo/testing)
    public function upgrade()
    {
        $user = Auth::user();
        $user->is_premium = true;
        $user->premium_activated_at = now();
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Selamat! Akun kamu sekarang Premium.');
    }
}
