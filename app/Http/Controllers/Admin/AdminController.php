<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin;
use App\Models\Post;
use App\Models\Achievement;
use App\Models\Competition;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check if it's a guru trying to login as admin
        if (str_contains($credentials['email'], 'guru')) {
            return back()->withErrors(['email' => 'Akun guru tidak dapat login sebagai admin. Gunakan login guru.'])->withInput();
        }

        $admin = Admin::where('email', $credentials['email'])->first();
        
        if (!$admin) {
            return back()->withErrors(['email' => 'Email tidak ditemukan'])->withInput();
        }
        
        if (!Hash::check($credentials['password'], $admin->password)) {
            return back()->withErrors(['password' => 'Password salah'])->withInput();
        }
        
        // Login berhasil - set session
        session([
            'admin_id' => $admin->id, 
            'admin_name' => $admin->name,
            'admin_logged_in' => true
        ]);
        
        return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
    }

    public function dashboard()
    {
        $totalPosts = Post::count();
        $totalUsers = \App\Models\User::count();
        $pendingPostsCount = Post::where('approval_status', 'pending')->count();
        
        $stats = [
            'posts' => $totalPosts,
            'users' => $totalUsers,
            'pengumuman' => Post::where('category', 'pengumuman')->count(),
            'prestasi' => Post::where('category', 'prestasi')->count(),
            'lomba' => Post::where('category', 'lomba')->count(),
            'kegiatan' => Post::where('category', 'kegiatan')->count()
        ];
        
        $pendingPosts = Post::where('approval_status', 'pending')
                            ->with('user')
                            ->latest()
                            ->take(5)
                            ->get();
        
        return view('admin.dashboard', compact('stats', 'pendingPosts', 'totalPosts', 'totalUsers', 'pendingPostsCount'));
    }

    public function pendingPosts()
    {
        try {
            $pendingPosts = Post::where('approval_status', 'pending')
                                ->with('user')
                                ->latest()
                                ->paginate(10);
            return view('admin.pending-posts', compact('pendingPosts'));
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Terjadi kesalahan saat memuat posts pending.');
        }
    }

    public function approvePost($id)
    {
        $post = Post::findOrFail($id);
        $post->update([
            'approval_status' => 'published',
            'is_published' => true,
            'published_at' => now()
        ]);
        return back()->with('success', 'Artikel berhasil disetujui dan dipublish!');
    }

    public function rejectPost($id)
    {
        $post = Post::findOrFail($id);
        $post->update(['status' => 'rejected']);
        return back()->with('success', 'Artikel berhasil ditolak!');
    }

    public function categories()
    {
        try {
            $pengumumanCount = Post::where('category', 'pengumuman')->count();
            $prestasiCount = Post::where('category', 'prestasi')->count();
            $beritaCount = Post::where('category', 'berita')->count();
            $lombaCount = Post::where('category', 'lomba')->count();
            
            return view('admin.categories.index', compact('pengumumanCount', 'prestasiCount', 'beritaCount', 'lombaCount'));
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Terjadi kesalahan saat memuat kategori.');
        }
    }

    public function categoryTable($category)
    {
        try {
            $posts = Post::where('category', $category)
                         ->with('user')
                         ->latest()
                         ->paginate(10);
            return view('admin.categories.table', compact('posts', 'category'));
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Terjadi kesalahan saat memuat data kategori.');
        }
    }

    public function logout()
    {
        session()->forget(['admin_id', 'admin_name', 'admin_logged_in']);
        return redirect()->route('home')->with('success', 'Logout berhasil!');
    }
}
