<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\{Absent, Schedule, Classes};

class BuatAbsensi extends Component
{
    public $sche, $list_kelas;

    public function render()
    {
        $schedule = Schedule::get();
        $classes = Classes::get();
        return view('livewire.buat-absensi', compact("schedule", "classes"));
    }

    public function buatAbsensi()
    {
        dd($this->list_kelas);
        // validation
        if($this->list_kelas === null || $this->sche === null || $this->sche === "Pilih Jam Absensi Dibawah")
        {
            session()->flash("error", "Wajib Lengkapi Form Dibawah!!");
            return redirect()->back();
        }
        if(count($this->list_kelas) === 0)
        {
            session()->flash("error", "Minimal Centang 1 Kelas!");
            return redirect()->back();
        }

        // after validation

        $absent = Absent::create([
            "teacher_id" => Auth::user()->teacher->id,
            "schedule_id" => $this->sche
        ]);
        // create relation field on classes table
        $absent->classes()->attach($this->list_kelas);

        session()->flash("success", "Berhasil Membuat Absensi Siswa");
        return redirect(route("list_absensi"));
    }
}
