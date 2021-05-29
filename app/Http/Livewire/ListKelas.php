<?php

namespace App\Http\Livewire;

use App\Models\{Absent, Classes};
use Livewire\Component;

class ListKelas extends Component
{
    protected $students, $class;

    public function mount(Classes $classes, Absent $absent)
    {
        $this->class = $classes;
        $this->students = $absent->students()->where("classes_id", $classes->id)->latest()->get();
        // dari table absent yang diterima dari route, lalu ke table student, ambil yang dimana classes_id nya sama seperti class id yang diterima dari route
    }

    public function render()
    {
        return view('livewire.list-kelas', [
            "students" => $this->students,
            "class" => $this->class,
        ]);
    }

}
