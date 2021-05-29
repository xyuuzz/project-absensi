<?php

namespace App\Http\Livewire;

use App\Models\Absent;
use Illuminate\Support\Facades\Auth;
use Livewire\{WithPagination, Component};

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Absensi extends Component
{
    use WithPagination;

    public function render()
    {
        $list_absensi = [];
        foreach(Absent::get() as $absent) // looping setiap absent
        {
            foreach($absent->classes as $class) // looping kelas yang dimiliki absent
            {

                if(Auth::user()->student->classes_id === $class->id)
                {
                    array_push($list_absensi, $absent);
                }
            }
        }
        $list_absensi = $this->paginate(array_reverse($list_absensi, true));
        return view('livewire.absensi', compact("list_absensi"));
    }

    public function paginate($items, $perPage = 2, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function clickAbsen(Absent $absent)
    {
        $absent->students()->attach(Auth::user()->student->id);

        session()->flash("success", "Berhasil Absen, Pasti Kamu Anak Rajin:)");
        return redirect()->back();
    }

}
