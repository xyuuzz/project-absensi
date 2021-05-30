<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class IndexTemplate extends Component
{
    use WithPagination;

    protected $listeners = [
        "teacherCreated"
    ];

    public $view = "index"; // default view adalah index
    public $nama_guru, $email, $nign, $mapel, $password, $s_based_on, $search, $e_guru;
    // $e_guru sebagai edit, variabel untuk form edit guru
    // $s_based_on = cari berdasarkan ... pada guru
    public $jenis_kelamin = "Laki-Laki"; // default jenis kelamin adalah laki-laki

    protected $updatedQueryString = ["search"];

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
        $kumpulan_data = explode("/", request()->url())[count(explode("/", request()->url()))-1] === "guru" ?
                            $this->search_teacher() : $this->search_students();
        $index = 1;
        return view('livewire.index-template', compact("kumpulan_data", "index"));
    }

    protected function search_teacher()
    {
        $kumpulan_data = Teacher::latest()->simplePaginate(10);
        // jika tidak ada field pada table guru
        if(!Teacher::count()) {
            session()->flash("danger", "Tidak Ada Guru Yang Terdaftar, Silahkan Buat Guru Dengan Mengisi Form Dibawah");
            $this->view = "create";
        }
        // jika user mencari guru/ ada huruf pada input search
        if(strlen($this->search)) {
            $kumpulan_data = $this->s_based_on == null || $this->s_based_on == "name" ?
                            array_map(function($user) {
                                return Teacher::where("user_id", $user["id"])->first();
                            }, User::where("role", "teacher")->where("name", "like", "%{$this->search}%")->get()->toArray())
                        : Teacher::where("mapel", "like", "%{$this->search}%")->get();
            // desk : jika $s_based_on adalah null atau name, maka cari guru berdasarkan name dengan query yang diinputkan admin, namun jika $s_based_on nya adalah mapel, maka cari guru berdasarkan mapel dengan query yang diinputkan admin
        }
        return $kumpulan_data;
    }

    protected function search_students()
    {
        $kumpulan_data = Student::latest()->simplePaginate(10);
        // jika tidak ada field pada table guru
        if(!Student::count()) {
            session()->flash("danger", "Tidak Ada Siswa Yang Terdaftar, Silahkan Buat Guru Dengan Mengisi Form Dibawah");
            $this->view = "create";
        }
        // jika user mencari guru/ ada huruf pada input search
        if(strlen($this->search)) {
            $kumpulan_data = $this->s_based_on == null || $this->s_based_on == "name" ?
                            array_map(function($user) {
                                return Student::where("user_id", $user["id"])->first();
                            }, User::where("role", "student")->where("name", "like", "%{$this->search}%")->get()->toArray())
                        : Teacher::where("nis", "like", "%{$this->search}%")->get();
            // desk : jika $s_based_on adalah null atau name, maka cari guru berdasarkan name dengan query yang diinputkan admin, namun jika $s_based_on nya adalah mapel, maka cari guru berdasarkan mapel dengan query yang diinputkan admin
        }
        return $kumpulan_data;
    }


    // listeners action method
    public function teacherCreated()
    {
        // reset view agar bisa kembali ke halaman list guru
        $this->view = "index";
        // kirim session/alert/pengumuman
        session()->flash("success", "Berhasil Mendaftarkan Guru!");
    }
    // end listeners action method


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

        if(Teacher::count() > 0)
        {
            session()->flash("success", "Berhasil Menghapus Data Guru");
        }
    }

    public function createView()
    {
        $this->nama_guru=""; $this->email=""; $this->nign=""; $this->mapel=""; $this->password="";
        if($this->view == "index") // jika view nya adalah index,
        {
            $this->view = "create"; // nanti jika di klik maka ubah ke view create
        } else { // lalu ketika ada di view create, maka jika nanti di klik akan ke view index
            $this->view = "index";
        }
    }

    public function editView(Teacher $guru)
    {
        $this->view = "edit";
        $this->e_guru = $guru;
        $this->nama_guru=$guru->user->name;
        $this->email=$guru->user->email;
        $this->nign=$guru->nign;
        $this->mapel=$guru->mapel;
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
        // reset view agar bisa kembali ke halaman list guru
        $this->view = "index";
        // kirim session/alert/pengumuman
        session()->flash("success", "Data Guru Berhasil Di Ubah");
    }
}
