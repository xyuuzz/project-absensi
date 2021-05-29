<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\{Teacher, User};
use Illuminate\Support\Facades\Hash;

class KelolaGuru extends Component
{
    public $view = "list_guru";
    public $nama_guru, $email, $nign, $mapel, $password, $e_guru; // $e_guru sebagai edit_guru, variabel untuk form edit guru
    public $jenis_kelamin = "Laki-Laki";

    use WithPagination;

    public function render()
    {
        $list_guru = Teacher::latest()->simplePaginate(10);
        if(!Teacher::count()) {
            session()->flash("danger", "Tidak Ada Guru Yang Terdaftar, Silahkan Buat Guru Dengan Mengisi Form Dibawah");
            $this->view = "buat_guru";
        }
        return view('livewire.kelola-guru', compact("list_guru"));
    }

    public function hapusGuru($user_id)
    {
        $guru = Teacher::where("user_id", $user_id)->first();
        if($guru->absent->count() > 0)
        {
            foreach($guru->absent as $absent)
            {
                if($absent->classes->count() > 0) {
                    $absent->classes()->detach();
                }
                if($absent->students->count() > 0) {
                    $absent->students()->detach();
                }
                $absent->delete();
            }
        }
        $guru->delete();
        User::where("id", $user_id)->delete();

        session()->flash("success", "Berhasil Menghapus Data Guru");
    }

    public function viewBuatGuru()
    {
        $this->nama_guru=""; $this->email=""; $this->nign=""; $this->mapel=""; $this->password="";
        if($this->view == "list_guru") // jika view nya adalah list_guru,
        {
            $this->view = "buat_guru"; // nanti jika di klik maka ubah ke view buat_guru
        } else { // lalu ketika ada di view buat_guru, maka jika nanti di klik akan ke view list_guru
            $this->view = "list_guru";
        }
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

        // reset field pada form
        $this->nama_guru=""; $this->email=""; $this->nign=""; $this->mapel=""; $this->password="";
        // reset view agar bisa kembali ke halaman list guru
        $this->view = "list_guru";
        // kirim session/alert/pengumuman
        session()->flash("success", "Berhasil Mendaftarkan Guru!");
    }

    public function viewEditGuru(Teacher $guru)
    {
        $this->view = "edit_guru";
        $this->e_guru = $guru;
        $this->nama_guru=$guru->user->name;
        $this->email=$guru->user->email;
        $this->nign=$guru->nign;
        $this->mapel=$guru->mapel;
    }

    public function formEditGuru()
    {
        $this->validate([
            "nama_guru" => "required|string|min:5",
            "email" => "required|email|max:50",
            "mapel" => "required|string|max:30",
            "nign" => "required|max:11",
            "password" => "string|min:8"
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
        $this->view = "list_guru";
        // kirim session/alert/pengumuman
        session()->flash("success", "Data Guru Berhasil Di Ubah");
    }
}
