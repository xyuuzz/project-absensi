<?php

namespace App\Http\Livewire;

use App\Models\{User, Student, Classes};
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
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

    public function createForm()
    {
        $user = $this->createUser($this->status); // panggil method untuk membuat field user
        if($this->status === "teacher")  // jika status nya adalah teacher,
        {
            $this->createTeacher($user); // panggil method untuk membuat field user
            $status = "teacher";
        } else { // jika tidak
            $this->createStudent($user); // panggil method untuk membuat field student
            $status = "student";
        }

        $this->resetInput();
        $this->emit("successCreated", $status);
    }

    protected function createUser($status)
    {
        $this->validate([
            "name" => "required|string|min:5|max:40",
            "email" => "required|email|max:50|unique:users",
            "password" => "min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|",
        ], [
            "name.min" => "Minimal 5 Huruf",
            "email.max" => "Maximal 50 Huruf",
            "email.unique" => "Email Sudah Dipakai",
            "password.min" => "Minimal 6 Huruf",
            "password.regex" => "Gunakan Password Yang Kuat!! Contoh : MaulanaYusuf12_$$"
        ]);

        return $user = User::create([
            "name" => $this->name,
            "email" => $this->email,
            "role" => $status,
            "password" => Hash::make($this->password),
            "jenis_kelamin" => $this->jenis_kelamin,
        ]);
    }

    protected function createTeacher($user)
    {
        $this->validate([
            "mapel" => "required|string|max:30",
            "nign" => "required|numeric|unique:teachers|max:99999999999",
        ]);
        // create field teacher
        $user->teacher()->create([
            "nign" => $this->nign,
            "mapel" => $this->mapel
        ]);
    }

    protected function createStudent($user)
    {
        if(!Classes::where("class", $this->class)->count()) {
            session()->flash("errorClass", "Penulisan Format Kelas Anda Salah");
            return redirect()->back();
        }

        $user->student()->create([
            "no_absen" => $this->no_absen,
            "classes_id" => Classes::firstWhere("class", $this->class)->id,
            "photo_profile" => "foto-profil.jpeg",
            "nis" => $this->nis,
            "nisn" => $this->nisn
        ]);

        if(Student::where("classes_id", Classes::firstWhere("class", $this->class)->id)->where("no_absen", $this->no_absen)->count() > 1)
        {
            session()->flash("errorNoAbsen", "No Absen Sudah Dipakai!");
            return redirect()->back();
        }
    }

    protected function resetInput() {
        $this->name=""; $this->email=""; $this->nign=""; $this->mapel=""; $this->password="";
    }
}
