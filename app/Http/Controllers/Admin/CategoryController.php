<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $pengumumanCount = Post::where('category', 'pengumuman')->count();
        $prestasiCount = Post::where('category', 'prestasi')->count();
        $beritaCount = Post::where('category', 'kegiatan')->count();
        $lombaCount = Post::where('category', 'lomba')->count();

        return view('admin.categories.index', compact(
            'pengumumanCount', 'prestasiCount', 'beritaCount', 'lombaCount'
        ));
    }

    public function show($category)
    {
        $articles = Post::where('category', $category)->with('user')->latest()->get();
        
        return view('admin.categories.show', compact('articles', 'category'));
    }

    public function create($category)
    {
        return view('admin.categories.create', compact('category'));
    }

    public function store(Request $request, $category)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'category' => $category,
            'status' => 'approved',
            'is_published' => true,
            'posted_date' => now()
        ];
        
        // Handle file upload
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('posts/images', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.categories.show', $category)
                        ->with('success', ucfirst($category) . ' berhasil ditambahkan');
    }

    public function edit($category, $id)
    {
        $article = Post::where('category', $category)->findOrFail($id);
        
        return view('admin.categories.edit', compact('article', 'category'));
    }

    public function update(Request $request, $category, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $article = Post::where('category', $category)->findOrFail($id);
        
        $data = [
            'title' => $request->title,
            'content' => $request->content
        ];
        
        // Handle file upload
        if ($request->hasFile('image')) {
            if ($article->image_path) {
                \Storage::delete('public/' . $article->image_path);
            }
            $data['image_path'] = $request->file('image')->store('posts/images', 'public');
        }
        
        $article->update($data);

        return redirect()->route('admin.categories.show', $category)
                        ->with('success', ucfirst($category) . ' berhasil diupdate');
    }

    public function destroy($category, $id)
    {
        $article = Post::where('category', $category)->findOrFail($id);
        
        // Delete image if exists
        if ($article->image_path) {
            \Storage::delete('public/' . $article->image_path);
        }
        
        // Delete file if exists
        if ($article->file_path) {
            \Storage::delete('public/' . $article->file_path);
        }
        
        $article->delete();

        return redirect()->route('admin.categories.show', $category)
                        ->with('success', ucfirst($category) . ' berhasil dihapus');
    }
}