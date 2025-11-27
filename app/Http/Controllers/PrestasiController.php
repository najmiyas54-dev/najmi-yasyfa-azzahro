<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function create()
    {
        return view('prestasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120'
        ]);

        $data = $request->only(['title', 'content']);
        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('prestasi/images', 'public');
        }

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('prestasi/files', 'public');
        }

        Prestasi::create($data);

        return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil dikirim dan menunggu verifikasi admin');
    }

    public function index()
    {
        $prestasi = Prestasi::approved()->latest()->paginate(12);
        return view('prestasi.index', compact('prestasi'));
    }
}