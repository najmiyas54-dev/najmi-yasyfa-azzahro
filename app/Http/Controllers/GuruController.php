<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function login()
    {
        return view('guru.login');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();
        
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
        }

        // Check if user is guru
        if ($user->role !== 'guru') {
            return back()->withErrors(['email' => 'Anda tidak memiliki akses sebagai guru'])->withInput();
        }

        // Check if user is approved
        if (!$user->is_approved) {
            return back()->withErrors(['email' => 'Akun Anda belum disetujui oleh admin. Silakan tunggu persetujuan.'])->withInput();
        }

        Auth::login($user);
        return redirect()->route('guru.dashboard');
    }

    public function dashboard()
    {
        $myPosts = Post::where('user_id', Auth::id())->latest()->get();
        $pendingStudentPosts = Post::where('approval_status', 'pending')
            ->whereHas('user', function($query) {
                $query->where('role', 'siswa');
            })
            ->with('user')
            ->latest()
            ->get();
        
        $notifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->latest()
            ->take(5)
            ->get();
        
        $stats = [
            'my_posts' => $myPosts->count(),
            'pending_student_posts' => $pendingStudentPosts->count(),
            'approved_posts' => Post::where('user_id', Auth::id())->where('status', 'approved')->count(),
            'total_users' => User::count(),
            'unread_notifications' => $notifications->count()
        ];
        
        return view('guru.dashboard', compact('myPosts', 'pendingStudentPosts', 'stats', 'notifications'));
    }

    public function posts()
    {
        $posts = Post::where('user_id', Auth::id())->latest()->get();
        return view('guru.posts.index', compact('posts'));
    }

    public function allPosts()
    {
        $posts = Post::with('user')->latest()->get();
        return view('guru.all-posts', compact('posts'));
    }

    public function createPost()
    {
        // Debug: Check if user is authenticated and is guru
        if (!Auth::check()) {
            return redirect()->route('guru.login')->with('error', 'Please login first');
        }
        
        if (Auth::user()->role !== 'guru') {
            return redirect()->route('guru.login')->with('error', 'Access denied');
        }
        
        return view('guru.posts.create');
    }

    public function storePost(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:pengumuman,prestasi,lomba,kegiatan',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'posted_date' => 'required|date',
            'author_name' => 'required|string|max:255'
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'user_id' => Auth::id(),
            'status' => 'pending',
            'approval_status' => 'pending_admin',
            'review_status' => 'pending_admin',
            'is_published' => false,
            'posted_date' => $request->posted_date,
            'author_name' => $request->author_name
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($data);

        // Send notification to admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'post_id' => $post->id,
                'type' => 'pending_admin_review',
                'title' => 'Artikel Guru Perlu Review',
                'message' => 'Guru "' . Auth::user()->name . '" telah membuat artikel "' . $post->title . '" yang perlu direview admin.'
            ]);
        }

        return redirect()->route('guru.posts.index')->with('success', 'Artikel berhasil dibuat dan menunggu persetujuan admin!');
    }

    public function editPost($id)
    {
        $post = Post::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('guru.posts.edit', compact('post'));
    }

    public function updatePost(Request $request, $id)
    {
        $post = Post::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:pengumuman,prestasi,lomba,kegiatan',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category
        ];

        // Handle image upload and delete old image
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image_path && \Storage::exists('public/' . $post->image_path)) {
                \Storage::delete('public/' . $post->image_path);
            }
            $data['image_path'] = $request->file('image')->store('posts', 'public');
        }



        $post->update($data);

        return redirect()->route('guru.posts.index')->with('success', 'Artikel berhasil diupdate!');
    }

    public function studentPosts()
    {
        $pendingPosts = Post::where('approval_status', 'pending')
            ->whereHas('user', function($query) {
                $query->where('role', 'siswa');
            })
            ->with('user')
            ->latest()
            ->paginate(10);
            
        return view('guru.student-posts', compact('pendingPosts'));
    }

    public function detailPost($id)
    {
        $post = Post::with('user')->findOrFail($id);
        
        // Cek apakah guru bisa melihat artikel ini
        if (!in_array($post->review_status, ['pending_guru', 'pending_admin', 'approved_admin'])) {
            return redirect()->route('guru.review-posts')
                           ->with('error', 'Artikel tidak dapat diakses.');
        }
            
        return view('guru.detail-post', compact('post'));
    }

    public function reviewArticle($id)
    {
        $post = Post::with('user')->findOrFail($id);
        
        // Cek apakah artikel bisa direview oleh guru
        if ($post->review_status !== 'pending_guru' || $post->status !== 'pending') {
            return redirect()->route('guru.review-posts')
                           ->with('error', 'Artikel tidak dapat direview atau sudah direview.');
        }
            
        return view('guru.review-article', compact('post'));
    }

    public function approveStudentPost(Request $request, $id)
    {
        $post = Post::where('approval_status', 'pending')
                   ->findOrFail($id);
        $post->update([
            'approval_status' => 'approved_by_guru',
            'guru_approved_at' => now(),
            'guru_notes' => $request->notes
        ]);
        
        // Send notification to student
        Notification::create([
            'user_id' => $post->user_id,
            'post_id' => $post->id,
            'type' => 'approved_guru',
            'title' => 'Artikel Disetujui Guru',
            'message' => 'Artikel "' . $post->title . '" telah disetujui guru dan menunggu review admin.'
        ]);
        
        return back()->with('success', 'Artikel berhasil disetujui!');
    }

    public function rejectStudentPost(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string|max:500'
        ]);
        
        $post = Post::where('approval_status', 'pending')
                   ->findOrFail($id);
        $post->update([
            'approval_status' => 'rejected',
            'status' => 'rejected',
            'review_status' => 'rejected_guru',
            'guru_notes' => $request->notes,
            'guru_reviewed_at' => now(),
            'reviewed_by_guru' => Auth::id()
        ]);
        
        // Send notification to student
        Notification::create([
            'user_id' => $post->user_id,
            'post_id' => $post->id,
            'type' => 'rejected_guru',
            'title' => 'Artikel Ditolak Guru',
            'message' => 'Artikel "' . $post->title . '" ditolak guru. Silakan revisi atau hapus artikel. Catatan: ' . $request->notes
        ]);
        
        return back()->with('success', 'Artikel ditolak dan dikembalikan ke siswa untuk revisi!');
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('guru.users', compact('users'));
    }

    public function createUser()
    {
        return view('guru.create-user');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,guru,siswa'
        ]);

        User::create([
            'name' => $request->name,
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => now()
        ]);

        return redirect()->route('guru.users')->with('success', 'User berhasil ditambahkan!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri!');
        }
        
        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }

    public function publishPost($id)
    {
        $post = Post::where('id', $id)
                   ->where('user_id', Auth::id())
                   ->where('status', 'approved')
                   ->firstOrFail();
        
        $post->update([
            'is_published' => true,
            'published_at' => now()
        ]);
        
        return redirect()->route('guru.posts.index')->with('success', 'Artikel berhasil dipublikasi!');
    }

    public function destroyPost($id)
    {
        $post = Post::where('id', $id)
                   ->where('user_id', Auth::id())
                   ->whereIn('approval_status', ['rejected', 'draft'])
                   ->firstOrFail();
        
        $post->delete(); // Files will be automatically deleted via model boot method
        
        return redirect()->route('guru.posts.index')->with('success', 'Artikel dan semua file pendukung berhasil dihapus!');
    }

    public function storeArtikel(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:pengumuman,prestasi,lomba,kegiatan',
            'author_name' => 'required|string|max:255',
            'posted_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'author_name' => $request->author_name,
            'posted_date' => $request->posted_date,
            'user_id' => Auth::check() ? Auth::id() : 1,
            'status' => 'pending',
            'approval_status' => 'pending',
            'is_published' => false
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('posts', 'public');
        }



        Post::create($data);

        return redirect()->route('guru.dashboard')->with('success', 'Artikel berhasil dibuat dan menunggu persetujuan admin!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}