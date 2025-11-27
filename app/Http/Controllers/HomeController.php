<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Prestasi;
use App\Models\Berita;
use App\Models\Lomba;
use App\Models\Story;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $pengumuman = Pengumuman::where('is_active', true)->latest()->take(3)->get();
            $prestasi = Prestasi::where('is_active', true)->latest()->take(3)->get();
            $berita = Berita::where('is_active', true)->latest()->take(3)->get();
            $lomba = Lomba::where('is_active', true)->latest()->take(3)->get();
            $stories = Story::where('is_active', true)->latest()->take(6)->get();
        } catch (\Exception $e) {
            $pengumuman = collect();
            $prestasi = collect();
            $berita = collect();
            $lomba = collect();
            $stories = collect();
        }

        return view('pages.home', compact('pengumuman', 'prestasi', 'berita', 'lomba', 'stories'));
    }
}