<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('approval_status', 'pending')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('guru.posts.index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        return view('guru.posts.show', compact('post'));
    }

    public function approve(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        
        $post->update([
            'approval_status' => 'approved_by_guru',
            'guru_approved_at' => now(),
            'guru_notes' => $request->notes
        ]);

        return redirect()->route('guru.posts.index')
            ->with('success', 'Artikel berhasil disetujui');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string|max:500'
        ]);

        $post = Post::findOrFail($id);
        
        $post->update([
            'approval_status' => 'rejected',
            'guru_notes' => $request->notes
        ]);

        return redirect()->route('guru.posts.index')
            ->with('success', 'Artikel ditolak dengan catatan');
    }
}