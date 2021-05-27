<?php

use App\Http\Middleware\{ForTeacher, ForStudents};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\{Home, Profile, Absensi, BuatAbsensi, ListAbsensi, ListKelas};

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

Route::get('/', function () {
    return redirect(route("login"));
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // halaman profile
    Route::get("/profile/{user:name}", Profile::class)->name("profile");

    // halaman welcome
    Route::get("/home", Home::class)->name("home");

    // halaman absen untuk siswa
    Route::get("/absensi", Absensi::class)->middleware(ForStudents::class)->name("absensi");

    // halaman membuat absen untuk guru
    Route::get("/buat/absensi", BuatAbsensi::class)->middleware(ForTeacher::class)->name("buat_absensi");
    Route::get("list/absensi", ListAbsensi::class)->middleware(ForTeacher::class)->name("list_absensi");
    Route::get("list/kelas/{user:name}/{classes:class}/{absent:id}", ListKelas::class)->middleware(ForTeacher::class)->name("list_kelas");
});
