<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\{Teacher, User};
use Illuminate\Support\Facades\Hash;

class KelolaGuru extends Component
{
    use WithPagination;

    public $view = "list_guru"; // default view adalah list_guru
    public $name, $email, $nign, $mapel, $password, $s_based_on, $search, $e_guru;
    // $e_guru sebagai edit_guru, variabel untuk form edit guru
    // $s_based_on = cari berdasarkan ... pada guru
    public $jenis_kelamin = "Laki-Laki"; // default jenis kelamin adalah laki-laki

    protected $updatedQueryString = ["search"];

    protected $listeners = ["TeacherCreated"];

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
        $kumpulan_data = Teacher::latest()->simplePaginate(10);
        // jika tidak ada field pada table guru
        if(!Teacher::count()) {
            session()->flash("danger", "Tidak Ada Guru Yang Terdaftar, Silahkan Buat Guru Dengan Mengisi Form Dibawah");
            $this->view = "buat_guru";
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

        $index = 1;
        return view('livewire.kelola-guru', compact("kumpulan_data", "index"));
    }

    public function deleteData($user_id)
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

        return redirect(route("kelola_guru"));
    }

    public function viewBuatGuru()
    {
        $this->name=""; $this->email=""; $this->nign=""; $this->mapel=""; $this->password="";
        if($this->view == "list_guru") // jika view nya adalah list_guru,
        {
            $this->view = "buat_guru"; // nanti jika di klik maka ubah ke view buat_guru
        } else { // lalu ketika ada di view buat_guru, maka jika nanti di klik akan ke view list_guru
            $this->view = "list_guru";
        }
    }

    public function editView(Teacher $guru)
    {
        $this->emit("editTeacher");
        $this->view = "edit_guru";
        $this->e_guru = $guru;
        $this->name=$guru->user->name;
        $this->email=$guru->user->email;
        $this->nign=$guru->nign;
        $this->mapel=$guru->mapel;
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
        $this->e_guru->user->update($arr_user);
        // edit field teacher
        $this->e_guru->update([
            "nign" => $this->nign,
            "mapel" => $this->mapel
        ]);

        // reset field pada form
        $this->name=""; $this->email=""; $this->nign=""; $this->mapel=""; $this->password="";
        // reset view agar bisa kembali ke halaman list guru
        $this->view = "list_guru";
        // kirim session/alert/pengumuman
        session()->flash("success", "Data Guru Berhasil Di Ubah");
    }

    public function TeacherCreated()
    {
        // reset view agar bisa kembali ke halaman list guru
        $this->view = "list_guru";
        // kirim session/alert/pengumuman
        session()->flash("success", "Berhasil Mendaftarkan Guru!");
    }
}
