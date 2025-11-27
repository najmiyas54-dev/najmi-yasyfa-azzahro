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

class StudentController extends Controller
{
    public function login()
    {
        return view('student.login');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Check if it's a guru trying to login as student
        if (str_contains($credentials['email'], 'guru')) {
            return back()->withErrors(['email' => 'Akun guru tidak dapat login sebagai siswa. Gunakan login guru.'])->withInput();
        }

        $user = User::where('email', $credentials['email'])->first();
        
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
        }

        // Check if user is student
        if ($user->role !== 'siswa') {
            return back()->withErrors(['email' => 'Anda tidak memiliki akses sebagai siswa'])->withInput();
        }

        // Check if user is approved
        if (!$user->is_approved) {
            return back()->withErrors(['email' => 'Akun Anda belum disetujui oleh admin. Silakan tunggu persetujuan.'])->withInput();
        }

        Auth::login($user);
        return redirect()->route('student.dashboard');
    }



    public function dashboard()
    {
        $posts = Post::where('status', 'approved')->where('is_published', true)->with('user')->latest()->take(10)->get();
        $myPosts = Post::where('user_id', Auth::id())->where('status', '!=', 'draft')->latest()->take(5)->get();
        $allMyPosts = Post::where('user_id', Auth::id())->where('status', '!=', 'draft')->get();
        $drafts = Post::where('user_id', Auth::id())->where('status', 'draft')->latest()->get();
        $notifications = Notification::where('user_id', Auth::id())->where('is_read', false)->latest()->take(5)->get();
        
        return view('student.dashboard', compact('posts', 'myPosts', 'allMyPosts', 'drafts', 'notifications'));
    }

    public function createPost()
    {
        return view('student.create-post');
    }

    public function postsIndex()
    {
        $posts = Post::where('user_id', Auth::id())->latest()->get();
        return view('student.posts.index', compact('posts'));
    }

    public function storePost(Request $request)
    {
        $isDraft = $request->has('save_draft');
        
        if ($isDraft) {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'category' => 'nullable|in:pengumuman,prestasi,lomba,kegiatan',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'posted_date' => 'nullable|date',
                'author_name' => 'nullable|string|max:255'
            ]);
        } else {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'category' => 'required|in:pengumuman,prestasi,lomba,kegiatan',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'posted_date' => 'required|date',
                'author_name' => 'required|string|max:255'
            ]);
        }

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'user_id' => Auth::id(),
            'status' => $isDraft ? 'draft' : 'pending',
            'approval_status' => $isDraft ? 'draft' : 'pending',
            'is_published' => false,
            'posted_date' => $request->posted_date,
            'author_name' => $request->author_name
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('posts', 'public');
        }



        $post = Post::create($data);

        if (!$isDraft) {
            // Send notification to all gurus only if not draft
            $gurus = User::where('role', 'guru')->get();
            foreach ($gurus as $guru) {
                Notification::create([
                    'user_id' => $guru->id,
                    'post_id' => $post->id,
                    'type' => 'pending_guru_review',
                    'title' => 'Artikel Baru Perlu Review',
                    'message' => 'Siswa "' . Auth::user()->name . '" telah membuat artikel "' . $post->title . '" yang perlu direview.'
                ]);
            }
            return redirect()->route('student.dashboard')->with('success', 'Artikel berhasil dibuat dan menunggu review guru!');
        }

        return redirect()->route('student.dashboard')->with('success', 'Draft artikel berhasil disimpan!');
    }

    public function editPost($id)
    {
        $post = Post::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('student.edit-post', compact('post'));
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
            'category' => $request->category,
            'status' => 'pending',
            'approval_status' => 'pending'
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

        return redirect()->route('student.dashboard')->with('success', 'Artikel berhasil diupdate dan menunggu review guru!');
    }

    public function showPost($id)
    {
        $post = Post::where('status', 'approved')->with('user', 'comments.user')->findOrFail($id);
        return view('student.show-post', compact('post'));
    }

    public function previewPost($id)
    {
        $post = Post::where('user_id', Auth::id())->findOrFail($id);
        return view('student.preview-post', compact('post'));
    }

    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string'
        ]);

        Comment::create([
            'post_id' => $id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
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
        
        $categoryName = '';
        switch($post->category) {
            case 'prestasi':
                $categoryName = 'Prestasi';
                break;
            case 'pengumuman':
                $categoryName = 'Pengumuman';
                break;
            case 'lomba':
                $categoryName = 'Lomba';
                break;
            case 'kegiatan':
                $categoryName = 'Kegiatan';
                break;
            default:
                $categoryName = 'Website';
        }
        
        return redirect()->back()->with('success', 'Artikel berhasil dipublish ke halaman ' . $categoryName . '!');
    }

    public function usersIndex()
    {
        $users = User::where('role', 'siswa')->latest()->paginate(10);
        return view('student.users.index', compact('users'));
    }

    public function usersCreate()
    {
        return view('student.users.create');
    }

    public function usersStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:siswa'
        ]);

        User::create([
            'name' => $request->name,
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'active'
        ]);

        return redirect()->route('student.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function usersDelete($id)
    {
        $user = User::where('id', $id)->where('role', 'siswa')->firstOrFail();
        $user->delete();
        
        return redirect()->route('student.users.index')->with('success', 'User berhasil dihapus!');
    }

    public function forgotPassword()
    {
        return view('student.forgot-password');
    }

    public function forgotPasswordPost(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }
        
        // Generate reset token
        $token = \Str::random(60);
        
        // Store in password_reset_tokens table
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );
        
        // Send email notification
        try {
            \Mail::send('emails.reset-password', [
                'user' => $user,
                'resetLink' => route('student.reset-password', $token)
            ], function($message) use ($user) {
                $message->to($user->email, $user->name)
                        ->subject('Reset Password - E-Mading SMK Bakti Nusantara 666');
            });
            
            return back()->with('success', 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau spam folder.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email. Silakan coba lagi.']);
        }
    }

    public function resetPassword($token)
    {
        $resetData = \DB::table('password_reset_tokens')->where('token', $token)->first();
        
        if (!$resetData || $resetData->created_at < now()->subHours(1)) {
            return redirect()->route('student.login')->withErrors(['token' => 'Token tidak valid atau sudah expired']);
        }
        
        return view('student.reset-password', compact('token'));
    }

    public function resetPasswordPost(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);
        
        $resetData = \DB::table('password_reset_tokens')->where('token', $request->token)->first();
        
        if (!$resetData) {
            return back()->withErrors(['token' => 'Token tidak valid']);
        }
        
        $user = User::where('email', $resetData->email)->first();
        $user->update(['password' => Hash::make($request->password)]);
        
        \DB::table('password_reset_tokens')->where('token', $request->token)->delete();
        
        return redirect()->route('student.login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }

    public function markNotificationRead($id)
    {
        $notification = Notification::where('id', $id)->where('user_id', Auth::id())->first();
        if ($notification) {
            $notification->update(['is_read' => true]);
        }
        return response()->json(['success' => true]);
    }

    public function deletePost($id)
    {
        $post = Post::where('id', $id)
                   ->where('user_id', Auth::id())
                   ->whereIn('approval_status', ['rejected', 'draft'])
                   ->firstOrFail();
        
        $post->delete(); // Files will be automatically deleted via model boot method
        
        $message = $post->status === 'draft' ? 'Draft dan file pendukung berhasil dihapus!' : 'Artikel dan file pendukung berhasil dihapus!';
        return redirect()->back()->with('success', $message);
    }

    public function drafts()
    {
        $drafts = Post::where('user_id', Auth::id())
                     ->where('status', 'draft')
                     ->latest()
                     ->paginate(10);
        
        return view('student.drafts', compact('drafts'));
    }

    public function submitDraft($id)
    {
        $post = Post::where('id', $id)
                   ->where('user_id', Auth::id())
                   ->where('status', 'draft')
                   ->firstOrFail();
        
        // Validate required fields before submission
        if (!$post->content || !$post->category || !$post->posted_date || !$post->author_name) {
            return redirect()->back()->with('error', 'Lengkapi semua field yang diperlukan sebelum mengirim untuk review!');
        }
        
        $post->update([
            'status' => 'pending',
            'approval_status' => 'pending'
        ]);
        
        // Send notification to all gurus
        $gurus = User::where('role', 'guru')->get();
        foreach ($gurus as $guru) {
            Notification::create([
                'user_id' => $guru->id,
                'post_id' => $post->id,
                'type' => 'pending_guru_review',
                'title' => 'Artikel Baru Perlu Review',
                'message' => 'Siswa "' . Auth::user()->name . '" telah mengirim artikel "' . $post->title . '" untuk direview.'
            ]);
        }
        
        return redirect()->route('student.dashboard')->with('success', 'Draft berhasil dikirim untuk review guru!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}