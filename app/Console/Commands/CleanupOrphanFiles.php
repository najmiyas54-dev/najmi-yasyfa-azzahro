<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

class CleanupOrphanFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:orphan-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up orphaned files in storage that are not referenced by any posts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting cleanup of orphaned files...');
        
        // Get all files in posts directory
        $allFiles = Storage::files('public/posts');
        
        // Get all file paths from database
        $usedImagePaths = Post::whereNotNull('image_path')->pluck('image_path')->toArray();
        $usedFilePaths = Post::whereNotNull('file_path')->pluck('file_path')->toArray();
        
        // Combine all used paths and add 'public/' prefix
        $usedPaths = array_merge($usedImagePaths, $usedFilePaths);
        $usedPaths = array_map(function($path) {
            return 'public/' . $path;
        }, $usedPaths);
        
        $deletedCount = 0;
        $deletedSize = 0;
        
        foreach ($allFiles as $file) {
            // Skip if file is still being used
            if (in_array($file, $usedPaths)) {
                continue;
            }
            
            // Skip directories
            if (Storage::directoryExists($file)) {
                continue;
            }
            
            // Get file size before deletion
            $fileSize = Storage::size($file);
            
            // Delete orphaned file
            if (Storage::delete($file)) {
                $this->line("Deleted: " . basename($file));
                $deletedCount++;
                $deletedSize += $fileSize;
            }
        }
        
        $this->info("Cleanup completed!");
        $this->info("Files deleted: {$deletedCount}");
        $this->info("Space freed: " . $this->formatBytes($deletedSize));
    }
    
    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}