<?php

namespace App\Http\Livewire;

use App\Models\{RegisterStudent, RegisterTeacher};
use Livewire\{Component, WithPagination};

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

    public function setItem($item1, $item2) {
        $this->item1 = $item1;
        $this->item2 = $item2;
    }

    public function setLink()
    {
        // dd($this->item1);
        if($this->status === "Guru") {
            $link_copy = route("register_teacher", ["mapel" => $this->item1, "register_teacher" => $this->item2]);
        } else {
            $link_copy = route("register_student", ["classes" => $this->item1, "register_student" => $this->item2]);
        }
        return $link_copy;
    }
}
