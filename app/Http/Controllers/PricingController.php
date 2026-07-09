<?php

namespace App\Http\Controllers;

use App\Models\PlanFeature;

class PricingController extends Controller
{
    public function index()
    {
        $features = PlanFeature::orderBy('sort_order')->get();

        return view('pricing', compact('features'));
    }
}
