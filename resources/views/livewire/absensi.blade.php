@section("title", "Absensi Kelas")


<div class="container">
    @if(session("success"))
        <div class="alert alert-success mt-3 col-lg-4" role="alert">
            {{session("success")}}
        </div>
    @endif
    @if(session("danger"))
        <div class="alert alert-danger mt-3 col-lg-4" role="alert">
            {{session("danger")}}
        </div>
    @endif

    <div class="d-flex justify-content-center mt-4">
        <p class="text-center">{{$list_absensi->links("livewire::simple-bootstrap")}}</p>
    </div>

    @forelse($list_absensi as $absensi)
        <div class="card mt-4">
            <div class="card-body">
                <div class="mb-4">
                    <span><b>{{date_format($absensi->created_at, "l, d F Y")}}</b></span>
                </div>
                <hr>
                <p>Mata Pelajaran : <span>{{$absensi->teacher->mapel}}</span></p>
                <p>Guru Pengampu : <span>{{$absensi->teacher->user->name}}</span></p>
                <p class="mt-2">Jadwal Absensi : <b>{{$absensi->schedule->dimulai . " - " . $absensi->schedule->berakhir}}</b></p>
                @include("partials.status_absensi")
            </div>
        </div>
    @empty
        <div class="card">
            <div class="card-header">Tidak Ada Absensi Hari Ini</div>
        </div>
    @endforelse

</div>
