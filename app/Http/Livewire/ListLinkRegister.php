<?php

namespace App\Http\Livewire;

use App\Http\Livewire\StudentRegister;
use Livewire\{Component, WithPagination};
use App\Models\{RegisterStudent, RegisterTeacher};

class ListLinkRegister extends Component
{
    use WithPagination;

    public $status, $slug, $dimulai, $berakhir, $mapel, $class, $item1, $item2;

    public function mount($status) {
        $this->status = $status === "teacher" ? "Guru" : "Siswa";
    }

    public function render()
    {
        if($this->status === "teacher") {
            $model = RegisterTeacher::latest()->paginate(5);
        } else {
            $model = RegisterStudent::latest()->paginate(5);
        }
        return view('livewire.list-link-register', compact("model"));
    }

    public function deleteData($id)
    {
        $this->status === "Guru" ? RegisterTeacher::find($id)->delete() : RegisterStudent::find($id)->delete();
        session()->flash("success", "Data " . $this->status === "Guru" ? "Guru" : "Siswa" . " Berhasil Dihapus!");
    }

}
