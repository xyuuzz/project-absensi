@section("title", "Kelola Siswa")
<div class="container">
    <style>
        @media only screen and (max-width: 576px) {
            .mt-smm-2 {
                margin-top: 10px;
            }
            .d-sm-blockk {
                display: block;
            }
        }
    </style>
    <div class="card">
        <div class="card-header">
            <strong>Kelola Siswa</strong>
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

            <div class="d-lg-flex justify-content-between mb-3">
                <button wire:click='createView()' type="button" class="btn btn-sm btn-secondary">
                    {{$view === "index" ? "Buat Anggota Siswa" : "Lihat Daftar Siswa"}}
                </button>
                @if($view !== "link")
                    <div class="d-lg-flex justify-content-between">
                        <button wire:click='linkView()' type="button" class="btn btn-sm btn-success d-sm-blockk mt-smm-2 mr-lg-3">
                            Buat Link Pendaftaran Siswa
                        </button>
                        <button wire:click='linkView()' type="button" class="btn btn-sm btn-success d-sm-blockk mt-smm-2">
                            Daftar Link Yang Telah Dibuat
                        </button>
                    </div>
                @endif
            </div>
            @if($view === "index")
                @include("partials.index_template")
            @elseif($view === "create")
                {{-- @include ("partials.create_template") --}}
                @livewire("create-template", ["status" => "student"])
            @elseif($view === "link")
                <livewire:make-link-register/>
            @else
                @livewire("edit-template", ["status" => "student"])
            @endif
        </div>
    </div>

</div>
