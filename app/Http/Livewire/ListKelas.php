<?php

namespace App\Http\Livewire;

use App\Models\{Absent, Classes};
use Livewire\Component;

class ListKelas extends Component
{
    protected $class, $absent;

    public function mount(Classes $classes, Absent $absent)
    {
        $this->class = $classes;
        $this->absent = $absent;
    }
    
    public function render()
    {
        $class_students = $this->absent->students->where("classes_id", $this->class->id);
        // dari table absent yang diterima dari route, lalu ke table student, ambil yang dimana classes_id nya sama seperti class id yang diterima dari route
        return view('livewire.list-kelas', compact("class_students"));
    }
}
