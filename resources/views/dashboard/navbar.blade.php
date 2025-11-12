<!-- ================== MOBILE MENU ================== -->
<div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close">
            <span class="icofont-close js-menu-toggle"></span>
        </div>
    </div>
    <div class="site-mobile-menu-body"></div>
</div>

<!-- ================== MAIN NAVBAR ================== -->
<nav class="site-nav mt-3">
    <div class="container">

        <div class="site-navigation">
            <div class="row align-items-center">

                <!-- LOGO -->
                <div class="col-6 col-lg-3">
                    <a href="/home" class="logo m-0 float-start">RupaRasa Sulawesi</a>
                </div>

                <!-- MENU TENGAH -->
                <div class="col-lg-6 d-none d-lg-inline-block text-center nav-center-wrap">
                    <ul class="js-clone-nav text-center site-menu p-0 m-0">

                        <!-- MENU HOME -->
                        <li class="active"><a href="/home">Home</a></li>

                        <!-- MENU EKSPLORASI (ganti dari Budaya) -->
                        <li class="has-children">
                            <a href="#">Eksplorasi</a>
                            <ul class="dropdown">
                                <li><a href="{{ route('user.rupa') }}">Rupa</a></li>
                                <li><a href="{{ route('rasa.index') }}">Rasa</a></li>
                                <li><a href="{{ route('cerita.userIndex') }}">Cerita</a></li>
                                <li><a href="{{ route('agenda.budaya') }}">Agenda Budaya</a></li>
                            </ul>
                        </li>



                        <!-- MENU PUSTAKA BUDAYA DENGAN DROPDOWN -->
                        <li class="has-children">
                            <a href="#">Pustaka Budaya</a>
                            <ul class="dropdown">
                                <li><a href="{{ route('user.video.index') }}">Video dokumenter</a></li>
                                <li><a href="{{ route('user.artikel.index') }}">Artikel</a></li>
                                <li><a href="{{ route('user.buku.index') }}">Buku</a></li>
                            </ul>
                        </li>

                        <!-- MENU MARKETPLACE -->
                        <li><a href="{{ route('toko.index') }}">Marketplace</a></li>

                        <!-- MENU PROFIL -->
                        <li><a href="{{ route('profil') }}">Profil</a></li>
                    </ul>
                </div>

                <!-- MENU LOGIN DAN BURGER ICON -->
                <div class="col-6 col-lg-3 text-lg-end">
                    <ul class="js-clone-nav d-none d-lg-inline-block text-end site-menu">
                        @guest
                            <!-- Kalau belum login -->
                            <li class="cta-button"><a href="{{ route('login') }}">Login</a></li>
                        @endguest

                        @auth
                            <!-- Kalau sudah login -->
                             <li><span>Halo, {{ Auth::user()->name }}</span></li>
                            <li class="cta-button"><a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a></li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endauth
                    </ul>


                    <!-- BURGER UNTUK MOBILE -->
                    <a href="#"
                        class="burger ms-auto float-end site-menu-toggle js-menu-toggle d-inline-block d-lg-none light"
                        data-toggle="collapse" data-target="#main-navbar">
                        <span></span>
                    </a>
                </div>

            </div>
        </div>

    </div>
</nav>