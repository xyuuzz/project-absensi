<?php

namespace App\Http\Livewire;

use App\Models\Classes;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\{Student, User};

class KelolaSiswa extends Component
{
    use WithPagination;

    public $view = "index";
    public $name, $email, $nis, $nisn, $password, $s_based_on, $search, $class, $edit_data, $jenis_kelamin, $no_absen;

    public $listeners = ["successCreated", "succesUpdated", "linkCreated"];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected function paginationView()
    {
        return "partials.custom_pagination";
    }

    public function cari_berdasarkan($apa) // jika tombol cari berdasarkan di klik,
    {
        $this->updatingSearch();
        return $this->s_based_on = $apa; // maka masukan nilai yang di kirim ke $s_based_on untuk diproses nanti
    }

    public function render()
    {
        $kumpulan_data = Student::latest()->Paginate(10);

        // jika user mencari guru/ ada huruf pada input search
        if(strlen($this->search))
        {
            // reset page
            $this->updatingSearch();
            // jika admin mencari siswa berdasarkan nama :
            if($this->s_based_on == null || $this->s_based_on == "name")
            {
                // cari user yang role nya student, lalu cari nama yang similar dengan input admin, dapatkan semua dan ubah hasilnya menjadi array
                // masukan hasilnya satu persatu ke dalam parameter $user pada arrow func,
                // lalu cari student yang user_id nya sama dengan $user["id"] yang dikirimkan, pilih pertama
                $kumpulan_data = array_map
                            (
                                fn($user) => Student::where("user_id", $user["id"])->first(),
                                User::where("role", "student")
                                        ->where("name", "like", "%{$this->search}%")
                                        ->get()
                                        ->toArray()
                            );
            }
            else
            {
                // buat var kumpulan data yang berisi array kosong
                $kumpulan_data = [];
                // cari classes yang field class nya similar dengan input admin dan dapatkan semua
                $classes = Classes::where("class", "like", "%{$this->search}%")
                        ->get();
                // foreach class yang sudah didapatkan
                foreach($classes as $class)
                {
                    // pilih student yang memiliki class yang di looping
                    // karena bentuk nya array/banyak element, maka pecah dengan spread operator
                    // lalu push/masukan ke dalam var kumpulan data
                    array_push($kumpulan_data, ...$class->student);
                }
            }
        }

        $status = "student";
        return view('livewire.kelola-siswa', compact("status", "kumpulan_data"));
    }

    public function editView($siswa)
    {
        if($this->view !== "edit") {
            $this->view = "edit";
            $this->emit("editData", $siswa);
        } else {
            $this->view = "index";
        }
    }

    public function indexView()
    {
        $this->view = "index";
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

    public function successCreated($status)
    {
        $this->view = "index";
        $kata = $status === "teacher" ? "Guru" : "Siswa";
        if($status === "link") {
            $kata = "Link Register Siswa";
        }
        session()->flash("success", "Berhasil Menambahkan Data $kata");
    }

    public function succesUpdated($status)
    {
        // reset view agar bisa kembali ke halaman list guru
        $this->view = "index";
        // kirim session/alert/pengumuman
        $kata = $status === "teacher" ? "Guru" : "Siswa";
        session()->flash("success", "Berhasil Mensunting Data $kata");
    }
}
