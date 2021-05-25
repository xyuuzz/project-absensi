<?php

namespace App\Http\Livewire;

use App\Http\Middleware\ForStudents;
use Livewire\Component;

class Absensi extends Component
{
    public function render()
    {
        return view('livewire.absensi');
    }
}
