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
                    <div class="ml-3 col-lg-4 justify-content-center">
                    @foreach($classes as $kelas)
                        <div class="d-inline-block">
                            <input class="form-check-input" type="checkbox" value="{{$kelas->id}}">
                            <span class="mr-5">{{$kelas->class}}</span>
                        </div>
                    @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label class="d-block">Jam Absensi</label>
                    <div wire:ignore>
                        <div class="d-sm-flexx justify-content-between">
                            <select id="sche">
                                <option>Pilih Jam Absensi Dibawah</option>
                                @foreach($schedule as $sch)
                                <option value="{{$sch->id}}" class='form-check-input'>{{$sch->dimulai}} -  {{$sch->berakhir}} WIB</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                {{-- <b><p id="list_kelas">Kelas : </p></b> --}}
                <hr>
                <button type="submit" class="btn btn-primary">Buat</button>
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
    // const desk_kelas = document.getElementById("list_kelas");
    // let temp_k = [];
    document.addEventListener("livewire:load", function() {
        const sche = document.getElementById("sche");
        let temp = [];
        const v_kelas = document.querySelectorAll("input.form-check-input");

        v_kelas.forEach(function(kelas) {
            kelas.addEventListener("change", () => {
                if(temp.indexOf(kelas.value) === -1 )
                {
                    temp.push(kelas.value);
                    // temp_k.push(kelas.nextElementSibling.innerHTML);
                } else
                {
                    temp.splice(temp.indexOf(kelas.value), 1);
                    // temp_k.splice(temp_k.indexOf(kelas.value), 1);
                }
                // desk_kelas.innerHTML = `Kelas :  ${temp_k.join(", ")}`
            });
        });

        document.getElementsByTagName("button")[0].addEventListener("click", () => {
            @this.set("list_kelas", temp);
            @this.set("sche", sche.value);
        });
    })

</script>
