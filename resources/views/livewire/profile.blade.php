@section("gelombang")
<svg class="position-absolute mt-5" style="top:25px; z-index:-99;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#F3F4F5" fill-opacity="1" d="M0,96L48,96C96,96,192,96,288,96C384,96,480,96,576,85.3C672,75,768,53,864,80C960,107,1056,181,1152,224C1248,267,1344,277,1392,282.7L1440,288L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>
@endsection

<div class="container">
    <div class="card">
        <div class="card-header bg-teal">
            <h5 class="text-center text-primary"><b>Profil Siswa</b></h5>
        </div>
        <div class="card-body form-group">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <p class="text-center">
                        <img src="{{Auth::user()->photo_profile ?? "https://apkrules.com/wp-content/uploads/2017/07/foto-profil.png"}}" alt="foto profil" class="img-fluid img-thumbnail rounded-circle" width="300px" height="200px">
                        <div class="mx-auto col-lg-6 mt-3">
                            <input type="file" class="form-control">
                            <p class="text-muted text-center mt-2">File Maksimal berukuran 2Mb</p>
                        </div>
                    </p>
                </div>
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" class="form-control" id="nama" aria-describedby="nama" value="{{Str::upper(Auth::user()->name)}}" readonly>
                  <small id="emailHelp" class="form-text text-muted"><b>Nama</b> Tidak Bisa diubah, jika ada salah penulisan silahkan hubungi admin</small>
                </div>
                <div class="form-group">
                  <label for="kelas">Kelas</label>
                  <input type="text" class="form-control" value="{{Auth::user()->student->classes->class}}" readonly>
                  <small id="emailHelp" class="form-text text-muted"><b>Kelas</b> Tidak Bisa diubah, jika ada salah penulisan silahkan hubungi admin</small>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" value="{{Auth::user()->email}}" readonly>
                  <small id="email" class="form-text text-muted"><b>Email</b> Tidak Bisa diubah, jika ada salah penulisan silahkan hubungi admin</small>
                </div>
                <div class="form-group">
                    <label for="nis">NIS</label>
                    <input id="nis" type="text" class="form-control" value="{{Auth::user()->student->nis}}" placeholder="NIS Siswa">
                </div>
                <div class="form-group">
                    <label for="nisn">NISN</label>
                    <input id="nisn" type="text" class="form-control" value="{{Auth::user()->student->nisn}}" placeholder="NISN Siswa">
                </div>
                <div class="form-group">
                    <label for="hobi">Hobi</label>
                    <input id="hobi" type="text" class="form-control" value="{{Auth::user()->student->hobi}}" placeholder="Hobi">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

@section("gelombang_footer")
<svg class="position-absolute" style="bottom:-700px; z-index: -999" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#f3f4f5" fill-opacity="1" d="M0,224L51.4,96L102.9,160L154.3,96L205.7,128L257.1,64L308.6,192L360,0L411.4,256L462.9,256L514.3,288L565.7,160L617.1,160L668.6,256L720,32L771.4,256L822.9,96L874.3,192L925.7,0L977.1,256L1028.6,0L1080,32L1131.4,224L1182.9,256L1234.3,288L1285.7,256L1337.1,160L1388.6,256L1440,288L1440,320L1388.6,320L1337.1,320L1285.7,320L1234.3,320L1182.9,320L1131.4,320L1080,320L1028.6,320L977.1,320L925.7,320L874.3,320L822.9,320L771.4,320L720,320L668.6,320L617.1,320L565.7,320L514.3,320L462.9,320L411.4,320L360,320L308.6,320L257.1,320L205.7,320L154.3,320L102.9,320L51.4,320L0,320Z"></path></svg>
@endsection
