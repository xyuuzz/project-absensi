<?php

namespace App\Http\Livewire;

use App\Models\{User, Student};
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class StudentRegister extends Component
{
    public $name, $email, $password, $jenis_kelamin, $no_absen;

    public function render()
    {
        return view('livewire.student-register');
    }

    public function createForm()
    {

        if(Student::where("no_absen", $this->no_absen)) {
            session()->flash("failure_no_absen", "Absent Number Already Used");
            return redirect()->back();
        }
        Student::create([

        ]);

        return User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            "role" => "student",
            "jenis_kelamin" => $this->jenis_kelamin
        ]);
    }
}
