<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home.root');

// Registration route



// Student routes
Route::get('/student/login', [\App\Http\Controllers\StudentController::class, 'login'])->name('student.login');
Route::post('/student/login', [\App\Http\Controllers\StudentController::class, 'loginPost'])->name('student.login.post');
Route::get('/student/register', [\App\Http\Controllers\AuthController::class, 'showStudentRegister'])->name('student.register');
Route::post('/student/register', [\App\Http\Controllers\AuthController::class, 'studentRegister'])->name('student.register.post');

// Guru routes
Route::get('/guru/login', [\App\Http\Controllers\GuruController::class, 'login'])->name('guru.login');
Route::post('/guru/login', [\App\Http\Controllers\GuruController::class, 'loginPost'])->name('guru.login.post');
Route::get('/guru/register', [\App\Http\Controllers\AuthController::class, 'showGuruRegister'])->name('guru.register');
Route::post('/guru/register', [\App\Http\Controllers\AuthController::class, 'guruRegister'])->name('guru.register.post');



// Protected student routes
Route::middleware('student')->prefix('student')->name('student.')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('create-post', [\App\Http\Controllers\StudentController::class, 'createPost'])->name('create-post');
    Route::get('posts', [\App\Http\Controllers\StudentController::class, 'postsIndex'])->name('posts.index');
    Route::get('drafts', [\App\Http\Controllers\StudentController::class, 'drafts'])->name('drafts');
    Route::post('store-post', [\App\Http\Controllers\StudentController::class, 'storePost'])->name('store-post');
    Route::get('edit-post/{id}', [\App\Http\Controllers\StudentController::class, 'editPost'])->name('edit-post');
    Route::put('update-post/{id}', [\App\Http\Controllers\StudentController::class, 'updatePost'])->name('update-post');
    Route::get('show-post/{id}', [\App\Http\Controllers\StudentController::class, 'showPost'])->name('show-post');
    Route::get('preview-post/{id}', [\App\Http\Controllers\StudentController::class, 'previewPost'])->name('preview-post');
    Route::post('add-comment/{id}', [\App\Http\Controllers\StudentController::class, 'addComment'])->name('add-comment');
    Route::post('publish-post/{id}', [\App\Http\Controllers\StudentController::class, 'publishPost'])->name('publish-post');
    Route::get('users', [\App\Http\Controllers\StudentController::class, 'usersIndex'])->name('users.index');
    Route::get('users/create', [\App\Http\Controllers\StudentController::class, 'usersCreate'])->name('users.create');
    Route::post('users', [\App\Http\Controllers\StudentController::class, 'usersStore'])->name('users.store');
    Route::delete('users/{id}', [\App\Http\Controllers\StudentController::class, 'usersDelete'])->name('users.delete');
    Route::delete('delete-post/{id}', [\App\Http\Controllers\StudentController::class, 'deletePost'])->name('delete-post');
    Route::post('notifications/{id}/read', [\App\Http\Controllers\StudentController::class, 'markNotificationRead'])->name('notifications.read');
    Route::post('submit-draft/{id}', [\App\Http\Controllers\StudentController::class, 'submitDraft'])->name('submit-draft');
    Route::post('logout', [\App\Http\Controllers\StudentController::class, 'logout'])->name('logout');
});

// Test route for guru create post
Route::get('/guru/test-create', function() {
    return '<h1>Test Route Works!</h1><a href="/guru/posts/create">Go to Create Post</a>';
})->name('guru.test.create');

Route::get('/guru/create-article', function() {
    return view('guru.create-artikel');
})->name('guru.create.article');

Route::post('/guru/store-artikel', [\App\Http\Controllers\GuruController::class, 'storeArtikel'])->name('guru.store.artikel');

