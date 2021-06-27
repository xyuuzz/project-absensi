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

            <div class="d-lg-flex justify-content-between mb-2">
                @if($view === "index")
                    <a class="btn btn-sm btn-success d-sm-blockk mt-smm-2 mr-lg-3" href="{{ route("make_link_register", ["status" => "student"]) }}">Buat Link Pendaftaran Siswa</a>
                    <a class="btn btn-sm btn-success d-sm-blockk mt-smm-2 mr-lg-3" href="{{ route("list_link_register", ["status" => "student"]) }}">List Link Pendaftaran Siswa</a>
                @else
                    <button wire:click='indexView()' type="button" class="btn btn-sm btn-success d-sm-blockk mt-smm-2 mr-lg-3">
                        Kembali
                    </button>
                @endif
            </div>
            @if($view === "index")
                @include("partials.index_template")
            @else
                @livewire("edit-template", ["status" => "student"])
            @endif
        </div>
    </div>

</div>
