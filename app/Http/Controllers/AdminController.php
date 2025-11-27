<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\User;
use App\Models\Post;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPosts = Post::count();
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $pendingPosts = Post::where('review_status', 'approved_guru')->count();
        $recentPosts = Post::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalPosts', 'totalUsers', 'pendingPosts', 'recentPosts'));
    }

    public function users()
    {
        $users = User::where('role', '!=', 'admin')->latest()->get();
        $pendingUsers = User::where('is_approved', false)->where('role', '!=', 'admin')->latest()->get();
        return view('admin.users', compact('users', 'pendingUsers'));
    }

    public function approveUser($id)
    {
        $user = User::where('role', '!=', 'admin')->findOrFail($id);
        $user->update(['is_approved' => true]);
        
        return redirect()->route('admin.users')->with('success', 'User berhasil disetujui!');
    }

    public function rejectUser($id)
    {
        $user = User::where('role', '!=', 'admin')->where('is_approved', false)->findOrFail($id);
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'User berhasil ditolak dan dihapus!');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:siswa,guru'
        ]);

        User::create([
            'name' => $request->name,
            'nama' => $request->name,
            'username' => $request->email,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_approved' => true
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->role != 'admin') {
            $user->delete();
            return redirect()->route('admin.users')->with('success', 'User berhasil dihapus!');
        }
        return redirect()->route('admin.users')->with('error', 'Admin tidak dapat dihapus!');
    }

    public function mediaIndex()
    {
        $media = Media::latest()->paginate(12);
        return view('admin.media.index', compact('media'));
    }

    public function mediaCreate()
    {
        return view('admin.media.create');
    }

    public function mediaStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240', // 10MB max
            'category' => 'required|string'
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('media', $fileName, 'public');

        // Determine file type
        $mimeType = $file->getMimeType();
        $fileType = 'other';
        if (str_starts_with($mimeType, 'image/')) {
            $fileType = 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            $fileType = 'video';
        } elseif (in_array($mimeType, ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) {
            $fileType = 'document';
        }

        Media::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $file->getSize(),
            'mime_type' => $mimeType,
            'category' => $request->category,
            'is_active' => true
        ]);

        return redirect()->route('admin.media.index')->with('success', 'File berhasil diupload!');
    }

    public function mediaShow($id)
    {
        $media = Media::findOrFail($id);
        return view('admin.media.show', compact('media'));
    }

    public function mediaEdit($id)
    {
        $media = Media::findOrFail($id);
        return view('admin.media.edit', compact('media'));
    }

    public function mediaUpdate(Request $request, $id)
    {
        $media = Media::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $media->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.media.index')->with('success', 'Media berhasil diupdate!');
    }

    public function mediaDestroy($id)
    {
        $media = Media::findOrFail($id);
        
        // Delete file from storage
        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }
        
        $media->delete();
        
        return redirect()->route('admin.media.index')->with('success', 'Media berhasil dihapus!');
    }

    public function getMediaByCategory($category)
    {
        $media = Media::active()->byCategory($category)->latest()->get();
        return response()->json($media);
    }

    public function pendingPosts()
    {
        $pendingPosts = Post::where('approval_status', 'approved_by_guru')
            ->where('review_status', 'pending_admin')
            ->where('status', '!=', 'rejected')
            ->with(['user'])
            ->latest()
            ->paginate(10);
            
        return view('admin.pending-posts', compact('pendingPosts'));
    }

    public function approvePost(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update([
            'approval_status' => 'approved',
            'status' => 'approved',
            'is_published' => false,
            'reviewed_by_admin' => Auth::id(),
            'admin_reviewed_at' => now(),
            'admin_approved_at' => now(),
            'admin_notes' => $request->notes
        ]);
        
        // Send notification to user (guru or siswa)
        $userRole = $post->user->role;
        $message = $userRole === 'guru' ? 
            'Artikel "' . $post->title . '" telah disetujui admin. Silakan publish artikel di halaman Artikel Saya.' :
            'Artikel "' . $post->title . '" telah disetujui admin. Silakan publish artikel Anda di dashboard siswa.';
            
        Notification::create([
            'user_id' => $post->user_id,
            'post_id' => $post->id,
            'type' => 'approved_admin',
            'title' => 'Artikel Disetujui Admin',
            'message' => $message
        ]);
        
        return back()->with('success', 'Artikel berhasil disetujui! User dapat mempublish artikel tersebut.');
    }

    public function rejectPost(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update([
            'approval_status' => 'rejected',
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

    public function reports()
    {
        $monthlyPosts = Post::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                           ->whereYear('created_at', date('Y'))
                           ->groupBy('month')
                           ->get();
        
        $categoryPosts = Post::selectRaw('category, COUNT(*) as count')
                            ->groupBy('category')
                            ->get();
        
        return view('admin.reports', compact('monthlyPosts', 'categoryPosts'));
    }
}