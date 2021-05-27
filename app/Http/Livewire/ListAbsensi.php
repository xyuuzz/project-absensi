<?php

namespace App\Http\Livewire;

use App\Models\Absent;
use Illuminate\Support\Facades\Auth;
use Livewire\{Component, WithPagination};

class ListAbsensi extends Component
{
    use WithPagination;

    public function render()
    {
        $list_absensi = Absent::latest()->simplePaginate(1);

        if(count($list_absensi) === 0)
        {
            session()->flash("warning", "Absensi Anda Kosong, Silahkan Buat Dengan Mengisi Form Dibawah");
            redirect(route("buat_absensi"));
        }

        return view('livewire.list-absensi', compact('list_absensi'));
    }

    public function hapusAbsensi(Absent $absent)
    {
        $absent->classes()->detach();
        $absent->students()->detach();

        $absent->delete();

        if(count(Auth::user()->teacher->absent) !== 0)
        {
            session()->flash("success", "Berhasil Dihapus!");
        }
        return redirect()->back();
    }
}
