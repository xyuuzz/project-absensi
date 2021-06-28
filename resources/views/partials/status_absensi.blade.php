{{--
    Jika Waktu saat ini lebih dari jadwal dimulai dan kurang dari jadwal berakhir, maka tampilkan bahwa absensi sedang berlangsung
--}}
@if(
    date("Y-m-d H:i:s") > date_format($absensi->created_at, "Y-m-d") . " " . $absensi->schedule->dimulai
    &&
    date("Y-m-d H:i:s") < date_format($absensi->created_at, "Y-m-d") . " " . $absensi->schedule->berakhir
    )
    @if(Auth::user()->role === "teacher")
        <span class="btn btn-sm btn-success float-right mb-2">Sedang Berlangsung</span>
    @elseif(Auth::user()->role === "student")
        @if($absensi->students()->where("user_id", Auth::id())->count())
            <span class="btn btn-sm btn-secondary float-right mb-2">Sudah Absen</span>
        @else
            <button wire:click='clickAbsen({{$absensi->id}})' type="button" class="btn btn-sm btn-dark float-right mb-2">
                Absen
            </button>
        @endif
    @endif

{{-- Jika Waktu saat ini lebih dari jadwal berakhir, maka tampilkan sudah ditutup --}}
@elseif( date("Y-m-d H:i:s") > date_format($absensi->created_at, "Y-m-d") . " " . $absensi->schedule->berakhir )
    @if(Auth::user()->role === "teacher")       {{-- Jika Guru --}}
        <span class="btn btn-sm btn-danger float-right mb-2">Ditutup</span>
    @elseif(Auth::user()->role === "student")   {{-- Jika siswa --}}
        {{-- Jika sudah absen, maka tulisanya adalah sudah absen dan berwarna abu-abu, namun jika tidak absen, maka tulisanya adalah sudah ditutup dan warnanya merah! --}}
        <span class="btn btn-sm float-right mb-2 disabled
        {{$absensi->students()->where("user_id", Auth::id())->count() ? "btn-success" : "btn-danger"}}" >
            {{$absensi->students()->where("user_id", Auth::id())->count() ? "Sudah Absen" : "Sudah Ditutup"}}
        </span>
    @endif

{{-- Jika Waktu saat ini kurang dari jadwal dimulai, maka tampilkan bahwa jadwal akan segera dibuka. --}}
@elseif( date("Y-m-d H:i:s") < date_format($absensi->created_at, "Y-m-d") . " " . $absensi->schedule->dimulai )
    <span class="btn btn-sm btn-warning float-right mb-2">Segera Dibuka</span>
@endif
