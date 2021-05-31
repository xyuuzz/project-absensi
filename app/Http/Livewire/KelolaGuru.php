<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\{Teacher, User};
use Illuminate\Support\Facades\Hash;

class KelolaGuru extends Component
{
    use WithPagination;

    public $view = "index"; // default view adalah index
    public $name, $email, $nign, $mapel, $password, $s_based_on, $search, $edit_data;
    // $edit_data sebagai edit_guru, variabel untuk form edit guru
    // $s_based_on = cari berdasarkan ... pada guru
    public $jenis_kelamin = "Laki-Laki"; // default jenis kelamin adalah laki-laki

    protected $updatedQueryString = ["search"];

    protected $listeners = ["teacherCreated", "teacherEdited"];

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
        $status = "teacher";
        return view('livewire.kelola-guru', compact("kumpulan_data", "index", "status"));
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

    public function createView()
    {
        $this->name=""; $this->email=""; $this->nign=""; $this->mapel=""; $this->password="";
        if($this->view == "index") // jika view nya adalah index,
        {
            $this->view = "create"; // nanti jika di klik maka ubah ke view buat_guru
        } else { // lalu ketika ada di view buat_guru, maka jika nanti di klik akan ke view index
            $this->view = "index";
        }
    }

    public function editView($guru)
    {
        $this->emit("editTeacher", $guru);
        $this->view = "edit_guru";
        // $this->edit_data = $guru;
    }

    public function teacherCreated()
    {
        // reset view agar bisa kembali ke halaman list guru
        $this->view = "index";
        // kirim session/alert/pengumuman
        session()->flash("success", "Berhasil Mendaftarkan Guru!");
    }

    public function teacherEdited()
    {
        // reset view agar bisa kembali ke halaman list guru
        $this->view = "index";
        // kirim session/alert/pengumuman
        session()->flash("success", "Berhasil Mensunting Data Guru!");
    }
}
