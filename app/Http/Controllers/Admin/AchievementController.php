<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    private $achievements = [
        ['id' => 1, 'title' => 'Juara 1 Lomba Programming', 'description' => 'Meraih juara 1 dalam lomba programming tingkat nasional', 'date' => '2024-01-15'],
        ['id' => 2, 'title' => 'Best Student Award', 'description' => 'Penghargaan sebagai mahasiswa terbaik', 'date' => '2024-02-20'],
        ['id' => 3, 'title' => 'Hackathon Winner', 'description' => 'Pemenang hackathon teknologi 2024', 'date' => '2024-03-10']
    ];

    public function index()
    {
        return view('admin.achievements.index', ['achievements' => $this->achievements]);
    }

    public function create()
    {
        return view('admin.achievements.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.achievements.index');
    }

    public function show(string $id)
    {
        $achievement = collect($this->achievements)->firstWhere('id', $id);
        return view('admin.achievements.show', ['achievement' => $achievement]);
    }

    public function edit(string $id)
    {
        $achievement = collect($this->achievements)->firstWhere('id', $id);
        return view('admin.achievements.edit', ['achievement' => $achievement]);
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('admin.achievements.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('admin.achievements.index');
    }
}