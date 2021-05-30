<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class BuatGuru extends Component
{
    public $nama_guru, $email, $nign, $mapel, $password;
    public $jenis_kelamin = "Laki-Laki";


    public function render()
    {
        return view('livewire.buat-guru');
    }

    public function formBuatGuru()
    {
        // validate data yang masuk
        $this->validate([
            "nama_guru" => "required|string|min:5",
            "email" => "required|email|max:50",
            "mapel" => "required|string|max:30",
            "nign" => "required|string|max:11",
            "password" => "required|string|min:8"
        ]);
        // create field user
        $user = User::create([
            "name" => $this->nama_guru,
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

        $this->emit("TeacherCreated");
    }
}
