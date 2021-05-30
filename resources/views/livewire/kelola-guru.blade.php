@section("title", "Kelola Guru")
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
            <strong>Kelola Guru</strong>
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

            <button wire:click='viewBuatGuru()' type="button" class="btn btn-sm btn-secondary">
                {{$view === "list_guru" ? "Buat Anggota Guru Baru" : "Lihat List Guru"}}
            </button>
            @if($view === "list_guru")
                @include("partials.index_template")
            @elseif($view === "buat_guru")
                <livewire:buat-guru/>
            @else
                @include("partials.edit_template")
            @endif
        </div>
    </div>

</div>
