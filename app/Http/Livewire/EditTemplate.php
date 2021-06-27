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

    public $name, $email, $nign, $mapel, $password, $status, $kelola_data, $nis, $nisn, $class, $no_absen, $jenis_kelamin;

    // method mount digunakan untuk menerima parameter/data
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
        if($this->status === "teacher")
        {
            $this->kelola_data = Teacher::firstWhere("id", $id);
            $this->nign=$this->kelola_data->nign;
            $this->mapel=$this->kelola_data->mapel;
        }
        else {
            $this->kelola_data = Student::firstWhere("id", $id);
            $this->nisn=$this->kelola_data->nisn;
            $this->nis=$this->kelola_data->nis;
            $this->no_absen=$this->kelola_data->no_absen;
            $this->class=$this->kelola_data->classes->class;
        }

        // field pada table user tidak akan terpengaruh
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
            $status = "teacher";
        } else {
            if($this->updateStudent() === "error") {
                return redirect()->back();
            }
            $status = "student";
        }

        // reset field pada form
        $this->name=""; $this->email=""; $this->nign=""; $this->mapel=""; $this->password=""; $this->nisn=""; $this->nis=""; $this->no_absen=""; $this->class="";
        $this->emit("succesUpdated", $status); # kirim emit
    }

    protected function updateUser()
    {
        $this->validate
        (
            [
            "name" => "required|string",
            "email" => "required|email",
            ],
            [
                "name.string" => "Input Nama Hanya Berupa Huruf",
            ]
        );

        if($this->email !== $this->kelola_data->user->email) {
            $this->validate(["email" => "unique:users"], ["email.unique" => "Email Yang Anda Inputkan Sudah Ada"]);
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
        // edit table user
        $this->kelola_data->user->update($arr_user);
    }

    protected function updateTeacher()
    {
        $this->validate([
            "mapel" => "required|string",
            "nign" => "required|numeric|unique:teachers",
        ], [
            "mapel.string" => "Input Mapel Berupa Huruf Numeric",
            "nign.numeric" => "NIGN Berupa Angka Bukun Huruf",
            "nign.unique" => "Nomor NIGN sudah ada"
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
            "nisn" => "required|numeric|unique:students",
            "no_absen" => "required|numeric|max:40"
        ], [ // validate
            "no_absen.max" => "Maximal Angka No Absen Adalah 40",
            "nis.numeric" => "NIS Hanya Berupa Huruf",
            "nisn.numeric" => "NISN Hanya Berupa Huruf",
            "nisn.unique" => "Nomor NISN sudah ada!"
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
