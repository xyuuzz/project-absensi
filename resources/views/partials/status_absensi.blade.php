@if(
    date("Y-m-d"). " " .date("H:i:s") >
    date_format($absensi->created_at, "Y-m-d") . " " . $absensi->schedule->dimulai
    &&
    date("Y-m-d"). " " .date("H:i:s") <
    date_format($absensi->created_at, "Y-m-d") . " " . $absensi->schedule->berakhir
    )
    @if(Auth::user()->role === "teacher")
        <span class="btn btn-sm btn-success float-right mb-2">Sedang Berlangsung</span>
    @elseif(Auth::user()->role === "student")
    <button wire:click='clickAbsen({{$absensi->id}})' type="button" class="btn btn-sm btn-dark float-right mb-2"
        {{$absensi->students()->where("user_id", Auth::id())->count() ? "disabled" : ""}}>
        {{$absensi->students()->where("user_id", Auth::id())->count()  ? "Sudah Absen" : "Absen"}}
    </button>
    @endif
    {{--
        Jika Waktu saat ini lebih dari jadwal dimulai dan kurang dari jadwal berakhir, maka tampilkan bahwa absensi sedang berlangsung
    --}}
@elseif(
    date("Y-m-d"). " " .date("H:i:s") >
    date_format($absensi->created_at, "Y-m-d") . " " . $absensi->schedule->berakhir
    )
    @if(Auth::user()->role === "teacher")
        <span class="btn btn-sm btn-danger float-right mb-2">Ditutup</span>
    @elseif(Auth::user()->role === "student")
        <span class="btn btn-sm float-right mb-2 disabled
        {{$absensi->students()->where("user_id", Auth::id())->count() ? "btn-success" : "btn-danger"}}">
            {{$absensi->students()->where("user_id", Auth::id())->count() ? "Sudah Absen" : "Sudah Ditutup"}}
        </span>
    @endif
    {{--
        Jika Waktu saat ini lebih dari jadwal berakhir, maka tampilkan bahwa jadwal sudah ditutup
    --}}
@elseif(
    date("Y-m-d"). " " .date("H:i:s") <
    date_format($absensi->created_at, "Y-m-d") . " " . $absensi->schedule->dimulai
        )
    @if(Auth::user()->role === "teacher")
        <span class="btn btn-sm btn-warning float-right mb-2">Segera Dibuka</span>
    @elseif(Auth::user()->role === "student")
        <span class="btn btn-sm btn-warning float-right mb-2">Segera Dibuka</span>
    @endif
    {{--
        Jika Waktu saat ini kurang dari jadwal dimulai, maka tampilkan bahwa jadwal akan segera dibuka.
    --}}
@endif
