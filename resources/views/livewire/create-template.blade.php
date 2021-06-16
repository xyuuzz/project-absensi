<div>
    <h4 class="mt-3 mb-3"><b>Lengkapi Formulir Untuk Mendaftarkan {{$status === "teacher" ? "Guru" : "Siswa"}} Baru : </b></h4>
    <form wire:submit.prevent='createForm' class="mt-3">
        <div class="form-group">
            <label for="name">Nama {{$status === "teacher" ? "Guru" : "Siswa"}}</label>
            <input required  id="name" type="text" class="form-control" wire:model="name"
            placeholder="Masukan Nama {{ $status === "teacher" ? "Guru" : "Siswa"}}" >
            @error('name') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input required  id="email" type="email" class="form-control" wire:model="email" placeholder="Masukan Email {{ $status === "teacher" ? "Guru" : "Siswa"}}" >
            @error('email') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input required id="password" type="password" class="form-control" wire:model="password"
                placeholder="Masukan Password">
            @error('password') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
        </div>
        @if($status === "teacher")
            <div class="form-group">
                <label for="nign">NIGN Guru</label>
                <input required  id="nign" type="text" class="form-control" wire:model="nign" placeholder="Masukan NIGN Milik Guru">
                @error('nign') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
            </div>
            <div class="form-group">
                <label for="mapel">Mapel yang Diampu</label>
                <input required  id="mapel" type="text" {{ $mapel }} class="form-control" wire:model="mapel" placeholder="Mapel Yang Diampu">
                @error('mapel') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
            </div>
        @elseif($status === "student")
            <div class="form-group">
                <label for="nis">NIS</label>
                <input required  id="nis" type="text" class="form-control" wire:model="nis" placeholder="Masukan NIS Milik Siswa">
                @error('nis') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
            </div>
            <div class="form-group">
                <label for="nisn">NISN</label>
                <input required  id="nisn" type="text" class="form-control" wire:model="nisn" placeholder="Masukan NISN Milik Siswa">
                @error('nisn') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
            </div>
            <div class="form-group">
                <label for="no_absen">No Absen</label>
                <input required  id="no_absen" type="number" class="form-control" wire:model="no_absen" placeholder="Masukan No Absen Siswa">
                @if(session("errorNoAbsen"))
                    <span class="error text-danger"><i>{{ session("errorNoAbsen") }}</i></span>
                @endif
            </div>
            <div class="form-group">
                <label for="class">Kelas</label>
                <input required  id="class" type="text" class="form-control" wire:model="class" placeholder="Masukan Kelas Yang Ditempati Oleh Siswa">
                @if(session("errorClass"))
                    <span class="error text-danger"><i>{{ session("errorClass") }}</i></span>
                @else
                    <small id="email" class="form-text text-muted"><b>Contoh Penulisan Kelas : X RPL </b></small>
                @endif
            </div>
        @endif
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

    <script>
        const jenis_kelamin = document.getElementById("jenis_kelamin");
            jenis_kelamin.addEventListener("change", function() {
                @this.set("jenis_kelamin", jenis_kelamin.value);
                console.log("{{$jenis_kelamin}}")
            });
    </script>
</div>
