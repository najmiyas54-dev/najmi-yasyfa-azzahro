<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index()
    {
        $upcomingCompetitions = Competition::upcoming()->latest()->get();
        $ongoingCompetitions = Competition::ongoing()->latest()->get();
        $completedCompetitions = Competition::completed()->latest()->take(5)->get();
        
        return view('pages.competitions', compact('upcomingCompetitions', 'ongoingCompetitions', 'completedCompetitions'));
    }

    public function show($id)
    {
        $competition = Competition::findOrFail($id);
        return view('pages.competition-detail', compact('competition'));
    }
}
