<?php

namespace App\Http\Livewire;

use App\Models\Teacher;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class EditGuru extends Component
{
    protected $listeners = [ "editTeacher" ];

    public $name, $email, $nign, $mapel, $password, $jenis_kelamin, $guru;

    public function render()
    {
        $status = "teacher";
        return view('partials.edit_template', compact("status"));
    }


    public function editTeacher(Teacher $guru)
    {
        $this->guru = $guru;
        $this->name=$guru->user->name;
        $this->email=$guru->user->email;
        $this->nign=$guru->nign;
        $this->mapel=$guru->mapel;
        $this->jenis_kelamin=$guru->user->jenis_kelamin;
        $this->password = '';
    }

    public function editForm()
    {
        $this->validate([
            "name" => "required|string|min:5",
            "email" => "required|email|max:50",
            "mapel" => "required|string|max:30",
            "nign" => "required|max:11",
            "password" => "min:8"
        ]);

        $arr_user =
        [
            "name" => $this->name,
            "email" => $this->email,
            "jenis_kelamin" => $this->jenis_kelamin
        ];

        // field password tidak kosong, maka masukan ke dalam array $arr_user yang nantinya akan di masukan ke dalam database
        if($this->password !== "") {
            $arr_user["password"] = Hash::make($this->password);
        }

        // edit field user
        $this->guru->user->update($arr_user);
        // edit field teacher
        $this->guru->update([
            "nign" => $this->nign,
            "mapel" => $this->mapel
        ]);

        $this->name=""; $this->email=""; $this->nign=""; $this->mapel=""; $this->password="";
        $this->emit("teacherEdited");
    }
}
