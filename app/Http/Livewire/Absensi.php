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
        // dapatkan semua absen dari yang paling baru dan looping
        // filter absen yang ada, sesuai kelas yang dimiliki oleh user.
        foreach(Absent::latest()->get() as $absent)
        {
            // dapatkan semua kelas dari absent yang di looping, lalu looping kelas tersebut
            foreach($absent->classes as $class)
            {
                // jika class id sama seperti classes_id yang dimiliki oleh user student dan absent dibuat pada hari itu, maka masukan absent ke dalam array.
                if(Auth::user()->student->classes_id === $class->id && date_format($absent->created_at, "Y-m-d") === date("Y-m-d"))
                {
                    array_push($list_absensi, $absent);
                }
            }
        }
        // paginate array yang sudah di proses
        $list_absensi = $this->paginate($list_absensi, 2);
        return view('livewire.absensi', compact("list_absensi"));
    }

    // fungsi paginate array
    public function paginate($items, $perPage = 2, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function clickAbsen($absent_id) # terima id absent yang dikirimkan ketika siswa klik tombol absen
    {
        // cari column absent dengan id tersebut
        $absent = Absent::find($absent_id);
        // jika absent ditemukan
        if(isset($absent))
        {
            // Jika Masih di dalam jadwal, maka siswa dinyatakan berhasil absen
            if
            (
                date("Y-m-d H:i:s") > date_format($absent->created_at, "Y-m-d") . " " . $absent->schedule->dimulai
                &&
                date("Y-m-d H:i:s") < date_format($absent->created_at, "Y-m-d") . " " . $absent->schedule->berakhir
            )
            {
                $absent->students()->attach(Auth::user()->student->id);
                session_unset();
                session_abort();
                session()->flash("success", "Berhasil Absen, Pasti Kamu Anak Rajin:)");
            }
            else # jika user absen sebelum/sesusah jadwal, maka :
            {
                session()->flash("danger", "Waduh, jangan nge hack dong mas...");
            }
        }
        else # jika absent tidak ditemukan
        {
            session()->flash("danger", "Waduh, jangan nge hack dong mas...");
        }
        return redirect()->back();
    }
}
