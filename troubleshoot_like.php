<?php
// Script troubleshooting untuk fitur like guru
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\PostLike;

echo "=== TROUBLESHOOTING FITUR LIKE GURU ===\n\n";

// 1. Check database connection
try {
    DB::connection()->getPdo();
    echo "✓ Database connection: OK\n";
} catch (Exception $e) {
    echo "✗ Database connection: FAILED - " . $e->getMessage() . "\n";
    exit;
}

// 2. Check guru users
echo "\n2. Checking guru users:\n";
$gurus = User::where('role', 'guru')->get();
echo "Total guru users: " . $gurus->count() . "\n";
foreach ($gurus as $guru) {
    echo "- {$guru->name} ({$guru->email}) - ID: {$guru->id}\n";
}

// 3. Check posts
echo "\n3. Checking posts:\n";
$posts = Post::where('status', 'approved')->take(3)->get();
echo "Total approved posts: " . $posts->count() . "\n";
foreach ($posts as $post) {
    echo "- Post ID: {$post->id} - {$post->title} - Likes: {$post->likes_count}\n";
}

// 4. Check post_likes table
echo "\n4. Checking post_likes table:\n";
try {
    $likes = PostLike::with(['user', 'post'])->take(10)->get();
    echo "Total likes in database: " . PostLike::count() . "\n";
    echo "Sample likes:\n";
    foreach ($likes as $like) {
        $userName = $like->user ? $like->user->name : 'Guest';
        $postTitle = $like->post ? $like->post->title : 'Unknown Post';
        echo "- User: {$userName} (ID: {$like->user_id}) liked '{$postTitle}' (Post ID: {$like->post_id}) - IP: {$like->ip_address}\n";
    }
} catch (Exception $e) {
    echo "✗ Error checking likes: " . $e->getMessage() . "\n";
}

// 5. Test like functionality for a specific guru
echo "\n5. Testing like functionality:\n";
if ($gurus->count() > 0) {
    $testGuru = $gurus->first();
    $testPost = $posts->first();
    
    if ($testPost) {
        echo "Testing with Guru: {$testGuru->name} (ID: {$testGuru->id})\n";
        echo "Testing with Post: {$testPost->title} (ID: {$testPost->id})\n";
        
        // Check if guru already liked this post
        $existingLike = PostLike::where('user_id', $testGuru->id)
                              ->where('post_id', $testPost->id)
                              ->first();
        
        if ($existingLike) {
            echo "✓ Guru already liked this post\n";
        } else {
            echo "- Guru hasn't liked this post yet\n";
        }
        
        // Test isLikedBy method
        $isLiked = $testPost->isLikedBy($testGuru->id);
        echo "isLikedBy result: " . ($isLiked ? 'true' : 'false') . "\n";
    }
}

// 6. Check disk space
echo "\n6. Checking disk space:\n";
$freeBytes = disk_free_space('.');
$totalBytes = disk_total_space('.');
$usedBytes = $totalBytes - $freeBytes;

echo "Total space: " . formatBytes($totalBytes) . "\n";
echo "Used space: " . formatBytes($usedBytes) . "\n";
echo "Free space: " . formatBytes($freeBytes) . "\n";

if ($freeBytes < 100 * 1024 * 1024) { // Less than 100MB
    echo "⚠️  WARNING: Low disk space! This might cause issues.\n";
} else {
    echo "✓ Disk space: OK\n";
}

// 7. Check log files
echo "\n7. Checking log files:\n";
$logPath = 'storage/logs/laravel.log';
if (file_exists($logPath)) {
    $logSize = filesize($logPath);
    echo "Laravel log size: " . formatBytes($logSize) . "\n";
    if ($logSize > 10 * 1024 * 1024) { // More than 10MB
        echo "⚠️  WARNING: Log file is large. Consider cleaning it.\n";
    }
} else {
    echo "Laravel log file not found\n";
}

echo "\n=== TROUBLESHOOTING COMPLETED ===\n";

function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    
    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    
    return round($bytes, $precision) . ' ' . $units[$i];
}