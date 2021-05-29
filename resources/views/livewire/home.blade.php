@section("gelombang")
<svg class="position-absolute mt-5" style="top:25px; z-index:-99;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#a2d9ff" fill-opacity="1" d="M0,256L48,240C96,224,192,192,288,154.7C384,117,480,75,576,58.7C672,43,768,53,864,96C960,139,1056,213,1152,250.7C1248,288,1344,288,1392,288L1440,288L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>
@endsection
@section("title", "Home")

<div class="container">
    <div class="row jamku font-weight-bolder">
    <div class="col-11" style="z-index:100;">
        <p class="float-left ml-3">
            {{strftime('%A', $date->getTimestamp())}} &middot;
            Pukul
            <span id="jam"></span> :
            <span id="menit"></span> :
            <span id="detik"></span>
        </p>
    </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-11">
                            <p><b>
                                <span>Halo </span>
                                <span style="font-size: 20px; color: blue;">{{Str::upper(Auth::user()->name)}}</span><br>
                                <span>Selamat Datang,</span>
                                <br>
                                <span>Semoga Harimu Menyenangkan</span>
                            </b></p>
                            <p>Kata Kata Motivasi Hari Ini : </p>
                            <p class="font-italic text-center">
                                <b>{!!$quotes[rand(0, count($this->quotes)-1)]!!}</b>
                            </p>
                            <p class="text-center">
                                <img src="https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fsmkvisiglobal.sch.id%2Fmedia_library%2Falbums%2F18f137ed67d4bd6ca81abcd0cf841d66.png&f=1&nofb=1" alt="smkbisa" class="img-fluid mt-2">
                            </p>
                        </div>
                    </div>
                </div>
                <svg style="margin-top: -40px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#e7008a" fill-opacity="1" d="M0,128L12.6,149.3C25.3,171,51,213,76,240C101.1,267,126,277,152,272C176.8,267,202,245,227,224C252.6,203,278,181,303,165.3C328.4,149,354,139,379,149.3C404.2,160,429,192,455,202.7C480,213,505,203,531,170.7C555.8,139,581,85,606,101.3C631.6,117,657,203,682,234.7C707.4,267,733,245,758,213.3C783.2,181,808,139,834,106.7C858.9,75,884,53,909,69.3C934.7,85,960,139,985,170.7C1010.5,203,1036,213,1061,208C1086.3,203,1112,181,1137,186.7C1162.1,192,1187,224,1213,218.7C1237.9,213,1263,171,1288,149.3C1313.7,128,1339,128,1364,133.3C1389.5,139,1415,149,1427,154.7L1440,160L1440,320L1427.4,320C1414.7,320,1389,320,1364,320C1338.9,320,1314,320,1288,320C1263.2,320,1238,320,1213,320C1187.4,320,1162,320,1137,320C1111.6,320,1086,320,1061,320C1035.8,320,1011,320,985,320C960,320,935,320,909,320C884.2,320,859,320,834,320C808.4,320,783,320,758,320C732.6,320,707,320,682,320C656.8,320,632,320,606,320C581.1,320,556,320,531,320C505.3,320,480,320,455,320C429.5,320,404,320,379,320C353.7,320,328,320,303,320C277.9,320,253,320,227,320C202.1,320,177,320,152,320C126.3,320,101,320,76,320C50.5,320,25,320,13,320L0,320Z"></path></svg>
            </div>
        </div>
    </div>

    @if(request()->routeIs("home"))
        <script>
            window.addEventListener("livewire:load", function() {
                const menuToggle2= document.querySelector(".menu-bars");
                const jam = document.querySelector(".jamku");

                menuToggle2.addEventListener("click", () => {
                    if(jam !== null) {
                        jam.classList.toggle("d-none");
                    }
                });
            });


            window.setTimeout("waktu1()", 1000);
            function waktu1() {
                var waktu1 = new Date();
                setTimeout("waktu1()", 1000);
                if(document.getElementById("jam") && document.getElementById("menit") && document.getElementById("detik"))
                {
                    document.getElementById("jam").innerHTML = waktu1.getHours();
                    document.getElementById("menit").innerHTML = waktu1.getMinutes();
                    document.getElementById("detik").innerHTML = waktu1.getSeconds();
                }
            }
        </script>
    @endif
</div>
