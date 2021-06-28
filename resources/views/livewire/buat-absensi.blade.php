@section("title", "Buat Absensi")
<div class="container">
    <style>
        @media only screen and (max-width: 576px){
            .d-sm-blockk {
                display: block;
            }
            .float-sm-rightt {
                float: right;
            }
            .d-sm-flexx {
                display: flex;
            }
        }
    </style>
    <div class="card">
        <div class="card-header bg-teal">
            <h5 class="text-center text-primary"><b>Form Absensi Kehadiran Siswa</b></h5>
        </div>
        <div class="card-body form-group">

            @if(session("warning"))
                <div class="alert alert-warning mt-3 col-lg-8" role="alert">
                    {{session("warning")}}
                </div>
            @endif

            <form wire:submit.prevent='buatAbsensi' enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama_guru">Nama Guru</label>
                    <input type="text" class="form-control" value="{{Str::upper(Auth::user()->name)}}" disabled>
                </div>
                <div class="form-group">
                    <label for="mapel">Mengajar Mapel</label>
                    <input type="text" class="form-control" value={{Auth::user()->teacher->mapel}} disabled>
                </div>
                @if(session("error"))
                    <div class="alert alert-danger mt-3 col-lg-4" role="alert">
                        {{session("error")}}
                    </div>
                @endif
                <div class="form-group">
                    <label for="">Daftar Kelas</label>
                    <hr>
                    <div class="ml-3 overflow-auto" style="height:100px;">
                    @foreach($classes as $kelas)
                        <div class="d-block">
                            <input type="checkbox" value="{{$kelas->id}}">
                            <span class="mr-5">{{$kelas->class}}</span>
                        </div>
                    @endforeach
                    </div>
                    <hr>
                </div>
                <div class="form-group">
                    <label class="d-block">Jam Absensi</label>
                    <div wire:ignore>
                        <div class="d-sm-flexx justify-content-between">
                            <select id="sche" class="form-control" wire:model='sche'>
                                <option>Pilih Jam Absensi Dibawah</option>
                                @foreach($schedule as $sch)
                                    <option value="{{$sch->id}}" class='form-check-input'>{{$sch->dimulai}} -  {{$sch->berakhir}} WIB</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                {{-- {{ dd(date("D") ) }} --}}
                @if(date("H-i-s") > "12-30" || date("D") === "Sun")
                    <button type="submit" class="btn btn-primary" disabled>Buat</button>
                    @if(date("H-i-s") > "12-30")
                        <small class='d-block mt-2'>Melebihi Jadwal Jam Absensi Terakhir, Silahkan Buat Absensi Besok!</small>
                    @else
                        <small class='d-block mt-2'>Minggu liburr!</small>
                    @endif
                @else
                    <button type="submit" class="btn btn-primary">Buat</button>
                @endif
            </form>

            @if(session("success"))
                <div class="alert alert-success mt-3 col-lg-4" role="alert">
                    {{session("success")}}
                </div>
            @endif

        </div>
    </div>

</div>

<script>
    document.addEventListener("livewire:load", function() {
        // variabel untuk menyimpan
        let temp = [];
        // mendapatkan semua element input yang memiliki type checkbox
        const v_kelas = document.querySelectorAll("input[type=checkbox]");
        v_kelas.forEach(function(kelas) { // pertama kita looping class nya
            kelas.addEventListener("change", () => {  // lalu jika ada input class yang berubah nilainya(dicentang/ tidak jadi dicentang)
                if(temp.indexOf(kelas.value) === -1 ) // jika class nya tidak ada di dalam var temp, maka tambahkan class tsb ke var temp
                {
                    temp.push(kelas.value);
                }
                else // namun jika class nya ada di dalam var temp, maka hapus class tersebut dari var temp.
                {
                    temp.splice(temp.indexOf(kelas.value), 1);
                }
                @this.set("list_kelas", temp);
            });
        });
    })

</script>
