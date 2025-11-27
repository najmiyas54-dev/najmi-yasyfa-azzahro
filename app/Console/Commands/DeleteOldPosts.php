<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Carbon\Carbon;

class DeleteOldPosts extends Command
{
    protected $signature = 'posts:delete-old';
    protected $description = 'Delete posts older than 3 days for pengumuman category';

    public function handle()
    {
        $threeDaysAgo = Carbon::now()->subDays(3);
        
        $deletedCount = Post::where('category', 'pengumuman')
                           ->where('created_at', '<', $threeDaysAgo)
                           ->delete();
        
        $this->info("Deleted {$deletedCount} old pengumuman posts.");
        
        return 0;
    }
}