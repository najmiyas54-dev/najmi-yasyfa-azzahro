<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;

class FixLikesCount extends Command
{
    protected $signature = 'fix:likes-count';
    protected $description = 'Fix likes_count for all posts';

    public function handle()
    {
        $posts = Post::all();
        
        foreach ($posts as $post) {
            $actualCount = $post->likes()->count();
            $post->update(['likes_count' => $actualCount]);
            $this->info("Post {$post->id}: Updated likes_count to {$actualCount}");
        }
        
        $this->info('All posts likes_count have been fixed!');
    }
}