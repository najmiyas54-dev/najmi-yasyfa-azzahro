<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $allPosts = Post::where('is_published', true)
                       ->where('approval_status', 'published')
                       ->with('user')
                       ->latest()
                       ->get();
        
        $sliderPosts = $allPosts->take(1);
        $latestPosts = $allPosts->skip($sliderPosts->count())->take(6);
        
        return view('pages.index', compact('sliderPosts', 'latestPosts'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function gallery()
    {
        return view('pages.gallery');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function prestasi()
    {
        $prestasi = Post::where('category', 'prestasi')
                       ->where('is_published', true)
                       ->where('approval_status', 'published')
                       ->with(['user:id,name'])
                       ->latest('created_at')
                       ->paginate(6);
        
        return view('pages.prestasi', compact('prestasi'));
    }

    public function lomba()
    {
        $lomba = Post::where('category', 'lomba')
                    ->where('is_published', true)
                    ->where('approval_status', 'published')
                    ->with(['user:id,name'])
                    ->latest('created_at')
                    ->paginate(6);
        
        return view('pages.lomba', compact('lomba'));
    }

    public function kegiatan()
    {
        $kegiatan = Post::where('category', 'kegiatan')
                       ->where('is_published', true)
                       ->where('approval_status', 'published')
                       ->with(['user:id,name'])
                       ->withCount(['likes' => function($query) {
                           // Count likes if PostLike model exists
                       }])
                       ->latest('created_at')
                       ->paginate(6);
        
        return view('pages.kegiatan', compact('kegiatan'));
    }

    public function pengumuman()
    {
        $pengumuman = Post::where('category', 'pengumuman')
                         ->where('is_published', true)
                         ->where('approval_status', 'published')
                         ->with(['user:id,name'])
                         ->latest('created_at')
                         ->paginate(6);
        
        return view('pages.pengumuman', compact('pengumuman'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $posts = Post::where('is_published', true)
                    ->where('approval_status', 'published')
                    ->where(function($q) use ($query) {
                        $q->where('title', 'LIKE', '%' . $query . '%')
                          ->orWhere('category', 'LIKE', '%' . $query . '%');
                    })
                    ->latest()
                    ->paginate(10);
        
        return view('pages.search', compact('posts', 'query'));
    }
}