<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PeriodController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Periods/Index', [ ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'time_start' => 'date_format:H:i',
            'time_end' => 'date_format:H:i|after:time_start',
        ]);
  
        $request->user()->periods()->create($validated);
 
        return redirect(route('periods.index'));
    }
}
