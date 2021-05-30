<?php

namespace App\Http\Livewire;

use App\Models\Teacher;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class EditGuru extends Component
{
    protected $listeners = [ "editTeacher" ];

    public $nama_guru, $email, $nign, $mapel, $password, $jenis_kelamin, $guru;

    public function render()
    {
        return view('livewire.edit-guru');
    }


    public function editTeacher(Teacher $guru)
    {
        $this->guru = $guru;
    }

    public function formEditGuru()
    {
        $this->validate([
            "nama_guru" => "required|string|min:5",
            "email" => "required|email|max:50",
            "mapel" => "required|string|max:30",
            "nign" => "required|max:11",
            "password" => "min:8"
        ]);

        $arr_user =
        [
            "name" => $this->nama_guru,
            "email" => $this->email,
            "jenis_kelamin" => $this->jenis_kelamin
        ];

        // field password tidak kosong, maka masukan ke dalam array $arr_user yang nantinya akan di masukan ke dalam database
        if($this->password !== "") {
            $arr_user["password"] = Hash::make($this->password);
        }

        // edit field user
        $this->e_guru->user->update($arr_user);
        // edit field teacher
        $this->e_guru->update([
            "nign" => $this->nign,
            "mapel" => $this->mapel
        ]);

        $this->emit("TeacherEdited");
    }
}
