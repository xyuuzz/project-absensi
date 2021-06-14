<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\{User, Student, Classes};
use Illuminate\Support\Facades\Hash;

class StudentRegister extends Component
{
    public $name, $email, $password, $jenis_kelamin, $no_absen, $class;

    public function mount(Classes $classes)
    {
        $this->class = $classes->class;
    }

    public function render()
    {
        return view('livewire.student-register');
    }

    public function createForm()
    {
        if(Student::where("no_absen", $this->no_absen)->count()) {
            $this->addError("no_absen", "Absent Number Already Used");
            // session()->flash("failure_no_absen", "Absent Number Already Used");
            return redirect()->back();
        }

        Student::create([
            "no_absen" => $this->no_absen,
            "classes_id" => $this->class->id,
            "photo_profile" => "foto-profil.jpeg",
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
