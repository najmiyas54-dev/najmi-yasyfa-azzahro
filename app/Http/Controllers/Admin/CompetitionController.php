<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index()
    {
        return view('admin.competitions.index');
    }

    public function create()
    {
        return view('admin.competitions.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.competitions.index');
    }

    public function show(string $id)
    {
        return view('admin.competitions.show');
    }

    public function edit(string $id)
    {
        return view('admin.competitions.edit');
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('admin.competitions.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('admin.competitions.index');
    }
}