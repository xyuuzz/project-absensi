<?php

namespace App\Http\Livewire;

use App\Http\Livewire\StudentRegister;
use Livewire\{Component, WithPagination};
use App\Models\{RegisterStudent, RegisterTeacher};

class ListLinkRegister extends Component
{
    use WithPagination;

    public $status, $slug, $dimulai, $berakhir, $mapel, $class;

    public function mount($status) {
        $this->status = $status === "teacher" ? "Guru" : "Siswa";
    }

    public function render()
    {
        $model = RegisterStudent::latest()->paginate(5);
        return view('livewire.list-link-register', compact("model"));
    }

    public function deleteData($id)
    {
        RegisterStudent::find($id)->delete();
        session()->flash("success", "Data Siswa Berhasil Dihapus!");
    }

}
