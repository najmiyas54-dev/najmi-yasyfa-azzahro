<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasi = Prestasi::with('user')->latest()->paginate(10);
        return view('admin.prestasi.index', compact('prestasi'));
    }

    public function show(Prestasi $prestasi)
    {
        return view('admin.prestasi.show', compact('prestasi'));
    }

    public function approve(Prestasi $prestasi)
    {
        $prestasi->update([
            'status' => 'approved',
            'is_active' => true,
            'published_at' => now()
        ]);

        return redirect()->back()->with('success', 'Prestasi berhasil disetujui');
    }

    public function reject(Request $request, Prestasi $prestasi)
    {
        $prestasi->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'is_active' => false
        ]);

        return redirect()->back()->with('success', 'Prestasi ditolak');
    }

    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->image_path) {
            Storage::delete('public/' . $prestasi->image_path);
        }
        if ($prestasi->file_path) {
            Storage::delete('public/' . $prestasi->file_path);
        }
        
        $prestasi->delete();
        return redirect()->back()->with('success', 'Prestasi berhasil dihapus');
    }
}