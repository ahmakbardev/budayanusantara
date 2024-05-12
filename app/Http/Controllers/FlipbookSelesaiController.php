<?php

namespace App\Http\Controllers;

use App\Models\FlipbookSelesai;
use Illuminate\Http\Request;

class FlipbookSelesaiController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_flipbook' => 'required',
        ]);

        // Cari atau buat entri yang sesuai dengan kriteria
        $flipbookSelesai = FlipbookSelesai::firstOrCreate(
            [
                'user_id' => $request->user_id,
                'nama_flipbook' => $request->nama_flipbook,
            ],
            ['status' => true]
        );

        // Jika entri baru dibuat, kembalikan pesan bahwa flipbook selesai berhasil disimpan
        if ($flipbookSelesai->wasRecentlyCreated) {
            return response()->json(['message' => 'Flipbook selesai berhasil disimpan.']);
        }

        // Jika entri sudah ada sebelumnya, kembalikan pesan bahwa flipbook sudah selesai sebelumnya
        return response()->json(['message' => 'Flipbook sudah selesai sebelumnya.']);
    }
}
