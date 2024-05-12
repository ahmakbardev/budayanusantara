<?php

namespace App\Http\Controllers;

use App\Models\Questselesai;
use Illuminate\Http\Request;

class QuestSelesaiController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_quest' => 'required',
            'nilai' => 'required|integer',
        ]);

        // Cari atau buat entri yang sesuai dengan kriteria
        $questSelesai = Questselesai::firstOrCreate(
            [
                'user_id' => $request->user_id,
                'nama_quest' => $request->nama_quest,
            ],
            ['nilai' => $request->nilai]
        );

        // Jika entri baru dibuat, kembalikan pesan bahwa data permainan yang selesai berhasil disimpan
        if ($questSelesai->wasRecentlyCreated) {
            return redirect('/')->with('success', 'Data permainan yang selesai berhasil disimpan.');
        }

        // Jika entri sudah ada sebelumnya, kembalikan pesan bahwa data permainan sudah selesai sebelumnya
        return redirect('/')->with('warning', 'Data permainan sudah selesai sebelumnya.');
    }
}
