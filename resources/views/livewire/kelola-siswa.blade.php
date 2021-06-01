@section("title", "Kelola Siswa")
<div class="container">
    <style>
        @media only screen and (max-width: 576px) {
            .mt-smm-2 {
                margin-top: 10px;
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

            <button wire:click='createView()' type="button" class="btn btn-sm btn-secondary">
                {{$view === "index" ? "Buat Anggota Siswa" : "Lihat Daftar Siswa"}}
            </button>
            @if($view === "index")
                @include("partials.index_template")
            @elseif($view === "create")
                {{-- @include ("partials.create_template") --}}
                @livewire("create-template", ["status" => "student"])
            @else
                @livewire("edit-template", ["status" => "student"])
            @endif
        </div>
    </div>

</div>
