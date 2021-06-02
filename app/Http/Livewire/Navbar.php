<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public $photo;
    protected $listeners = [
        "updatePhoto" // menerima method emit livewire profile ketika profile di update
    ];

    public function render()
    {
        if(Auth::user()->role === "student") {
            $this->photo = Auth::user()->student->photo_profile;
        }
        return view('livewire.navbar');
    }

    public function updatePhoto()
    {
        $this->photo = Auth::user()->student->photo_profile;
    }
}
