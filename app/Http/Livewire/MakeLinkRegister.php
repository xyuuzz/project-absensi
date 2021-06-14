<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\{Classes};

class MakeLinkRegister extends Component
{
    public $class, $dimulai, $berakhir, $mapel, $status;
    public $nama_link = '';

    public function mount($status) {
        $this->status = $status;
    }

    public function render()
    {
        return view('livewire.make-link-register');
    }

    public function createForm()
    {
        if(!Classes::where("class", $this->class)->count()) {
            $this->addError("class", "Penulisan Format Kelas Anda Salah");
            return redirect()->back();
        }

        if($this->dimulai > $this->berakhir) {
            $this->addError("linkNotActivated", "Tanggal Saat Link Aktif harus sebelum Tanggal Link Kadaluarsa");
            $this->berakhir = '';
            return redirect()->back();
        }

        $this->validate([
            "class" => "required|string",
            "dimulai" => "date|required",
            "berakhir" => "date|required",
            "nama_link" => "string"
        ]);

        // create data
        $data_create = $this->status === "teacher" ? $this->teacher() : $this->student();

        $this->resetInput();
        session()->flash("success", "Berhasil Membuat Link Register " . $this->status === "teacher" ? "Guru" : "Siswa");
        return redirect(route("list_link_register", ["status" => $this->status]));
    }

    protected function resetInput()
    {
        $this->class = '';
        $this->dimulai = '';
        $this->berakhir = '';
        $this->nama_link = '';
    }

    protected function student()
    {
        $create = Auth::user()->register_students()->create([
            "classes_id" => Classes::firstWhere("class", $this->class)->id,
            "dimulai" => $this->dimulai,
            "berakhir" => $this->berakhir,
            "slug" => $this->nama_link === "" ? Auth::user()->name . "-" . uniqid() : \Str::slug($this->nama_link)
        ]);
        return $create;
    }

    protected function teacher()
    {
        $create = Auth::user()->register_teacher()->create([
            "mapel" => $this->mapel,
            "dimulai" => $this->dimulai,
            "berakhir" => $this->berakhir,
            "slug" => $this->nama_link === "" ? Auth::user()->name . "-" . uniqid() : \Str::slug($this->nama_link)
        ]);
        return $create;
    }

}
