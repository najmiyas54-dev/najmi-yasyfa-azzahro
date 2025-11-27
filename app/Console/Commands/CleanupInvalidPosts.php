<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\User;

class CleanupInvalidPosts extends Command
{
    protected $signature = 'posts:cleanup-invalid';
    protected $description = 'Remove posts not created by admin, guru, or siswa';

    public function handle()
    {
        $this->info('Starting cleanup of invalid posts...');

        // Get all posts with their users
        $invalidPosts = Post::whereHas('user', function($query) {
            $query->whereNotIn('role', ['admin', 'siswa'])
                  ->where('email', 'NOT LIKE', '%guru%');
        })->orWhereDoesntHave('user');

        $count = $invalidPosts->count();
        
        if ($count == 0) {
            $this->info('No invalid posts found.');
            return;
        }

        $this->info("Found {$count} invalid posts to delete:");
        
        foreach ($invalidPosts->get() as $post) {
            $this->line("- ID: {$post->id}, Title: {$post->title}, User: " . ($post->user ? $post->user->name . " ({$post->user->role})" : 'No User'));
        }

        if ($this->confirm('Do you want to delete these posts?')) {
            $invalidPosts->delete();
            $this->info("Successfully deleted {$count} invalid posts.");
        } else {
            $this->info('Cleanup cancelled.');
        }
    }
}