<?php

namespace App\Http\Livewire;

use App\Models\{Absent, Classes};
use Illuminate\Support\Collection;

use Illuminate\Support\Facades\Auth;
use Livewire\{Component, WithPagination};
use Illuminate\Pagination\{LengthAwarePaginator, Paginator};

class ListAbsensi extends Component
{
    use WithPagination;
    public $pilah_berdasarkan, $query;

    public function render()
    {
        // urutkan dari yang terbaru, lalu paginate dengan 1 halaman hanya menampilkan 1 data
        $absents_teacher = Absent::where("teacher_id", Auth::user()->teacher->id);
        $list_absensi = $absents_teacher->latest()
                                        ->simplePaginate(2);

        if(strlen($this->query))
        {
            if($this->pilah_berdasarkan === "Tanggal")
            {
                $list_absensi = $this->search_day($absents_teacher);
            }
            elseif($this->pilah_berdasarkan === "Bulan")
            {
                $list_absensi = $this->search_month($absents_teacher);
            }
            elseif($this->pilah_berdasarkan === "Tahun")
            {
                $list_absensi = $this->search_year($absents_teacher);
            }
            elseif($this->pilah_berdasarkan === "Kelas")
            {
                $list_absensi = $this->search_class($absents_teacher);
            }
        }
        else
        {
            // jika tidak ada absensi
            if(count($absents_teacher->get()) === 0)
            {
                // kirim session flash, lalu redirect ke halaman buat_absensi
                session()->flash("warning", "Absensi Anda Kosong, Silahkan Buat Dengan Mengisi Form Dibawah");
                redirect(route("buat_absensi"));
            }
        }

        return view('livewire.list-absensi', compact('list_absensi'));
    }

    public function custom_paginate($items, $perPage = 2, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
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

    protected function search_day($absents_teacher)
    {
        return $absents_teacher->where("created_at", "like", "%2021-06-{$this->query}%")
        ->latest()
        ->simplePaginate(2);
    }

    protected function search_month($absents_teacher)
    {
        $query = $this->query;
        if(strlen($this->query) === 1)
        {
            $query =  "0" . $this->query;
        }
        return $absents_teacher->where("created_at", "like", "%2021-{$query}%")
                                ->latest()
                                ->simplePaginate(2);
    }

    protected function search_year($absents_teacher)
    {
        return $absents_teacher->where("created_at", "like", "%{$this->query}%")
                                        ->latest()
                                        ->simplePaginate(2);
    }

    protected function search_class($absents_teacher)
    {
        // buat variabel berisi array kosong untuk menampung hasil
        $temp = [];
        // cari class yang similar dengan query user
        $classes = Classes::where("class", "like", "%{$this->query}%")->get();
        // looping semua absent
        foreach($absents_teacher->get() as $absent)
        {
            // looping kelas yang sudah didapatkan
            foreach($classes as $class)
            {
                // jika absent mempunyai class yang sama dengan class tsb
                if($absent->classes()->where("class", $class->class)?->first())
                {
                    // maka push obj absent tersebut ke dalam var temp
                    array_push($temp, $absent);
                }
            }
        }
        // kita paginate arr temp yang berisi obj absent menggunakan custom_paginate method
        return $this->custom_paginate($temp);
    }
}