// Protected guru routes
Route::middleware('guru')->prefix('guru')->name('guru.')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\GuruController::class, 'dashboard'])->name('dashboard');
    Route::get('posts', [\App\Http\Controllers\GuruController::class, 'posts'])->name('posts.index');
    Route::get('all-posts', [\App\Http\Controllers\GuruController::class, 'allPosts'])->name('all-posts');
    Route::get('posts/{id}', [\App\Http\Controllers\Guru\PostController::class, 'show'])->name('posts.show');
    Route::post('posts/{id}/approve', [\App\Http\Controllers\Guru\PostController::class, 'approve'])->name('posts.approve');
    Route::post('posts/{id}/reject', [\App\Http\Controllers\Guru\PostController::class, 'reject'])->name('posts.reject');
    Route::get('posts/create', [\App\Http\Controllers\GuruController::class, 'createPost'])->name('posts.create');
    Route::post('posts', [\App\Http\Controllers\GuruController::class, 'storePost'])->name('posts.store');
    Route::get('posts/{id}/edit', [\App\Http\Controllers\GuruController::class, 'editPost'])->name('posts.edit');
    Route::put('posts/{id}', [\App\Http\Controllers\GuruController::class, 'updatePost'])->name('posts.update');
    Route::post('posts/{id}/publish', [\App\Http\Controllers\GuruController::class, 'publishPost'])->name('posts.publish');
    Route::delete('posts/{id}', [\App\Http\Controllers\GuruController::class, 'destroyPost'])->name('posts.destroy');
    Route::get('student-posts', [\App\Http\Controllers\GuruController::class, 'studentPosts'])->name('student-posts');
    Route::get('review-posts', [\App\Http\Controllers\GuruController::class, 'studentPosts'])->name('review-posts');
    Route::get('detail-post/{id}', [\App\Http\Controllers\GuruController::class, 'detailPost'])->name('detail-post');
    Route::get('review-article/{id}', [\App\Http\Controllers\GuruController::class, 'reviewArticle'])->name('review-article');
    Route::post('approve-post/{id}', [\App\Http\Controllers\GuruController::class, 'approveStudentPost'])->name('approve-post');
    Route::post('reject-post/{id}', [\App\Http\Controllers\GuruController::class, 'rejectStudentPost'])->name('reject-post');
    Route::post('student-posts/{id}/approve', [\App\Http\Controllers\GuruController::class, 'approveStudentPost'])->name('student-posts.approve');
    Route::post('student-posts/{id}/reject', [\App\Http\Controllers\GuruController::class, 'rejectStudentPost'])->name('student-posts.reject');
    Route::get('users', [\App\Http\Controllers\GuruController::class, 'users'])->name('users');
    Route::get('users/create', [\App\Http\Controllers\GuruController::class, 'createUser'])->name('users.create');
    Route::post('users', [\App\Http\Controllers\GuruController::class, 'storeUser'])->name('users.store');
    Route::delete('users/{id}', [\App\Http\Controllers\GuruController::class, 'deleteUser'])->name('users.delete');
    Route::post('logout', [\App\Http\Controllers\GuruController::class, 'logout'])->name('logout');
});
Route::get('/home', [PageController::class, 'home'])->name('home');
Route::get('/public', [PageController::class, 'home'])->name('public');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/blog', [PostController::class, 'index'])->name('blog');
Route::get('/destinations', [PostController::class, 'destinations'])->name('destinations');
Route::get('/mystories', [PostController::class, 'stories'])->name('mystories');
Route::get('/competitions', [PostController::class, 'competitions'])->name('competitions');
Route::get('/competition/{id}', [CompetitionController::class, 'show'])->name('competition.detail');
Route::get('/prestasi', [PageController::class, 'prestasi'])->name('prestasi');
Route::get('/prestasi-list', [\App\Http\Controllers\PrestasiController::class, 'index'])->name('prestasi.index');
Route::middleware('auth')->group(function () {
    Route::get('/prestasi/create', [\App\Http\Controllers\PrestasiController::class, 'create'])->name('prestasi.create');
    Route::post('/prestasi', [\App\Http\Controllers\PrestasiController::class, 'store'])->name('prestasi.store');
});

Route::get('/lomba', [PageController::class, 'lomba'])->name('lomba');
Route::get('/kegiatan', [PageController::class, 'kegiatan'])->name('kegiatan');
Route::get('/pengumuman', [PageController::class, 'pengumuman'])->name('pengumuman');
Route::get('/search', [PageController::class, 'search'])->name('search');
Route::get('/single/{id}', [PostController::class, 'show'])->name('single');
Route::post('/post/{id}/like', [PostController::class, 'like'])->name('post.like');





