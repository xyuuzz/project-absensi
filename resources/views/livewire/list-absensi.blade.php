@section("title", "Daftar Absensi")
<div class="container">
    @if(session("success"))
        <div class="alert alert-success mt-3 col-lg-4" role="alert">
            {{session("success")}}
        </div>
    @endif

    {{-- <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
      <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
        <div class="toast-header">
          <strong class="mr-auto">Pesan</strong>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body">
          Absen Berhasil Dihapus!
        </div>
      </div>
    </div> --}}

    @foreach($list_absensi as $absensi)
    <div class="card mt-4">
        <div class="card-body">
            <div class="mb-4">
                {{-- {{dd(date("Y-m-d"). " " .date("H:i:s") >
                date_format($absensi->created_at, "Y-m-d") . " " . $absensi->schedule->dimulai
                &&
                date("Y-m-d"). " " .date("H:i:s") <
                date_format($absensi->created_at, "Y-m-d") . " " . $absensi->schedule->berakhir
                )}} --}}
                <span><b>{{date_format($absensi->created_at, "l, d F Y")}}</b></span>

                @include("partials.status_absensi")

            </div>
            <hr>
            <p>Mata Pelajaran : <span>{{$absensi->teacher->mapel}}</span></p>
            {{-- <p>Guru Pengampu : <span>{{$absensi->teacher->user->name}}</span></p> --}}
            <p>Kelas Yang Mengikuti Absensi : </p>
            @foreach($absensi->classes()->get() as $kelas)
                <a href="{{route("list_kelas", ["user" => Auth::user()->name, "classes" => $kelas->class, "absent" => $absensi->id])}}" class="btn btn-sm btn-success">{{$kelas->class}}</a>
            @endforeach
            <p class="mt-2">Jadwal Absensi : <b>{{$absensi->schedule->dimulai . " - " . $absensi->schedule->berakhir}}</b></p>
            <button wire:click='hapusAbsensi({{$absensi->id}})' type="button" class="btn btn-sm btn-outline-danger float-right" id="liveToastBtn">Hapus Absensi</button>
        </div>
    </div>
    @endforeach

    <div class="d-flex justify-content-center mt-4">
        <p class="text-center">{{$list_absensi->links("livewire::simple-bootstrap")}}</p>
    </div>

</div>

    {{-- <script>
        $("#liveToastBtn").on("click", () => $("#liveToast").toast("show"));
        // document.querySelector("#liveToastBtn").addEventListener("click", () => {
        //     document.querySelector("#liveToast").addEventListener("show");
        // })
    </script>  --}}



{{-- CARA UNTUK VALIDASI SCHEDULE UNTUK SISWA --}}
{{-- @if($list_absensi[0]->schedule->dimulai < date("H:i:s"))
    {{dd($list_absensi[0]->schedule)}}
@endif --}}
{{--
    looping setiap absensi(foreach) yang sudah difilter menurut kelas nya,
    buat kondisi dimana hanya tampilkan absensi yang masih di dalam jangkauan waktu schedule.
--}}
