<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Post::where('status', 'pending')
                            ->with('user')
                            ->latest()
                            ->paginate(10);
        
        return view('admin.notifications.index', compact('notifications'));
    }

    public function approve($id)
    {
        $post = Post::findOrFail($id);
        $post->update([
            'status' => 'approved',
            'is_published' => true,
            'published_at' => now()
        ]);
        
        return back()->with('success', 'Artikel berhasil disetujui!');
    }

    public function reject($id)
    {
        $post = Post::findOrFail($id);
        $post->update(['status' => 'rejected']);
        
        return back()->with('success', 'Artikel berhasil ditolak!');
    }

    public function markAllRead()
    {
        Post::where('status', 'pending')->update(['status' => 'reviewed']);
        
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca!');
    }
}