// Admin routes
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AdminController as MainAdminController;

// Login routes (no middleware)
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

// Test login sederhana
Route::get('/admin/test-login', function() {
    return view('admin.simple-login');
})->name('admin.test.login');

Route::post('/admin/test-login', function(\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $admin = \App\Models\Admin::where('email', $credentials['email'])->first();
    
    if ($admin && \Illuminate\Support\Facades\Hash::check($credentials['password'], $admin->password)) {
        session([
            'admin_id' => $admin->id, 
            'admin_name' => $admin->name,
            'admin_logged_in' => true
        ]);
        return redirect('/admin/dashboard')->with('success', 'Login berhasil!');
    }

    return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
})->name('admin.test.login.submit');

// Protected admin routes
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    // Dashboard routes
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [AdminController::class, 'logout'])->name('logout');
    
    // Notification routes
    Route::get('notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/approve/{id}', [\App\Http\Controllers\Admin\NotificationController::class, 'approve'])->name('notifications.approve');
    Route::post('notifications/reject/{id}', [\App\Http\Controllers\Admin\NotificationController::class, 'reject'])->name('notifications.reject');
    Route::post('notifications/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    
    // CRUD Routes
    Route::resource('posts', App\Http\Controllers\Admin\PostController::class);
    Route::resource('achievements', App\Http\Controllers\Admin\AchievementController::class);
    Route::resource('competitions', App\Http\Controllers\Admin\CompetitionController::class);
    
    // Category management routes
    Route::get('categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'show'])->name('categories.show');
    Route::get('categories/{category}/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/{id}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Prestasi management
    Route::get('prestasi', [\App\Http\Controllers\Admin\PrestasiController::class, 'index'])->name('prestasi.index');
    Route::get('prestasi/{prestasi}', [\App\Http\Controllers\Admin\PrestasiController::class, 'show'])->name('prestasi.show');
    Route::post('prestasi/{prestasi}/approve', [\App\Http\Controllers\Admin\PrestasiController::class, 'approve'])->name('prestasi.approve');
    Route::post('prestasi/{prestasi}/reject', [\App\Http\Controllers\Admin\PrestasiController::class, 'reject'])->name('prestasi.reject');
    Route::delete('prestasi/{prestasi}', [\App\Http\Controllers\Admin\PrestasiController::class, 'destroy'])->name('prestasi.destroy');
    
    // Post management
    Route::get('posts', [\App\Http\Controllers\Admin\PostController::class, 'index'])->name('posts.index');
    Route::get('posts/pending-review', [\App\Http\Controllers\Admin\PostController::class, 'pendingReview'])->name('posts.pending-review');
    Route::get('posts/preview/{id}', [\App\Http\Controllers\Admin\PostController::class, 'previewPost'])->name('posts.preview');
    Route::post('posts/{id}/approve', [\App\Http\Controllers\Admin\PostController::class, 'approve'])->name('posts.approve');
    Route::post('posts/{id}/reject', [\App\Http\Controllers\Admin\PostController::class, 'reject'])->name('posts.reject');
    Route::delete('posts/{post}', [\App\Http\Controllers\Admin\PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('approve-post/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'approvePost'])->name('approve-post');
    Route::post('reject-post/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'rejectPost'])->name('reject-post');
    
    // Review workflow routes
    Route::get('pending-posts', [MainAdminController::class, 'pendingPosts'])->name('pending-posts');
    Route::post('posts/{id}/approve', [MainAdminController::class, 'approvePost'])->name('posts.approve');
    Route::post('posts/{id}/reject', [MainAdminController::class, 'rejectPost'])->name('posts.reject');
    
    // User management routes
    Route::get('users', [MainAdminController::class, 'users'])->name('users');
    Route::post('users', [MainAdminController::class, 'storeUser'])->name('users.store');
    Route::post('users/{id}/approve', [MainAdminController::class, 'approveUser'])->name('users.approve');
    Route::post('users/{id}/reject', [MainAdminController::class, 'rejectUser'])->name('users.reject');
    Route::delete('users/{id}', [MainAdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Reports
    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports');
    Route::get('reports/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'generatePDF'])->name('reports.pdf');
});