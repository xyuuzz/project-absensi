<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Student, Classes};

class StudentRegister extends Component
{
    public $name, $email, $password, $no_absen, $class;
    public $jenis_kelamin = "Laki-Laki";

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


        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            "role" => "student",
            "jenis_kelamin" => $this->jenis_kelamin
        ]);

        $user->student()->create([
            "no_absen" => $this->no_absen,
            "classes_id" => Classes::firstWhere("class", $this->class)->id,
            "photo_profile" => "foto-profil.png",
        ]);

        Auth::login($user);
        return redirect(route("home"));
    }
}
