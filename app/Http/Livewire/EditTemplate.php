<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class EditTemplate extends Component
{
    protected $listeners = [
        "toEditView"
    ];

    public $nama_guru, $email, $nign, $mapel, $password, $status, $guru;
    public $jenis_kelamin = "Laki-Laki";

    public function render()
    {
        return view('livewire.edit-template');
    }

    public function toEditView($id, $status)
    {
        dd($status);
        $this->status = $status;
        if($status === "teacher")
        {
            $guru = Teacher::where("id", $id)->first();
            $this->guru = $guru;
            $this->nama_guru=$guru->user->name;
            $this->email=$guru->user->email;
            $this->nign=$guru->nign;
            $this->mapel=$guru->mapel;
        }
    }

    public function editForm()
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

        // reset field pada form
        $this->nama_guru=""; $this->email=""; $this->nign=""; $this->mapel=""; $this->password="";
        // reset view agar bisa kembali ke halaman list guru
        $this->view = "index";
        // kirim session/alert/pengumuman
        session()->flash("success", "Data Guru Berhasil Di Ubah");
    }
}
