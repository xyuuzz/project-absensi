@section("title", "Daftar Absensi Siswa")

<div class="container col-lg-8">
    <a href="{{route("list_absensi")}}" class="btn btn-sm btn-success mb-3"><< Kembali</a>
    <div class="card justify-content-center">
        <div class="card-header">
            <h3>Kelas : {{$class->class}}</h3>
        </div>
        <div class="card-body">
            @if(count($students))
                <h5><b>Daftar Siswa Yang Sudah Absen :</b></h5>
                @foreach($students as $student)
                    <p>{{$student->no_absen}}. {{Str::upper($student->user->name)}}</p>
                @endforeach
            @else
                <p>Belum Ada Siswa Yang Absen</p>
            @endif
        </div>
    </div>
</div>
