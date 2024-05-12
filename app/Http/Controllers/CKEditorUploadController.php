<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CKEditorUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan gambar ke storage/app/page_konten
        $path = $request->file('upload')->store('page_konten');

        return response()->json([
            'uploaded' => true,
            'url' => Storage::url($path), // Menghasilkan URL publik
        ]);
    }
}
