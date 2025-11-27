<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_published', true)
                    ->where('approval_status', 'published')
                    ->with(['user:id,name'])
                    ->latest('created_at')
                    ->paginate(6);
        
        return view('pages.blog', compact('posts'));
    }

    public function destinations()
    {
        $posts = Post::where('type', 'destination')
                    ->where('is_published', true)
                    ->where('approval_status', 'published')
                    ->latest()
                    ->get();
        return view('pages.destinations', compact('posts'));
    }

    public function stories()
    {
        $posts = Post::where('type', 'story')
                    ->where('is_published', true)
                    ->where('approval_status', 'published')
                    ->latest()
                    ->get();
        return view('pages.mystories', compact('posts'));
    }

    public function competitions()
    {
        $competitions = Post::where('category', 'lomba')
                            ->where('is_published', true)
                            ->where('approval_status', 'published')
                            ->latest()
                            ->paginate(6);
        return view('pages.competitions', compact('competitions'));
    }

    public function show($id)
    {
        $post = Post::where('approval_status', 'published')
                   ->with(['user'])
                   ->findOrFail($id);
        // Increment views count
        $post->increment('views_count');
        return view('pages.single', compact('post'));
    }

    public function like($id)
    {
        try {
            $post = Post::findOrFail($id);
            $ipAddress = request()->ip();
            $userId = Auth::id();
            
            // Use simple IP for guests, user_id for logged users
            $identifier = $userId ? $userId : $ipAddress;
            
            // Ensure likes_count is not null
            if (is_null($post->likes_count)) {
                $actualCount = $post->likes()->count();
                $post->update(['likes_count' => $actualCount]);
                $post->refresh();
            }
            
            // Check existing like
            if ($userId) {
                $existingLike = $post->likes()->where('user_id', $userId)->first();
            } else {
                $existingLike = $post->likes()->where('ip_address', $ipAddress)->first();
            }
            
            if ($existingLike) {
                // Unlike - remove the like
                $existingLike->delete();
                $liked = false;
            } else {
                // Like - create new like
                $likeData = ['ip_address' => $ipAddress];
                if ($userId) {
                    $likeData['user_id'] = $userId;
                }
                
                $post->likes()->create($likeData);
                $liked = true;
            }
            
            // Always recalculate likes_count from actual data
            $actualCount = $post->likes()->count();
            $post->update(['likes_count' => $actualCount]);
            
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $actualCount,

            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),

            ], 500);
        }
    }




}