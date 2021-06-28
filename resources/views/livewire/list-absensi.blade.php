@section("title", "Daftar Absensi")
<div class="container">
    @if(session("success"))
        <div class="alert alert-success mt-3 col-lg-4" role="alert">
            {{session("success")}}
        </div>
    @endif

    <div class="d-flex justify-content-center mt-2">
        <p class="text-center">{{$list_absensi->links("livewire::simple-bootstrap")}}</p>
    </div>

    <div class="d-block col-lg-4 mt-3">
        <select wire:model='pilah_berdasarkan' class="form-control">
            <option>Pilah Berdasarkan</option>
            <option value="Tanggal">Tanggal</option>
            <option value="Bulan">Bulan</option>
            <option value="Tahun">Tahun</option>
            <option value="Kelas">Kelas</option>
        </select>
        <input wire:model="query" type="numeric" class="form-control mt-2 col-8" placeholder="Cari berdasarkan : {{ $pilah_berdasarkan !== null && $pilah_berdasarkan !== "Pilah Berdasarkan" ? $pilah_berdasarkan : "Diatas"}}" >
    </div>

    {{-- Looping semua absensi --}}
    @forelse($list_absensi as $absensi)
        {{-- Tampilkan absensi yang dimiliki oleh guru yang sedang login --}}
        @if($absensi->teacher->id === Auth::user()->teacher->id)
            <div class="card mt-4 d-block">
                <div class="card-body">
                    <div class="mb-smm-5">
                        <span class="d-smm-block"><b>{{date_format($absensi->created_at, "l, d F Y")}}</b></span>
                        <div class="d-inline float-smm-left mt-smm-1">
                            @include("partials.status_absensi")
                        </div>
                    </div>
                    <hr>
                    <p>Mata Pelajaran : <span>{{$absensi->teacher->mapel}}</span></p>
                    <p>Kelas Yang Mengikuti Absensi : </p>
                    @foreach($absensi->classes()->get() as $kelas)
                        <a href="{{route("list_kelas", ["user" => Auth::user()->name, "classes" => $kelas->class, "absent" => $absensi->id])}}" class="btn btn-sm btn-success">{{$kelas->class}}</a>
                    @endforeach
                    <p class="mt-2">Jadwal Absensi : <b>{{$absensi->schedule->dimulai . " - " . $absensi->schedule->berakhir}}</b></p>
                    <button wire:click='hapusAbsensi({{$absensi->id}})' type="button" class="btn btn-sm btn-outline-danger">Hapus Absensi</button>
                </div>
            </div>
        @endif
    @empty
        <div class="card mt-4 d-block">
            <div class="card-body">
                <h3 class="text-center"><b>Tidak Ada Data Absen!</b></h3>
            </div>
        </div>
    @endforelse

</div>


{{-- CARA UNTUK VALIDASI SCHEDULE UNTUK SISWA --}}
{{-- @if($list_absensi[0]->schedule->dimulai < date("H:i:s"))
    {{dd($list_absensi[0]->schedule)}}
@endif --}}
{{--
    looping setiap absensi(foreach) yang sudah difilter menurut kelas nya,
    buat kondisi dimana hanya tampilkan absensi yang masih di dalam jangkauan waktu schedule.
--}}
