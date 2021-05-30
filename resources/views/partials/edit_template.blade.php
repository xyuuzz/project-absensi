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
                <td>{{ Str::upper($e_guru->user->name) }}</td>
                <td>{{ $e_guru->user->jenis_kelamin }}</td>
                <td>{{ $e_guru->user->email }}</td>
                <td>{{ $e_guru->mapel }}</td>
                <td>{{ $e_guru->nign }}</td>
            </tr>
        </tbody>
    </table>
</div>
<h4 class="mt-3 mb-3">Edit Biodata Guru</h4>
<form wire:submit.prevent='editForm' class="mt-3">
    <div class="form-group">
        <label for="nama_guru">Nama Guru</label>
        <input required id="nama_guru" type="text" class="form-control" wire:model="name">
        @error('nama_guru') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
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
    </div>
    <button type="submit" class="btn btn-info">Edit</button>
</form>

<script>
    const jenis_kelamin = document.getElementById("jenis_kelamin");
        jenis_kelamin.addEventListener("change", function() {
            @this.set("jenis_kelamin", jenis_kelamin.value);
        });
</script>
