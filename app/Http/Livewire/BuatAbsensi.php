<?php

namespace App\Http\Livewire;

use App\Http\Middleware\ForTeacher;
use Livewire\Component;

class BuatAbsensi extends Component
{
    public function render()
    {
        return view('livewire.buat-absensi');
    }
}
