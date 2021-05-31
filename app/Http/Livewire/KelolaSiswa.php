<?php

namespace App\Http\Livewire;

use App\Models\Classes;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\{Student, User};
use Illuminate\Support\Facades\Hash;

class KelolaSiswa extends Component
{
    use WithPagination;

    public $view = "index";
    public $name, $email, $nis, $nisn, $password, $s_based_on, $search, $class, $edit_data, $jenis_kelamin, $no_absen;

    public $listeners = ["studentCreated"];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function cari_berdasarkan($apa) // jika tombol cari berdasarkan di klik,
    {
        return $this->s_based_on = $apa; // maka masukan nilai yang di kirim ke $s_based_on untuk diproses nanti
    }

    public function render()
    {
        $kumpulan_data = Student::latest()->simplePaginate(10);
        // jika tidak ada field pada table siswa
        if(!Student::count()) {
            session()->flash("danger", "Tidak Ada Siswa Yang Terdaftar, Silahkan Tambahkan Siswa Dengan Mengisi Form Dibawah");
            $this->view = "create";
        }
        // jika user mencari guru/ ada huruf pada input search
        if(strlen($this->search)) {
            $kumpulan_data = $this->s_based_on == null || $this->s_based_on == "name" ?
                            array_map(function($user) {
                                    return Student::where("user_id", $user["id"])->first();
                                }, User::where("role", "student")->where("name", "like", "%{$this->search}%")->get()->toArray())
                            : array_map(function($class) {
                                    return Student::where("classes_id", $class["id"])->first();
                                }, Classes::where("class", "like", "%{$this->search}%")->get()->toArray());
        }

        $status = "student";
        return view('livewire.kelola-siswa', compact("status", "kumpulan_data"));
    }

    public function createView()
    {
        $this->name=""; $this->email=""; $this->nis=""; $this->nisn=""; $this->password=""; $this->class=""; $this->no_absen=""; $this->jenis_kelamin="";
        if($this->view == "index")
        {
            $this->view = "create";
        } else {
            $this->view = "index";
        }
    }

    public function deleteData($user_id)
    {
        $siswa = Student::firstWhere("user_id", $user_id);
        if($siswa->absents()->count())
        {
            $siswa->absents()->detach();
        }
        $siswa->delete();
        User::where("id", $user_id)->delete();

        if(Student::count() > 0)
        {
            session()->flash("success", "Data Siswa Berhasil Dihapus");
        }

        return redirect(route("kelola_siswa"));
    }

    public function editView(Student $siswa)
    {
        $this->view = "edit";
        $this->edit_data = $siswa;
        $this->name=$siswa->user->name;
        $this->email=$siswa->user->email;
        $this->nisn=$siswa->nisn;
        $this->nis=$siswa->nis;
        $this->no_absen=$siswa->no_absen;
        $this->class=$siswa->classes->class;
        $this->password = '';
        $this->jenis_kelamin = $siswa->user->jenis_kelamin;
    }

    public function studentCreated()
    {
        $this->view = "index";
        session()->flash("success", "Berhasil Menambahkan Data Siswa");
    }

    public function editForm()
    {
        if(!Classes::where("class", $this->class)->count()) {
            session()->flash("errorClass", "Penulisan Format Kelas Anda Salah");
            return redirect()->back();
        }

        if(Student::where("classes_id", Classes::firstWhere("class", $this->class)->id)->where("no_absen", $this->no_absen)->count() > 1)
        {
            session()->flash("errorNoAbsen", "No Absen Sudah Dipakai!");
            return redirect()->back();
        }

        $this->validate([
            "name" => "required|string|min:5",
            "email" => "required|email|max:50",
            "nis" => "required|numeric",
            "nisn" => "required|numeric",
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

        $this->edit_data->user->update($arr_user);
        $this->edit_data->update([
            "nis" => $this->nis,
            "nisn" => $this->nisn,
            "no_absen" => $this->no_absen,
            "classes_id" => Classes::where("class", $this->class)->first()->id
        ]);

        $this->name=""; $this->email=""; $this->nis=""; $this->nisn=""; $this->password=""; $this->class=""; $this->no_absen=""; $this->jenis_kelamin="";
        // reset view agar bisa kembali ke halaman list guru
        $this->view = "index";
        // kirim session/alert/pengumuman
        session()->flash("success", "Data Siswa Berhasil Di Ubah");
    }

    public function createForm()
    {
        if(!Classes::where("class", $this->class)->count()) {
            session()->flash("errorClass", "Penulisan Format Kelas Anda Salah");
            return redirect()->back();
        }

        $this->validate([
            "name" => "required|string|min:5",
            "email" => "required|email|max:50",
            "nis" => "required|numeric|max:30",
            "nisn" => "required|numeric|max:11",
            "no_absen" => "required|numeric|max:40",
            "password" => "required|string|min:8"
        ]);

        $user = User::create([
            "name" => $this->name,
            "email" => $this->email,
            "role" => "student",
            "password" => Hash::make($this->password),
            "jenis_kelamin" => $this->jenis_kelamin,
        ]);
        dd("berhasil");
        // create field teacher
        $user->student()->create([
            "nis" => $this->nis,
            "nisn" => $this->nisn,
            "no_absen" => $this->no_absen,
            "classes_id" => Classes::firstWhere("name", $this->class)->id
        ]);

        $this->name=""; $this->email=""; $this->nign=""; $this->mapel=""; $this->password="";
        $this->view = "index";
        session()->flash("success", "Berhasil Menambahkan Data Siswa");
    }
}
