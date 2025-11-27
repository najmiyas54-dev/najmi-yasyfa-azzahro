<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
                    ->whereIn('category', ['pengumuman', 'prestasi', 'lomba', 'kegiatan'])
                    ->latest()
                    ->paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    public function pendingReview()
    {
        $posts = Post::where('review_status', 'pending_admin')
                    ->with('user')
                    ->latest()
                    ->paginate(10);
        return view('admin.posts.pending-review', compact('posts'));
    }

    public function previewPost($id)
    {
        $post = Post::where('review_status', 'pending_admin')
            ->with('user')
            ->findOrFail($id);
            
        return view('admin.preview-post', compact('post'));
    }

    public function approve(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update([
            'review_status' => 'approved_admin',
            'status' => 'approved',
            'is_published' => false,
            'reviewed_by_admin' => Auth::id(),
            'admin_reviewed_at' => now(),
            'admin_notes' => $request->notes
        ]);
        
        // Send notification to student
        Notification::create([
            'user_id' => $post->user_id,
            'post_id' => $post->id,
            'type' => 'approved_admin',
            'title' => 'Artikel Disetujui Admin',
            'message' => 'Artikel "' . $post->title . '" telah disetujui admin dan siap dipublish. Silakan publish artikel Anda.'
        ]);
        
        return back()->with('success', 'Artikel berhasil disetujui! Siswa dapat mempublish artikel.');
    }

    public function reject(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update([
            'review_status' => 'rejected_admin',
            'status' => 'rejected',
            'reviewed_by_admin' => Auth::id(),
            'admin_reviewed_at' => now(),
            'admin_notes' => $request->notes
        ]);
        
        // Send notification to student
        Notification::create([
            'user_id' => $post->user_id,
            'post_id' => $post->id,
            'type' => 'rejected_admin',
            'title' => 'Artikel Ditolak Admin',
            'message' => 'Artikel "' . $post->title . '" ditolak admin. Catatan: ' . ($request->notes ?? 'Tidak ada catatan')
        ]);
        
        return back()->with('success', 'Artikel ditolak!');
    }

    public function destroy(Post $post)
    {
        if ($post->image_path) {
            \Storage::delete('public/' . $post->image_path);
        }
        if ($post->file_path) {
            \Storage::delete('public/' . $post->file_path);
        }
        
        $post->delete();
        return redirect()->back()->with('success', 'Post berhasil dihapus');
    }
}