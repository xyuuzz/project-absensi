<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\{Classes};

class MakeLinkRegister extends Component
{
    public $class, $dimulai, $berakhir;
    public $nama_link = '';

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

        Auth::user()->register_students()->create([
            "classes_id" => Classes::firstWhere("class", $this->class)->id,
            "dimulai" => $this->dimulai,
            "berakhir" => $this->berakhir,
            "slug" => Auth::user()->name . "-" . uniqid()
        ]);

        $this->resetInput();
        $this->emit("successCreated", "link");
    }

    protected function resetInput()
    {
        $this->class = '';
        $this->dimulai = '';
        $this->berakhir = '';
        $this->nama_link = '';
    }
}
