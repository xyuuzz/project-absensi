<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\{Hash, Auth};
use App\Models\{User, Student, Classes, RegisterStudent};

class StudentRegisterPage extends Component
{
    public $name, $email, $password, $no_absen, $class, $jenis_kelamin, $nisn, $password_confirmation;

    public function mount(RegisterStudent $register_student)
    {
        $this->class = $register_student->classes->class;

        if(date("Y-m-d H:i:s") < $register_student->dimulai) // jika waktu sekarang kurang dari dimulai
        {
            session()->flash("danger", "Link Absensi Belum Dibuka!");
            return redirect(route("login"));
        }
        elseif
            (date("Y-m-d H:i:s") > $register_student->dimulai && date("Y-m-d H:i:s") < $register_student->berakhir)
        {
            // jika waktu sekarang diantara dimulai dan berakhir
            $this->status = "Sedang Berlangsung";
        } else { // jika waktu sekarang lebih dari berakhir
            session()->flash("danger", "Link Absensi Sudah Ditutup!");
            return redirect(route("login"));
        }

    }

    public function render()
    {
        return view('livewire.student-register-page');
    }

    public function createForm()
    {
        if(Student::where("no_absen", $this->no_absen)->count()) {
            $this->addError("no_absen", "Absent Number Already Used");
            return redirect()->back();
        }

        $user = $this->createUser();
        $student = $this->createStudent($user);

        Auth::login($user);
        return redirect(route("home"));
    }

    protected function createUser()
    {
        $this->validate([
            "name" => "required|string|min:3",
            "email" => "required|string|unique:users|min:5",
            "password" => "required|string|min:4|confirmed",
            "password_confirmation" => "required_with:password|same:password|min:4"
        ]);

        return $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            "role" => "student",
            "jenis_kelamin" => $this->jenis_kelamin
        ]);
    }

    protected function createStudent($user)
    {
        $this->validate([
            "nisn" => "required|numeric|unique:students"
        ]);

        return $user->student()->create([
            "nisn" => $this->nisn,
            "no_absen" => $this->no_absen,
            "classes_id" => Classes::firstWhere("class", $this->class)->id,
            "photo_profile" => "foto-profil.png",
        ]);
    }
}
