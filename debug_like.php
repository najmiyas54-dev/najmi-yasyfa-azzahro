<?php
// Debug script untuk testing like functionality
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Simulate request
$request = Illuminate\Http\Request::create('/post/1/like', 'POST');
$request->headers->set('X-CSRF-TOKEN', 'test-token');

// Test authentication
echo "=== DEBUGGING LIKE FUNCTIONALITY ===\n";
echo "1. Testing Auth system:\n";

// Check if user table has guru
$users = DB::table('users')->where('email', 'like', '%guru%')->get();
echo "Guru users found: " . $users->count() . "\n";
foreach ($users as $user) {
    echo "- {$user->name} ({$user->email}) - Role: {$user->role}\n";
}

// Check posts
$posts = DB::table('posts')->where('status', 'approved')->take(3)->get();
echo "\n2. Available posts:\n";
foreach ($posts as $post) {
    echo "- Post ID: {$post->id} - {$post->title}\n";
}

// Check post_likes table structure
echo "\n3. Post likes table structure:\n";
$likes = DB::table('post_likes')->take(5)->get();
echo "Total likes: " . $likes->count() . "\n";
foreach ($likes as $like) {
    echo "- Post: {$like->post_id}, User: {$like->user_id}, IP: {$like->ip_address}\n";
}

echo "\n=== END DEBUG ===\n";