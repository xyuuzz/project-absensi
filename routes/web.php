<?php

use App\Http\Livewire\KelolaSiswa;
use App\Http\Livewire\IndexTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\{Admin, ForTeacher, ForStudents};
use App\Http\Livewire\{Home, Profile, Absensi, BuatAbsensi, KelolaGuru, ListAbsensi, ListKelas};

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
    Route::middleware(ForTeacher::class)->group(function() {
        Route::get("/buat/absensi", BuatAbsensi::class)->name("buat_absensi");
        Route::get("list/absensi", ListAbsensi::class)->name("list_absensi");
        Route::get("list/kelas/{user:name}/{classes:class}/{absent:id}", ListKelas::class)->name("list_kelas");
    });

    Route::middleware(Admin::class)->group(function() {
        Route::get("/admin/kelola/guru", KelolaGuru::class)->name("kelola_guru");
        Route::get("/admin/kelola/siswa", KelolaSiswa::class)->name("kelola_siswa");
    });

});
