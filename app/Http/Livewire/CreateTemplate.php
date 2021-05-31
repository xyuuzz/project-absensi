<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Classes;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class CreateTemplate extends Component
{
    public $name, $email, $nign, $mapel, $password, $status, $nis, $nisn, $class, $no_absen;
    public $jenis_kelamin = "Laki-Laki";

    protected $listeners = [
        "createStudent", "createTeacher"
    ];

    public function mount($status)
    {
        $this->status = $status;
    }
    public function render()
    {
        return view('livewire.create-template');
    }

    public function createTeacher()
    {
        $this->validate([
            "name" => "required|string|min:5",
            "email" => "required|email|max:50",
            "mapel" => "required|string|max:30",
            "nign" => "required|string|max:11",
            "password" => "required|string|min:8"
        ]);
        $user = User::create([
            "name" => $this->name,
            "email" => $this->email,
            "role" => "teacher",
            "password" => Hash::make($this->password),
            "jenis_kelamin" => $this->jenis_kelamin,
        ]);
        // create field teacher
        $user->teacher()->create([
            "nign" => $this->nign,
            "mapel" => $this->mapel
        ]);

        $this->name=""; $this->email=""; $this->nign=""; $this->mapel=""; $this->password="";
        $this->emit("teacherCreated");
    }

    public function createStudent()
    {
        dd("berhasil");
        if(!Classes::where("class", $this->class)->count()) {
            session()->flash("errorClass", "Penulisan Format Kelas Anda Salah");
            return redirect()->back();
        }
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
