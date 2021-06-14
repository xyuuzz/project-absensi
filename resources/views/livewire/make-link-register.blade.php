@section("title", "Buat List Register")
<div class="container">
    <div class="card">
        <div class="card-header ">
            <h4 class="mt-3 mb-3 d-inline-block"><b>Lengkapi Formulir Untuk Membuat Link Register {{ $status === "teacher" ? "Guru" : "Siswa"}}</b></h4>
            <a class="d-inline-block btn btn-sm btn-secondary mr-lg-3 float-lg-right mt-2" href="{{ route("kelola_siswa") }}">Kembali Ke List Siswa</a>
        </div>
        <div class="card-body">
            <form wire:submit.prevent='createForm' class="mt-3">
                @if($status === "teacher")
                    <div class="form-group">
                        <label for="mapel">Mapel</label>
                        <input required  id="mapel" type="text" class="form-control" wire:model="mapel" placeholder="Mapel yang diampu oleh guru yang akan mendaftar">
                        @error('mapel') <span class="error text-danger d-block"><i>{{ $message }}</i></span> @enderror
                        <small>Contoh Format Penulisan Mapel : Bahasa Indonesia, Matematika, Ilmu Pengetahuan Alam</small>
                    </div>
                @else
                    <div class="form-group">
                        <label for="class">Kelas</label>
                        <input required  id="class" type="text" class="form-control" wire:model="class" placeholder="Kelas Yang akan Ditempati Siswa">
                        @error('class') <span class="error text-danger d-block"><i>{{ $message }}</i></span> @enderror
                        <small>Contoh Format Penulisan Kelas : X RPL</small>
                    </div>
                @endif

                <div class="form-group">
                    <label for="dimulai">Link Akan Aktif Pada : </label>
                    <input required  id="dimulai" type="date" class="form-control" wire:model="dimulai" >
                    @error('dimulai') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
                </div>

                <div class="form-group">
                    <label for="berakhir">Link Akan Kadaluarsa Pada : </label>
                    <input required  id="berakhir" type="date" class="form-control" wire:model="berakhir" >
                    @error('berakhir') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
                </div>

                <div class="form-group">
                    <label for="nama_link">Nama Link <small>(Opsional)</small></label>
                    <input id="nama_link" type="text" class="form-control" wire:model="nama_link">
                    @error('nama_link') <span class="error text-danger"><i>{{ $message }}</i></span> @enderror
                </div>

                @error('linkNotActivated') <span class="error text-danger mt-2 mb-2 d-block"><i>{{ $message }}</i></span> @enderror
                <button type="submit" class="btn btn-info">Buat Link</button>
            </form>
        </div>
    </div>

</div>
