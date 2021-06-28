<div class="d-lg-flex justify-content-between">
    <h4 class="mt-3 mb-3"><b>{{$status === "teacher" ? "Guru" : "Siswa"}} Yang Terdaftar : </b></h4>
    <div class="mt-2">
        @if($status === "teacher")
            <input wire:model='search' class="form-control mr-sm-2" type="search" placeholder="Cari Berdasarkan {{$s_based_on == "name" || $s_based_on == null ? "Nama" : "Mapel"}}" aria-label="Search">
        @elseif($status === "student")
            <input wire:model='search' class="form-control mr-sm-2" type="search" placeholder="Cari Berdasarkan {{$s_based_on == "name" || $s_based_on == null ? "Nama" : "Kelas"}}" aria-label="Search">
        @endif
        <div class="mb-3 d-block mt-2">
            <span>Cari Berdasarkan : </span>
            <span wire:click='cari_berdasarkan("name")' class="btn btn-sm {{$s_based_on == "name" || $s_based_on == null ? "btn-warning" : "btn-secondary"}} ">Nama</span>
            @if($status === "teacher")
                <span  wire:click='cari_berdasarkan("mapel")' class="btn btn-sm {{$s_based_on == "mapel" ? "btn-warning" : "btn-secondary"}}">Mapel</span>
            @elseif($status === "student")
                <span  wire:click='cari_berdasarkan("class")' class="btn btn-sm {{$s_based_on == "class" ? "btn-warning" : "btn-secondary"}}">Kelas</span>
            @endif
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-sm">
        <thead>
        <tr>
            <th scope="col">{{$status === "teacher" ? "No" : "No Absen"}}</th>
            <th scope="col">Nama {{$status === "teacher" ? "Guru" : "Siswa"}}</th>
            @if($status === "teacher")
            <th scope="col">Mapel</th>
            <th scope="col">NIGN</th>
            @elseif($status === "student")
            <th scope="col">Kelas</th>
            <th scope="col">NIS</th>
            <th scope="col">NISN</th>
            @endif
            <th scope="col">Email</th>
            <th scope="col">Jenis Kelamin</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
            @forelse ($kumpulan_data as $data)
                <tr>
                    <th scope="row">{{$index ?? $data->no_absen}}</th>
                    <td>{{Str::upper($data->user->name)}}</td>
                    @if($status === "teacher")
                    <td>{{$data->mapel}}</td>
                    <td>{{$data->nign}}</td>
                    @elseif($status === "student")
                    <td>{{$data->classes->class}}</td>
                    <td>{{$data->nis}}</td>
                    <td>{{$data->nisn}}</td>
                    @endif
                    <td>{{$data->user->email}}</td>
                    <td>{{$data->user->jenis_kelamin}}</td>
                    <td class="">
                        <span wire:click='deleteData({{$data->user_id}}, {{ count($_GET) ? $_GET['page'] : 1 }})' class="btn btn-sm btn-outline-danger mr-2">Hapus</span>
                        <span wire:click='editView({{$data->id}})' class="btn btn-sm btn-outline-info mt-smm-2">Edit</span>
                    </td>
            </tr>
            @if($status === "teacher") {{-- untuk student tidak diberi index karena index nomor nya adalah nomor absen siswa --}}
                <?php $index++; ?> {{-- Increment index untuk no table --}}
            @endif

            @empty
                <td colspan="8" class="text-center"><b>Tidak Ada Data {{ $status === "teacher" ? "Guru" : "Siswa"}}<b></td>
            @endforelse
        </tbody>
    </table>

    @if(!strlen($this->search))
        {{ $kumpulan_data->links() }}
    @endif
</div>
