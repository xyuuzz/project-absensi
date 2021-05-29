@section("title", "Kelola Guru")
<div class="container">
    <style>
        @media only screen and (max-width: 576px) {
            .mt-smm-2 {
                margin-top: 10px;
            }
        }
    </style>
    <div class="card">
        <div class="card-header">
            <strong>Kelola Guru</strong>
        </div>
        <div class="card-body">

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

            <button wire:click='viewBuatGuru()' type="button" class="btn btn-sm btn-secondary">
                {{$view === "list_guru" ? "Buat Anggota Guru Baru" : "Lihat List Guru"}}
            </button>
            @if($view === "list_guru")
                <h4 class="mt-3 mb-3"><b>List Guru Yang Terdaftar : </b></h4>
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
                            @foreach ($list_guru as $guru)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{Str::upper($guru->user->name)}}</td>
                                    <td>{{$guru->user->jenis_kelamin}}</td>
                                    <td>{{$guru->user->email}}</td>
                                    <td>{{$guru->mapel}}</td>
                                    <td>{{$guru->nign}}</td>
                                    <td class="">
                                        <span wire:click='hapusGuru({{$guru->user_id}})' class="btn btn-sm btn-outline-danger mr-2">Hapus</span>
                                        <span wire:click='viewEditGuru({{$guru->id}})' class="btn btn-sm btn-outline-info mt-smm-2">Edit</span>
                                    </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif($view === "buat_guru")
                <h4 class="mt-3 mb-3"><b>Lengkapi Formulir Untuk Mendaftarkan Guru Baru : </b></h4>
                <form wire:submit.prevent='formBuatGuru' >
                    <div class="form-group">
                        <label for="nama_guru">Nama Guru</label>
                        <input required id="nama_guru" type="text" class="form-control" placeholder="Nama Guru" wire:model="nama_guru">
                        @error('nama_guru') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input required id="email" type="email" class="form-control" placeholder="Email" wire:model="email">
                        @error('email') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input required id="password" type="password" class="form-control" placeholder="Password" wire:model="password">
                        @error('password') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nign">NIGN Guru</label>
                        <input required id="nign" type="text" class="form-control" placeholder="NIGN Guru" wire:model="nign">
                        @error('nign') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="mapel">Mapel yang Diampu</label>
                        <input required id="mapel" type="text" placeholder='Mapel yang Diampu oleh Guru' class="form-control" wire:model="mapel">
                        @error('mapel') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="pr-3">Jenis Kelamin : </label>
                        <div wire:ignore class="d-inline">
                            <select id='jenis_kelamin'>
                                <option>Laki-Laki</option>
                                <option>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info">Buat</button>
                </form>
            @else
                <div class="table-responsive mt-3">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th scope="col">Nama Guru</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Email</th>
                            <th scope="col">Mapel</th>
                            <th scope="col">NIGN</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{Str::upper($e_guru->user->name)}}</td>
                                <td>{{$e_guru->user->jenis_kelamin}}</td>
                                <td>{{$e_guru->user->email}}</td>
                                <td>{{$e_guru->mapel}}</td>
                                <td>{{$e_guru->nign}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h4 class="mt-3 mb-3">Edit Biodata Guru</h4>
                <form wire:submit.prevent='formEditGuru' class="mt-3">
                    <div class="form-group">
                        <label for="nama_guru">Nama Guru</label>
                        <input required id="nama_guru" type="text" class="form-control"  wire:model="nama_guru">
                        @error('nama_guru') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input required id="email" type="email" class="form-control" wire:model="email">
                        @error('email') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input id="password" type="password" class="form-control" wire:model="password" placeholder="Masukan Password Baru">
                        @error('password') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nign">NIGN Guru</label>
                        <input required id="nign" type="text" class="form-control" wire:model="nign">
                        @error('nign') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="mapel">Mapel yang Diampu</label>
                        <input required id="mapel" type="text" {{$mapel}} class="form-control" wire:model="mapel">
                        @error('mapel') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
                    </div>
                    <div class="form-group">
                        <label class="pr-3">Jenis Kelamin : </label>
                        <div wire:ignore class="d-inline">
                            <select id='jenis_kelamin'>
                                @if($jenis_kelamin === "Laki-Laki")
                                    <option>Laki-Laki</option>
                                    <option>Perempuan</option>
                                @else
                                    <option>Laki-Laki</option>
                                    <option>Perempuan</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info">Edit</button>
                </form>
            @endif
        </div>
    </div>

    @if($view === "buat_guru")
        <script>
            const jenis_kelamin = document.getElementById("jenis_kelamin");
                jenis_kelamin.addEventListener("change", function() {
                    @this.set("jenis_kelamin", jenis_kelamin.value);
                });
        </script>
    @endif
</div>
