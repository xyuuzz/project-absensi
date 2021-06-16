@section("title", "List Link Register $status")
<div class="container">
    <div class="card">
        <div class="card-header">
            <a href="{{ route("kelola_siswa") }}" class="btn btn-sm btn-secondary">List Siswa</a>
            <a href="{{ route("make_link_register", ["status" => "student"]) }}" class="btn btn-sm float-right btn-success">Buat Link Register</a>
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

            <h4 class="d-inline-block">List Link Register {{ $status }}</h4>
            {{-- <button class="btn btn-sm btn-outline-danger float-right">Hapus Link 3 Hari Lalu</button> --}}
            <div class="table-responsive mt-3">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Link Pendaftaran</th>
                            <th scope="col">{{ $status === "Guru" ? "Mapel" : "Kelas" }}</th>
                            <th scope="col">Dimulai</th>
                            <th scope="col">Berakhir</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($model as $item)
                            <tr>
                                <td hidden>
                                    <input type="text" value="
                                        {{
                                            $status === 'Guru' ?
                                            route('register_teacher', ['mapel' => $item->mapel, 'register_teacher' => $item->slug] ) :
                                            route('register_student', ['register_student' => $item->slug])
                                        }}"
                                    class="copyText" hidden>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary copy-button">
                                        Copy Link
                                    </button>
                                </td>
                                <td>{{ $status === "Guru" ? $item->mapel : $item->classes->class }}</td>
                                <td>{{ Str::limit($item->dimulai, 10, "") }}</td>
                                <td>{{ Str::limit($item->berakhir, 10, "") }}</td>
                                <td>
                                    @if($item->dimulai > date("Y-m-d H:i:s"))
                                        <span class="btn btn-sm btn-warning">
                                            Belum Dimulai
                                        </span>
                                    @elseif($item->dimulai < date("Y-m-d H:i:s") && $item->berakhir > date("Y-m-d H:i:s"))
                                        <span class="btn btn-sm btn-success">
                                            Sedang Berlangsung
                                        </span>
                                        @else
                                            <span class="btn btn-sm btn-warning">
                                                Ditutup
                                            </span>
                                        @endif
                                </td>
                                <td>
                                    <button wire:click='deleteData({{ $item->id }})' class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center"><h4>Tidak Ada Data!</h4></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const copy_button = document.querySelectorAll(".copy-button");
        copy_button.forEach(e => {
            e.addEventListener("click", () => {
                navigator.clipboard.writeText(e.parentElement.previousElementSibling.firstElementChild.value); // cari parent element dari e/tombol yang ditekan, lalu cari element kembar sebelumnya, lalu cari element anak dan dapatkan valuenya.
                e.innerHTML = "Link Copied";
            });
        });
    </script>
</div>
