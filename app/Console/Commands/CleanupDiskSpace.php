<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CleanupDiskSpace extends Command
{
    protected $signature = 'cleanup:disk';
    protected $description = 'Clean up disk space by removing old logs and cache files';

    public function handle()
    {
        $this->info('Starting disk cleanup...');
        
        // Clear Laravel caches
        $this->info('Clearing Laravel caches...');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        
        // Clean log files
        $this->info('Cleaning log files...');
        $logPath = storage_path('logs');
        if (File::exists($logPath)) {
            $files = File::files($logPath);
            foreach ($files as $file) {
                if ($file->getExtension() === 'log') {
                    File::delete($file->getPathname());
                }
            }
            // Create empty laravel.log
            File::put($logPath . '/laravel.log', '');
        }
        
        // Clean session files
        $this->info('Cleaning session files...');
        $sessionPath = storage_path('framework/sessions');
        if (File::exists($sessionPath)) {
            File::cleanDirectory($sessionPath);
        }
        
        // Clean compiled views
        $this->info('Cleaning compiled views...');
        $viewPath = storage_path('framework/views');
        if (File::exists($viewPath)) {
            File::cleanDirectory($viewPath);
        }
        
        // Clean cache files
        $this->info('Cleaning cache files...');
        $cachePath = storage_path('framework/cache');
        if (File::exists($cachePath)) {
            File::cleanDirectory($cachePath);
        }
        
        $this->info('Disk cleanup completed successfully!');
        
        return 0;
    }
}