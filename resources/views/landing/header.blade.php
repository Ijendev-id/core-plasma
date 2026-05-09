<header class="header-wrapper">
    <nav class="navbar container">
        <a href="{{ route('home') }}" class="logo">Core Plasma</a>

        <ul class="nav-links">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ route('artikel') }}" class="{{ request()->routeIs('artikel') ? 'active' : '' }}">Artikel</a></li>
            <li><a href="{{ route('paket') }}" class="{{ request()->routeIs('paket') ? 'active' : '' }}">Paket Belajar</a></li>
            <li><a href="{{ route('keunggulan') }}" class="{{ request()->routeIs('keunggulan') ? 'active' : '' }}">Keunggulan</a></li>
            <li><a href="{{ route('testimoni') }}" class="{{ request()->routeIs('testimoni') ? 'active' : '' }}">Testimoni</a></li>
            <li><a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'active' : '' }}">FAQ</a></li>
        </ul>

        <div class="nav-buttons">
            <a href="{{ route('member.login') }}" class="btn-masuk">Masuk</a>
            <a href="{{ route('member.register') }}" class="btn-daftar">Daftar</a>
        </div>
    </nav>
</header>
