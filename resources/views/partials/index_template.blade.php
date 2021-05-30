<div class="d-lg-flex justify-content-between">
    <h4 class="mt-3 mb-3"><b>List Guru Yang Terdaftar : </b></h4>
    <div class="">
    <form class="form-inline my-2 my-lg-0">
        <input wire:model='search' class="form-control mr-sm-2" type="search" placeholder="Cari Berdasarkan {{$s_based_on == "name" || $s_based_on == null ? "Nama" : "Mapel"}}" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <div class="mb-3 d-block mt-2">
        <span>Cari Berdasarkan : </span>
        <span wire:click='cari_berdasarkan("name")' class="btn btn-sm {{$s_based_on == "name" || $s_based_on == null ? "btn-warning" : "btn-secondary"}}">Nama</span>
        <span  wire:click='cari_berdasarkan("mapel")' class="btn btn-sm {{$s_based_on == "mapel" ? "btn-warning" : "btn-secondary"}}">Mapel</span>
    </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-sm">
        <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Guru</th>
            <th scope="col">Jenis Kelamin</th>
            <th scope="col">Email</th>
            <th scope="col">Mapel</th>
            <th scope="col">NIGN</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($kumpulan_data as $data)
                <tr>
                    <th scope="row">{{$index}}</th>
                    <td>{{Str::upper($data->user->name)}}</td>
                    <td>{{$data->user->jenis_kelamin}}</td>
                    <td>{{$data->user->email}}</td>
                    <td>{{$data->mapel}}</td>
                    <td>{{$data->nign}}</td>
                    <td class="">
                        <span wire:click='deleteData({{$data->user_id}})' class="btn btn-sm btn-outline-danger mr-2">Hapus</span>
                        <span wire:click='editView({{$data->id}})' class="btn btn-sm btn-outline-info mt-smm-2">Edit</span>
                    </td>
            </tr>
            <?php $index++; ?> {{-- Increment index untuk no table --}}
            @endforeach
        </tbody>
    </table>
</div>
