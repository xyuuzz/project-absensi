<?php

namespace App\Http\Livewire;

use App\Models\Classes;
use App\Models\Student;
use App\Models\Teacher;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class EditTemplate extends Component
{
    protected $listeners = [
        "editData"
    ];

    public $name, $email, $nign, $mapel, $password, $status, $kelola_data, $nis, $nisn, $class, $no_absen;
    public $jenis_kelamin = "Laki-Laki";

    public function mount($status)
    {
        $this->status = $status;
    }

    public function render()
    {
        return view('livewire.edit-template');
    }

    public function editData($id)
    {
        $this->kelola_data = $this->status === "teacher" ? Teacher::firstWhere("id", $id) : Student::firstWhere("id", $id);
        if($this->status === "teacher")
        {
            $this->nign=$this->kelola_data->nign;
            $this->mapel=$this->kelola_data->mapel;
        } else {
            $this->nisn=$this->kelola_data->nisn;
            $this->nis=$this->kelola_data->nis;
            $this->no_absen=$this->kelola_data->no_absen;
            $this->class=$this->kelola_data->classes->class;
        }
        $this->name=$this->kelola_data->user->name;
        $this->email=$this->kelola_data->user->email;
        $this->password = '';
        $this->jenis_kelamin = $this->kelola_data->user->jenis_kelamin;
    }

    public function editForm()
    {
        $this->updateUser();
        if($this->status === "teacher") {
            $this->updateTeacher();
        } else {
            if($this->updateStudent() === "error") {
                return redirect()->back();
            }
        }

        // reset field pada form
        $this->name=""; $this->email=""; $this->nign=""; $this->mapel=""; $this->password=""; $this->nisn=""; $this->nis=""; $this->no_absen=""; $this->class="";
        $this->emit("succesUpdated");
    }

    protected function updateUser()
    {
        $this->validate([
            "name" => "required|string|min:5",
            "email" => "required|email|max:50",
        ]);
        if($this->email !== $this->kelola_data->user->email) {
            $this->validate(["email" => "unique:users"]);
        }

        $arr_user =
        [
            "name" => $this->name,
            "email" => $this->email,
            "jenis_kelamin" => $this->jenis_kelamin
        ];
        // field password tidak kosong, maka validate dan masukan ke dalam array $arr_user yang nantinya akan di masukan ke dalam database
        if($this->password !== "") // jika input pass diisi maka :
        {
            $this->validate( ["password" => "min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|"] );
            $arr_user["password"] = Hash::make($this->password);
        }
        // edit field user
        $this->kelola_data->user->update($arr_user);
    }

    protected function updateTeacher()
    {
        $this->validate([
            "mapel" => "required|string|max:30",
            "nign" => "required|max:20",
        ]);
        $this->kelola_data->update([
            "nign" => $this->nign,
            "mapel" => $this->mapel
        ]);
    }

    protected function updateStudent()
    {
        if(!Classes::where("class", $this->class)->count()) {
            $this->addError("class", "Penulisan Format Kelas Anda Salah");
            return "error";
        }

        $this->validate([
            "nis" => "required|numeric",
            "nisn" => "required|numeric",
            "no_absen" => "required|digits_between:1,40"
        ]);
        $this->kelola_data->update([
            "nis" => $this->nis,
            "nisn" => $this->nisn,
            "no_absen" => $this->no_absen,
            "classes_id" => Classes::where("class", $this->class)->first()->id
        ]);

        // mencari apakah ada no absen yang sama pada satu kelas yang sama
        if(Student::where("classes_id", Classes::firstWhere("class", $this->class)->id)->where("no_absen", $this->no_absen)->count() > 1)
        {
            $this->addError("no_absen", "No Absen Sudah Dipakai!");
            return "error";
        }
    }
}
