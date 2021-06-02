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
        // filter absen yang ada, sesuai kelas yang dimiliki oleh user.
        foreach(Absent::get() as $absent) // looping setiap absent
        {
            // dd(array_map(function($row) {
            //     if(Auth::user()->student->classes_id === $row["id"]) {
            //         return Absent::firstWhere("id", $row["pivot"]["absent_id"]);
            //     }
            // }, $absent->classes->toArray()));

            foreach($absent->classes as $class) // looping/dapatkan semua kelas yang dimiliki absent
            {
                // jika class id sama seperti classes_id yang dimiliki oleh user student dan absent dibuat pada hari itu, maka masukan absent ke dalam array.
                if(Auth::user()->student->classes_id === $class->id && date_format($absent->created_at, "Y-m-d") === date("Y-m-d"))
                {
                    array_push($list_absensi, $absent);
                }
            }
        }
        // paginate array yang sudah di proses
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
        // Jika Masih di dalam jadwal, maka siswa dinyatakan berhasil absen
        if(
            date("Y-m-d H:i:s") > date_format($absent->created_at, "Y-m-d") . " " . $absent->schedule->dimulai
            &&
            date("Y-m-d H:i:s") < date_format($absent->created_at, "Y-m-d") . " " . $absent->schedule->berakhir
        ) {
            $absent->students()->attach(Auth::user()->student->id);
            session()->flash("success", "Berhasil Absen, Pasti Kamu Anak Rajin:)");
        }

        return redirect()->back();
    }
}
