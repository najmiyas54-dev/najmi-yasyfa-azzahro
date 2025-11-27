<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LimitFileSize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if request has files
        if ($request->hasFile('image') || $request->hasFile('file')) {
            
            // Check image file size (max 2MB)
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                if ($image->getSize() > 2048 * 1024) { // 2MB in bytes
                    return back()->withErrors(['image' => 'Ukuran gambar tidak boleh lebih dari 2MB'])->withInput();
                }
            }
            
            // Check document file size (max 5MB)
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                if ($file->getSize() > 5120 * 1024) { // 5MB in bytes
                    return back()->withErrors(['file' => 'Ukuran file tidak boleh lebih dari 5MB'])->withInput();
                }
                
                // Check allowed file types
                $allowedExtensions = ['pdf', 'doc', 'docx', 'ppt', 'pptx'];
                $extension = strtolower($file->getClientOriginalExtension());
                
                if (!in_array($extension, $allowedExtensions)) {
                    return back()->withErrors(['file' => 'Format file tidak didukung. Hanya PDF, DOC, DOCX, PPT, PPTX yang diizinkan'])->withInput();
                }
            }
        }
        
        return $next($request);
    }
}