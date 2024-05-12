<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use App\Models\FlipbookSelesai;
use App\Models\Quest1;
use App\Models\Questselesai;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $daerahs = Daerah::all();
        $quest1s = Quest1::all();

        // Mendapatkan user yang sedang login
        $user = auth()->user();

        // Menghitung jumlah flipbook yang sudah diselesaikan
        // $flipbookCount = FlipbookSelesai::where('user_id', $user->id)->count();

        // Menghitung jumlah quest yang sudah diselesaikan
        // $questCount = Questselesai::where('user_id', $user->id)->count();
        // Mengambil data flipbook yang sudah diselesaikan oleh user

        // Mengambil data flipbook yang sudah diselesaikan oleh user
        $flipbooks = FlipbookSelesai::where('user_id', $user->id)->distinct()->get();

        // Mengambil data quest yang sudah diselesaikan oleh user
        $quests = Questselesai::where('user_id', $user->id)->distinct()->get();

        return view('user.index', compact(['daerahs', 'quest1s', 'flipbooks', 'quests']));
    }
}
