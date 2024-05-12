<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use App\Models\Quest1;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Fungsi untuk mengembalikan entitas HTML ke karakter asli
    private function decodeHtmlEntities($string)
    {
        return html_entity_decode($string, ENT_QUOTES, 'UTF-8'); // Mengembalikan entitas HTML ke karakter asli
    }
    public function index()
    {
        $daerahs = Daerah::all(); // Mendapatkan semua data daerah
        $quest1s = Quest1::all(); // Mendapatkan semua data daerah

        return view('admin.index', compact(['daerahs', 'quest1s'])); // Mengirim data ke view
    }

}
