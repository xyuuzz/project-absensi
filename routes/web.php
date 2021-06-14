<?php

use Illuminate\Support\Facades\{Auth, Route};
use App\Http\Middleware\{Admin, ForTeacher, ForStudents};
use App\Http\Livewire\{KelolaSiswa, Home, Profile, Absensi, BuatAbsensi, KelolaGuru, ListAbsensi, ListKelas, StudentRegister, TeacherRegister, ListLinkRegister, MakeLinkRegister};

Route::get('/', function () {
    return redirect(route("login"));
});

Auth::routes();

Route::middleware("guest")->prefix("register")->group(function() {
    Route::get("siswa/{classes:class}/{register_student:slug}", StudentRegister::class)->name("register_student");
    Route::get("guru/{mapel}/{register_teacher:slug}", TeacherRegister::class)->name("register_teacher");
});

Route::middleware(['auth'])->group(function () {
    Route::get("home", Home::class)->name("home");

    Route::middleware(ForStudents::class)->group(function() {
        Route::get("profile/{user:name}", Profile::class)->name("profile");
        Route::get("absensi", Absensi::class)->name("absensi");
    });

    Route::middleware(ForTeacher::class)->group(function() {
        Route::get("buat/absensi", BuatAbsensi::class)->name("buat_absensi");
        Route::get("list/absensi", ListAbsensi::class)->name("list_absensi");
        Route::get("list/kelas/{user:name}/{classes:class}/{absent:id}", ListKelas::class)->name("list_kelas");
    });

    Route::middleware(Admin::class)->prefix("admin")->group(function() {
        Route::get("kelola/guru", KelolaGuru::class)->name("kelola_guru");
        Route::get("kelola/siswa", KelolaSiswa::class)->name("kelola_siswa");
        Route::get("make-link-register/{status}", MakeLinkRegister::class)->name("make_link_register");
        Route::get("list-link-register/{status}", ListLinkRegister::class)->name("list_link_register");
    });
});
