<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfilSekolahController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\SiswaIbadahHarianController;
use App\Http\Controllers\SiswaTahfidzController;
use App\Http\Controllers\SiswaHadistController;
use App\Http\Controllers\SiswaDoaController;
use App\Http\Controllers\SiswaIlmanWaaRuuhanController;
use App\Http\Controllers\SiswaMapelController;
use App\Http\Controllers\RaporSiswaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/dataUser', [UserController::class, 'index']);
Route::get('/profilSekolah', [ProfilSekolahController::class, 'index']);
Route::get('/dataGuru', [GuruController::class, 'index']);
Route::get('/dataSiswa', [SiswaController::class, 'index']);
Route::get('/dataTahunPelajaran', [PeriodeController::class, 'index']);
Route::get('/pengumuman', [PengumumanController::class, 'index']);
Route::get('/ibadahHarian', [SiswaIbadahHarianController::class, 'index']);
Route::get('/tahfidz', [SiswaTahfidzController::class, 'index']);
Route::get('/hadist', [SiswaHadistController::class, 'index']);
Route::get('/doa', [SiswaDoaController::class, 'index']);
Route::get('/iwr', [SiswaIlmanWaaRuuhanController::class, 'index']);
Route::get('/bidangStudi', [SiswaMapelController::class, 'index']);
Route::get('/raporSiswa', [RaporSiswaController::class, 'index']);

Route::get('/tes', function () {
    return view('dashboard');
});
Route::get('/', function () {
    return view('dashboard');
});
Route::get('/register', function () {
    return view('register');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
