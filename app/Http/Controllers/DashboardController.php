<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use App\Models\DartMatch;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        $match = DartMatch::where('status', 'active')->first();
        return view('dashboard', [
            'match' => $match,
            'matches' => DartMatch::where('status', '!=', 'active')->get(),
        ]);
    }
}
