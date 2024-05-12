<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FlipbookSelesaiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuestSelesaiController;
use App\Http\Controllers\UserController;
use App\Livewire\DaerahManagement;
use App\Models\Daerah;
use App\Models\Quest1;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route yang hanya bisa diakses oleh pengguna yang belum login (guest)
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        $daerahs = Daerah::all();
        $quest1s = Quest1::all();
        return view('index', compact(['daerahs', 'quest1s']));
    });

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('/register', [LoginController::class, 'register'])->name('register');
});


Route::middleware(['auth', 'SudahLogin'])->group(function () {
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.index');
        // Rute-rute admin di sini
        Route::prefix('daerah')->group(function () {
            Route::get('/', function () {
                return view('admin.daerah.tambah');
            })->name('tambah.daerah');
        });
        Route::prefix('quest1')->group(function () {
            Route::get('/', function () {
                return view('admin.quest.quest1.tambah');
            })->name('quest.tambah');
        });
        Route::post('/ckeditor/upload', [App\Http\Controllers\CKEditorUploadController::class, 'upload']);
    });

    // Prefix 'user' untuk rute yang memerlukan role_id 'user'
    Route::middleware('role:user')->prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        // Rute-rute user di sini
        // Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });

    Route::get('/quest1/{id}', function ($id) {
        $quest = Quest1::findOrFail($id); // Mengambil quest berdasarkan ID
        return view('quest1', compact('quest'));
    })->name('quest_detail');
    Route::post('/questselesai', [QuestSelesaiController::class, 'store'])->name('questselesai.store');

    Route::get('/flipbook/{id}', function ($id) {
        $daerah = App\Models\Daerah::findOrFail($id);
        $konten = json_decode($daerah->konten, true);

        // Simpan data ke dalam sesi
        session(['nama_flipbook' => $daerah->nama_daerah]);
        session(['user_id' => auth()->user()->id]);

        return view('flipbook', compact('daerah', 'konten'));
    })->name('flipbook');
    Route::post('/flipbookselesai', [FlipbookSelesaiController::class, 'store'])->name('flipbookselesai.store');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
// Prefix 'admin' untuk rute yang memerlukan role_id 'admin'
