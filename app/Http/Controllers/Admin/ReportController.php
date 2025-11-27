<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $totalPosts = Post::count();
        $publishedPosts = Post::where('is_published', true)->count();
        $pendingPosts = Post::where('status', 'pending')->count();
        $approvedPosts = Post::where('status', 'approved')->count();
        $rejectedPosts = Post::where('status', 'rejected')->count();
        
        $totalUsers = User::count();
        $siswaCount = User::where('role', 'siswa')->count();
        $guruCount = User::where('role', 'guru')->count();
        $adminCount = User::where('role', 'admin')->count();
        
        $postsByCategory = Post::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->get();
            
        $recentPosts = Post::with('user')->latest()->take(10)->get();
        
        return view('admin.reports.index', compact(
            'totalPosts', 'publishedPosts', 'pendingPosts', 'approvedPosts', 'rejectedPosts',
            'totalUsers', 'siswaCount', 'guruCount', 'adminCount',
            'postsByCategory', 'recentPosts'
        ));
    }
    
    public function generatePDF(Request $request)
    {
        $type = $request->get('type', 'summary');
        
        $data = [
            'totalPosts' => Post::count(),
            'publishedPosts' => Post::where('is_published', true)->count(),
            'pendingPosts' => Post::where('status', 'pending')->count(),
            'approvedPosts' => Post::where('status', 'approved')->count(),
            'rejectedPosts' => Post::where('status', 'rejected')->count(),
            'totalUsers' => User::count(),
            'siswaCount' => User::where('role', 'siswa')->count(),
            'guruCount' => User::where('role', 'guru')->count(),
            'adminCount' => User::where('role', 'admin')->count(),
            'postsByCategory' => Post::selectRaw('category, COUNT(*) as count')->groupBy('category')->get(),
            'recentPosts' => Post::with('user')->latest()->take(20)->get(),
            'generatedAt' => now()->format('d/m/Y H:i:s')
        ];
        
        $pdf = PDF::loadView('admin.reports.pdf', $data);
        
        return $pdf->download('laporan-emading-' . now()->format('Y-m-d') . '.pdf');
    }
}