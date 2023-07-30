<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\PeriodService;

class PeriodController extends Controller
{
    private PeriodService $periodService;

    public function __construct(PeriodService $periodService)
    {
         $this->periodService = $periodService;
    }

    public function index(): Response
    {
        return Inertia::render('Periods/Index', [ 
            'periods' => $this->periodService->getAll(),
        ]);
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
