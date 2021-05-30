<div>

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
    
    <script>
        const jenis_kelamin = document.getElementById("jenis_kelamin");
            jenis_kelamin.addEventListener("change", function() {
                @this.set("jenis_kelamin", jenis_kelamin.value);
            });
    </script>
</div>
