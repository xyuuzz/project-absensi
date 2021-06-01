<div>
<div class="table-responsive mt-3">
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">Nama {{$status === "teacher" ? "Guru" : "Siswa"}}</th>
                @if($status === "teacher")
                <th scope="col">Mapel</th>
                <th scope="col">NIGN</th>
                @elseif($status === "student")
                <th scope="col">Kelas</th>
                <th scope="col">No Absen</th>
                <th scope="col">NIS</th>
                <th scope="col">NISN</th>
                @endif
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">Email</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ Str::upper($name) }}</td>
                @if($status === "teacher")
                <td>{{ $mapel }}</td>
                <td>{{ $nign }}</td>
                @elseif($status === "student")
                <td>{{ $class }}</td>
                <td>{{ $no_absen }}</td>
                <td>{{ $nis }}</td>
                <td>{{ $nisn }}</td>
                @endif
                <td>{{ $jenis_kelamin }}</td>
                <td>{{ $email }}</td>
            </tr>
        </tbody>
    </table>
</div>
<h4 class="mt-3 mb-3">Edit Biodata {{$status === "teacher" ? "Guru" : "Siswa"}}</h4>
<form wire:submit.prevent='editForm' class="mt-3">
    <div class="form-group">
        <label for="name">Nama {{$status === "teacher" ? "Guru" : "Siswa"}}</label>
        <input required id="name" type="text" class="form-control" wire:model="name">
        @error('name') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input required id="email" type="email" class="form-control" wire:model="email">
        @error('email') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
    </div>
    <div class="form-group">
        <label for="password">Password Baru</label>
        <input id="password" type="password" class="form-control" wire:model="password"
            placeholder="Masukan Password Baru">
        @error('password') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
    </div>
    @if($status === "teacher")
        <div class="form-group">
            <label for="nign">NIGN Guru</label>
            <input required id="nign" type="text" class="form-control" wire:model="nign">
            @error('nign') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
        </div>
        <div class="form-group">
            <label for="mapel">Mapel yang Diampu</label>
            <input required id="mapel" type="text" {{ $mapel }} class="form-control" wire:model="mapel">
            @error('mapel') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
        </div>
    @elseif($status === "student")
        <div class="form-group">
            <label for="mapel">NIS</label>
            <input required id="nis" type="text" class="form-control" wire:model="nis">
            @error('nis') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
        </div>
        <div class="form-group">
            <label for="nign">NISN</label>
            <input required id="nisn" type="text" class="form-control" wire:model="nisn">
            @error('nisn') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
        </div>
        <div class="form-group">
            <label for="nisn">No Absen</label>
            <input required id="nisn" type="number" class="form-control" wire:model="no_absen">
            @if(session("errorNoAbsen"))
                <span class="error text-danger"><i>{{ session("errorNoAbsen") }}</i></span>
            @endif
        </div>
        <div class="form-group">
            <label for="class">Kelas</label>
            <input required id="class" type="text" class="form-control" wire:model="class">
            @if(session("errorClass"))
                <span class="error text-danger"><i>{{ session("errorClass") }}</i></span>
            @else
                <small class="form-text text-muted"><b>Contoh Penulisan Kelas : X RPL </b></small>
            @endif
        </div>
    @endif
    <div class="form-group">
        <label class="pr-3">Jenis Kelamin : </label>
        <div wire:ignore class="d-inline">
            <select id='jenis_kelamin'>
                @if ($jenis_kelamin === 'Laki-Laki')
                    <option>Laki-Laki</option>
                    <option>Perempuan</option>
                @else
                    <option>Perempuan</option>
                    <option>Laki-Laki</option>
                @endif
            </select>
        </div>
        <small class="form-text text-muted"><b>Biarkan Saja Jika Tidak Ingin Diganti </b></small>
    </div>
    <button type="submit" class="btn btn-info">Edit</button>
</form>

<script>
    const jenis_kelamin = document.getElementById("jenis_kelamin");
    jenis_kelamin.addEventListener("change", function() {
        @this.set("jenis_kelamin", jenis_kelamin.value);
    });
</script>

</div>
