<div>
    <div class="table-responsive mt-3">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Nama {{$status === "teacher" ? "Guru" : "Siswa"}}</th>
                    <th scope="col">Email</th>
                    <th scope="col">Jenis Kelamin</th>
                    @if($status === "teacher")
                        <th scope="col">Mapel</th>
                        <th scope="col">NIGN</th>
                    @elseif($status === "student")
                        <th scope="col">Kelas</th>
                        <th scope="col">NIS</th>
                        <th scope="col">NISN</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{Str::upper($name)}}</td>
                    <td>{{$email}}</td>
                    <td>{{$jenis_kelamin}}</td>
                    @if($status === "teacher")
                        <td>{{$mapel}}</td>
                        <td>{{$nign}}</td>
                    @elseif($status === "student")
                        <td>{{$nis}}</td>
                        <td>{{$nisn}}</td>
                        <td>{{$class}}</td>
                    @endif
                </tr>
            </tbody>
        </table>
    </div>
    <h4 class="mt-3 mb-3">Edit Biodata {{$status === "teacher" ? "Guru" : "Siswa"}}</h4>
    <form wire:submit.prevent='editForm' class="mt-3">
        <div class="form-group">
            <label for="name">Nama {{$status === "teacher" ? "Guru" : "Siswa"}}</label>
            <input required  id="name" type="text" class="form-control" wire:model.defer="name">
            @error('name') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input required  id="email" type="email" class="form-control" wire:model.defer="email">
            @error('email') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" class="form-control" wire:model.defer="password" placeholder="Masukan Password Baru">
            @error('password') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
        </div>
        @if($status === "teacher")
            <div class="form-group">
                <label for="nign">NIGN Guru</label>
                <input required  id="nign" type="text" class="form-control" wire:model.defer="nign">
                @error('nign') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
            </div>
            <div class="form-group">
                <label for="mapel">Mapel yang Diampu</label>
                <input required  id="mapel" type="text" {{ $mapel }} class="form-control" wire:model.defer="mapel">
                @error('mapel') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
            </div>
        @elseif($status === "student")
            <div class="form-group">
                <label for="nis">NIS</label>
                <input required  id="nis" type="text" class="form-control" wire:model.defer="nis">
                @error('nis') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
            </div>
            <div class="form-group">
                <label for="nisn">NISN</label>
                <input required  id="nisn" type="text" class="form-control" wire:model.defer="nisn">
                @error('nisn') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
            </div>
            <div class="form-group">
                <label for="no_absen">No Absen</label>
                <input required  id="no_absen" type="number" class="form-control" wire:model.defer="no_absen">
                @error("no_absen") <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
            </div>
            <div class="form-group">
                <label for="class">Kelas</label>
                <input required  id="class" type="text" class="form-control" wire:model.defer="class">
                @error("class") <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
                <small id="email" class="form-text text-muted"><b>Contoh Penulisan Kelas : X RPL </b></small>
            </div>
        @endif
        <div class="form-group">
            <label class="pr-3">Jenis Kelamin : </label>
            <div wire:ignore class="d-inline">
                <select id='jenis_kelamin'>
                    <option>Pilih Salah Satu</option>
                    <option>Laki-Laki</option>
                    <option>Perempuan</option>
                </select>
            </div>
            <small id="email" class="form-text text-muted"><b>Biarkan Saja Jika Tidak Diganti</b></small>
        </div>
        <button type="submit" class="btn btn-info">Sunting</button>
    </form>

    <script>
        const jenis_kelamin = document.getElementById("jenis_kelamin");
            jenis_kelamin.addEventListener("change", function() {
                if(jenis_kelamin.value !== "Pilih Salah Satu") @this.set("jenis_kelamin", jenis_kelamin.value);
            });
    </script>

</div>
