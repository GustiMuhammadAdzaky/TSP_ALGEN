<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <title>{{ $title }}</title>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


</head>
<body>
    
    <header>
        {{-- navbar --}}
        <nav>
            <div class="navbar">
                <div class="nav-content">
                    <a class="nav-item" href=""><span style="font-size: 18px; font-weight:bold;">{{ config('app.name') }}</span></a>
                </div>
                <div class="nav-content">
                    {{-- <a class="nav-item" href=""><span>Home</span></a>
                    <a class="nav-item" href=""><span>Destinasi</span></a> --}}
                </div>
                <div class="nav-content">
                    @auth
                        <div class="dropdown">
                            <span style="cursor: pointer;">{{ Auth::user()->name }}</span>
                            <div class="dropdown-content">
                                <a href="{{ route('dashboard') }}">
                                    <button class="btn">dashboard</button>
                                </a>
                                
                                <form style="margin-top: 0.5rem" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="btn" type="submit">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('login') }}">
                            <button type="submit" class="btn">Login</button>
                        </form>
                        
                    @endauth
                </div>
            </div>
        </nav>
        {{-- navbar --}}

        {{-- jumbotron --}}
        <div class="jumbotron">
            <div class="container">
                <div class="row">
                    <div class="col kiri">
                        <h1 style="color: var(--second);">Hallo Kader Ikatan Sepertinya kegiatan kamu sudah selesai !?</h1>
                        <h3 style="color: white;">Jika kamu ingin berpergian silahkan gunakan web ini teman-teman kader Nasional agar perjalanan mu menjadi lebih berkesan dan menyenangkan dengan tujuan bebas pilihan </h3>
                        @auth
                        <form action="{{ route('dashboard') }}">
                            <button style="margin-top: 1rem;" type="submit" class="btn">Dashboard</button>
                        </form>
                        @else
                        <form action="{{ route('register') }}">
                            <button style="margin-top: 1rem;" type="submit" class="btn">Register</button>
                        </form>
                        @endauth
                    </div>
                    <div class="col kanan">
                        <img src="{{ asset('images/image.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
        {{-- jumbotron --}}
    </header>

    <div class="cards">
        <div class="container">
            <div class="promote-card">
                <img src="{{ asset('images/logo_um.png') }}" style="width: 8rem" alt="">
            </div>
        </div>
    </div>


    <main>
        <div class="container">
            <div class="destinasi">
                <div class="title" style="margin-top: 1.5rem;">
                    <h1>Destinasi</h1>
                </div>
                <div class="content">
                    @foreach ($destinasi as $ds)    
                    <div class="card">
                        <img src="{{ asset('storage/images/destinations/' . $ds->img) }}" alt="">
                        <div class="vektor"></div>
                        <span style="font-weight:bold; font-size: 1.5rem; position: absolute; margin-top:-2.2rem; margin-left: 0.5rem; color:#004165">{{ $ds->name }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
    


    <footer>
        <div class="container">
            <div class="footer">
                <div class="top-footer">
                    <img src="{{ asset('images/pontianak.png') }}" style="width:100%; height:100%;" alt="">
                </div>
                <div class="mid-footer" style="margin: 3rem">
                    <div class="left-mid-footer">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                        Repellendus veritatis doloribus molestiae iste aperiam error veniam 
                        quibusdam reprehenderit! Aut, nemo. Lorem ipsum dolor sit amet. lorem20
                    </div>
                    <div class="right-mid-footer">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
                        Animi necessitatibus, similique officia nesciunt maxime ipsum assumenda 
                        laboriosam qui eveniet cum? Lorem ipsum dolor sit amet.
                    </div>
                </div>
            </div>
        </div>
        <div class="bot-footer">
            <div class="child-bot-footer" style="margin-left:2rem">
                {{ config('app.name') }}
            </div>
            <div class="child-bot-footer">
                <span>© Nama Panjang daffa All Right Reserved 2024</span>
            </div>
            <div class="child-bot-footer" style="margin-right:2rem">
                <a href=""><i class="fab fa-instagram"></i></a>
                <a href=""><i class="fab fa-facebook-f"></i></a>
                <a href=""><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </footer>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navbar = document.querySelector("nav");
            window.addEventListener("scroll", () => {
                if (window.scrollY > 50) {
                    navbar.classList.add("scrolled");
                } else {
                    navbar.classList.remove("scrolled");
                }
            });
        });
    </script>
    
    

</body>
</html>