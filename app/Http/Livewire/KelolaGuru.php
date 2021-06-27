<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\{Teacher, User};
use Illuminate\Support\Facades\Hash;

class KelolaGuru extends Component
{
    use WithPagination;

    public $s_based_on, $search, $view = "index";
    // $s_based_on = query untuk mencari guru, berdasarkan mapel atau nama

    protected $updatedQueryString = ["search"];

    // prop listeners digunakan untuk menangkap emit yang dikirmkan/dibuat
    protected $listeners = ["successCreated", "succesUpdated"];

    // method untuk reset page pagination livewire
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // method view pagination
    protected function paginationView()
    {
        return "partials.custom_pagination";
    }

    // method search engine based on..
    public function cari_berdasarkan($apa, $page) // jika tombol cari berdasarkan di klik,
    {
        $_GET["page"] = $page;
        $this->s_based_on = $apa; // maka masukan nilai yang di kirim ke $s_based_on untuk diproses nanti
    }

    public function render()
    {
        $kumpulan_data = Teacher::latest()->Paginate(10);
        // jika tidak ada field pada table guru
        if(!Teacher::count()) {
            session()->flash("danger", "Tidak Ada Guru Yang Terdaftar, Silahkan Buat Guru Dengan Mengisi Form Dibawah");
            $this->view = "create";
        }

        // jika user mencari guru/ ada huruf pada input search
        if(strlen($this->search))
        {
            $this->updatingSearch();
            $kumpulan_data = $this->s_based_on == null || $this->s_based_on == "name" ?
                // ketika mencari berdasarkan nama maka :
                // cari user yang mempunyai role teacher, lalu cari yang nama user yang similar dengan keyword, dapatkan semua, dan ubah menjadi array, dan passing/kirimkan value nya satu per satu ke callback yang ada di parameter pertama fungsi array_map
                array_map
                (
                    function($user)
                    {
                        // kembalikan teacher sesuai user_id yang diterima dari parameter
                        return Teacher::where("user_id", $user["id"])
                                        ->first();
                    },
                    User::where("role", "teacher")
                    ->where("name", "like", "%{$this->search}%")
                    ->get()
                    ->toArray()
                )
            // ketika mencari berdasarkan mapel.
            // cari teacher yang mapel nya similar dengan yang dicari oleh admin
            : Teacher::where("mapel", "like", "%{$this->search}%")->get();
        }
        // desk : jika $s_based_on adalah null atau name, maka cari guru berdasarkan name dengan query yang diinputkan admin, namun jika $s_based_on nya adalah mapel, maka cari guru berdasarkan mapel dengan query yang diinputkan admin

        // jika ada var global yang bernama page get pada url, maka ambil, jika tidak berikan nilai default 1
        $index = count($_GET) ? ($_GET['page'] * 10) - 9 : 1;
        $status = "teacher";

        return view('livewire.kelola-guru', compact("kumpulan_data", "index", "status"));
    }

    public function deleteData($user_id, $page_user)
    {
        $user = User::find($user_id);
        $guru = $user->teacher;
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
        $user->delete();

        if(Teacher::count() > 0)
        {
            session()->flash("success", "Berhasil Menghapus Data Guru");
        }

        // redirect ke route kelola_guru dengan mengirimkan data ke url berupa page
        return redirect()->to(route("kelola_guru", ["page" => $page_user]));
    }

    public function createView()
    {
        // reset page
        $this->updatingSearch();

        if($this->view == "index") // jika view nya adalah index,
        {
            $this->view = "create"; // nanti jika di klik maka ubah ke view buat_guru
        } else { // lalu ketika ada di view buat_guru, maka jika nanti di klik akan ke view index
            $this->view = "index";
        }
    }

    public function editView($guru)
    {
        // reset page
        $this->updatingSearch();
        // emit untuk mengirimkan data guru yang sudah diterima
        $this->emit("editData", $guru);
        // ganti view menjadi edit guru
        $this->view = "edit_guru";
    }

    public function successCreated()
    {
        // reset view agar bisa kembali ke halaman list guru
        $this->view = "index";
        // kirim session/alert/pengumuman
        session()->flash("success", "Berhasil Mendaftarkan Guru!");
    }

    public function succesUpdated()
    {
        // reset view agar bisa kembali ke halaman list guru
        $this->view = "index";
        // kirim session/alert/pengumuman
        session()->flash("success", "Berhasil Mensunting Data Guru!");
    }
}
