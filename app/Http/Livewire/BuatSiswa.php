<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Classes;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class BuatSiswa extends Component
{
    public $name, $email, $nis, $nisn, $password, $s_based_on, $search, $class, $edit_data, $no_absen;
    public $jenis_kelamin = "Laki-Laki";

    public function render()
    {
        $status = "student";
        return view('livewire.create-template', compact("status"));
    }

    public function createForm()
    {
        if(!Classes::where("class", $this->class)->count()) {
            session()->flash("errorClass", "Penulisan Format Kelas Anda Salah");
            return redirect()->back();
        }
        if(Student::where("classes_id", Classes::firstWhere("class", $this->class)->id)->where("no_absen", $this->no_absen)->count() > 1)
        {
            session()->flash("errorNoAbsen", "No Absen Sudah Dipakai!");
            return redirect()->back();
        }
        dd("berhasil");
        $this->validate([
            "name" => "required|string|min:5",
            "email" => "required|email|max:50",
            "nis" => "required|numeric|max:30",
            "nisn" => "required|numeric|max:11",
            "no_absen" => "required|numeric|max:40",
            "password" => "required|string|min:8"
        ]);

        $user = User::create([
            "name" => $this->name,
            "email" => $this->email,
            "role" => "student",
            "password" => Hash::make($this->password),
            "jenis_kelamin" => $this->jenis_kelamin,
        ]);
        dd("berhasil");
        // create field teacher
        $user->student()->create([
            "nis" => $this->nis,
            "nisn" => $this->nisn,
            "no_absen" => $this->no_absen,
            "classes_id" => Classes::firstWhere("name", $this->class)->id
        ]);

        $this->name=""; $this->email=""; $this->nign=""; $this->mapel=""; $this->password="";
        $this->emit("studentCreated");
    }
}
