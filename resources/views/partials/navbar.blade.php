    <style>
        /* Core */
        nav{
        display:flex;
        background-color: white;
        justify-content: space-around;
        padding:20px 0;
        color:rgb(255, 254, 254);
        align-items: center;
        height: 100%;
        }
        nav.logo{
        letter-spacing: 3px;
        }
        nav ul{
        display:flex;
        list-style: none;
        width:40%;
        justify-content: space-between;
        margin-top: 10px;
        }
        nav ul li a {
        color:black;
        text-decoration: none;
        font-size: 1em;
        display: inline-block;
        padding-bottom: 5px;
        }
        nav ul li a:hover {
            text-decoration: none;
            /* font-size: 20px; */
            color: black;
        }
        nav ul li a:hover:after {
            right: 0;
        }
        nav ul.slide{
            transform: translateX(0);
            /* display: flex; */
        }
        /* Hamburger */
        .menu-bars{
        display:none;
        flex-direction: column;
        height:20px;
        justify-content: space-between;
        position:relative;
        z-index: 1001;
        }
        .menu-bars input{
        position: absolute;
        width:40px;
        height:28px;
        left:-5px;
        top:-3px;
        opacity: 0;
        cursor:pointer;
        }
        .menu-bars span{
        display:block;
        width:28px;
        height:3px;
        background-color: black;
        border-radius: 3px;
        transition: all 0.3s;
        }
        .menu-bars span:nth-child(2){
        transform-origin: 0 0 ;
        }
        .menu-bars span:nth-child(4){
        transform-origin: 0 100% ;
        }
        .menu-bars input:checked ~ span:nth-child(2){
        background-color: black;
        transform: rotate(45deg) translate(-1px, -1px);
        }
        .menu-bars input:checked ~ span:nth-child(4){
        background-color: black;
        transform: rotate(-45deg) translate(-1px,0);
        }
        .menu-bars input:checked ~ span:nth-child(3){
        opacity: 0;
        transform: scale(0);
        }
        .jamku {
            font-size: 25px;
            margin-left: 30px;
        }
        @media (min-width: 992px){
        .animatedBorder {
            position: relative;
        }
        .animatedBorder::after {
            content: '';
            position: absolute;
            border-bottom: 3px solid black;
            bottom: 0;
            left: 0;
            right: 100%;
            transition: all 500ms;
            text-decoration: none;
            font-size: 20px;
            color: black;
        }
        }
        @media (min-width: 576px) {
        .d-mdd-none {
            display: none;
        }
        }
        @media only screen and (max-width: 768px){
        nav ul{
            width:50%;
        }
        }
        /* Mobile Menu */
        @media only screen and (max-width: 576px){
        .menu-bars{
            display:flex;
        }
        nav ul{
            position:absolute;
            right:0;
            top:0;
            width:80%;
            height:105vh;
            justify-content: space-evenly;
            flex-direction: column;
            align-items: center;
            background-color: white;
            z-index: 1000;
            transform: translateX(100%);
            transition: all 1s;
            position:fixed;
            top: 0;
            /* display: none; */
            margin-top: -20px;
        }
        nav .logo img {
            margin-right: 270px;
        }
        .jamku {
            font-size: 15px;
            margin-left: 0px;
        }
        nav ul li a{
            padding: 20px 100px;
        }
        nav ul li a:hover {
            background-color: black;
            color: white;
            width: 100%;
            text-decoration: none;
            font-size: 20px;
            padding: 20px 40px;
            display: inline-block;
            /* border: 10px solid ; */
            border-radius: 12px;
        }
        }
    </style>

    <nav>
        <div class="logo">
          <img src="https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2F1.bp.blogspot.com%2F-TVbL49YNck4%2FVXpkrY7Ac1I%2FAAAAAAAAAHs%2Foas2IDk6aGc%2Fs1600%2FLogo-SMK.jpg&f=1&nofb=1" alt="logo sekolah" width="50px">
        </div>
        <ul>
            @auth
                <li class="lijam d-lg-none text-dark d-mdd-none">
                    <p class="float-left ml-3">Pukul
                        <span id="jam1"></span> :
                        <span id="menit1"></span> :
                        <span id="detik1"></span>
                    </p>
                </li>
                <li><a class="animatedBorder" href="{{route("home")}}">Home</a></li>
                @if(Auth::user()->role === "student")
                    <li><a class="animatedBorder" href="{{route("profile", ["user" => Auth::user()->name])}}">Profile</a></li>
                    <li><a class="animatedBorder" href="{{route("absensi")}}">Absensi</a></li>
                @elseif(Auth::user()->role === "teacher")
                    <li><a class="animatedBorder" href="{{route("buat_absensi")}}">Buat Absensi</a></li>
                    <li><a class="animatedBorder" href="{{route("list_absensi")}}">List Absensi</a></li>
                @else
                    <li><a class="animatedBorder" href="{{route("kelola_guru")}}">Kelola Guru</a></li>
                    <li><a class="animatedBorder" href="{{route("kelola_siswa")}}">Kelola Siswa</a></li>
                @endif
                <li>
                    <a class="animatedBorder" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endauth
        </ul>
        <div class="menu-bars">
          <input type="checkbox">
          <span></span>
          <span></span>
          <span></span>
        </div>
    </nav>

    <script>
        const menuToggle= document.querySelector(".menu-bars");
        const nav = document.querySelector("nav ul");
        const list_li = document.getElementsByTagName("li");

        menuToggle.addEventListener("click", () => {
            nav.classList.toggle("slide");
        });

        window.setTimeout("waktu2()", 1000);
        function waktu2() {
            var waktu2 = new Date();
            setTimeout("waktu2()", 1000);
            document.getElementById("jam1").innerHTML = waktu2.getHours();
            document.getElementById("menit1").innerHTML = waktu2.getMinutes();
            document.getElementById("detik1").innerHTML = waktu2.getSeconds();
        }
    </script>
