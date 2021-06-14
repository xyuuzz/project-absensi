@section("title", "List Link Register $status")
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="d-inline-block">List Link Register {{ $status }}</h4>
            <a href="{{ route("make_link_register", ["status" => "student"]) }}" class="btn btn-sm float-right btn-success">Buat Link Register</a>
        </div>
        <div class="card-body">
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
                                {{-- <td hidden>
                                    <input type="text" value="
                                        {{
                                            $status === 'Guru' ?
                                            route('register_teacher', ['mapel' => $item->mapel, 'register_teacher' => $item->slug] ) :
                                            route('register_student', ['classes' => $item->classes->class, 'register_student' => $item->slug])
                                        }}"
                                    id="copyText" hidden>
                                </td> --}}
                                <td>
                                    {{-- wire:click="setItem( '{{ $status === 'Guru' ? $item->mapel : $item->classes->class }}', '{{ $item->slug }}' )" --}}
                                    <button class="btn btn-sm btn-primary copy-button" onclick="copyLink('{{ $status === 'Guru' ? $item->mapel : $item->classes->class }}', '{{ $item->slug }}', this)">
                                        Copy Link
                                    </button>
                                </td>
                                <td>{{ $status === "Guru" ? $item->mapel : $item->classes->class }}</td>
                                <td>{{ $item->dimulai }}</td>
                                <td>{{ $item->berakhir }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success">
                                        {{ "Berjalan" }}
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger">
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
        {{-- {{ dd(env("APP_URL")) }}}} --}}
    </div>

    <script>
        function copyLink(item1, item2, elHTML) {
            navigator.clipboard.writeText({{  }});
            elHTML.innerHTML = "Link Copied";
        }
    </script>
</div>
