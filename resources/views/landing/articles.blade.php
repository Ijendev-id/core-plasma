@extends('landing.app')

@section('content')

    <section class="page-hero">
        <div class="container">
            <nav class="article-breadcrumb" aria-label="Breadcrumb" style="justify-content: center;">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="bc-sep">/</span>
                <span class="bc-current">Artikel</span>
            </nav>
            <p class="subtitle">WAWASAN TERBARU</p>
            <h1>Artikel <span class="text-red">Core Plasma</span></h1>
            <p class="desc">Pelajari strategi, tips, dan trik dari para mentor untuk membantumu meraih skor tertinggi di seleksi PTN, Kedinasan, BUMN, dan CPNS/PPPK.</p>
        </div>
    </section>

    <section class="section-padding bg-light-alt" style="padding-top: 40px;">
        <div class="container">
            <div class="articles-toolbar">
                <div class="count">
                    Menampilkan <strong id="articleVisibleCount">{{ count($articles) }}</strong> dari <strong>{{ count($articles) }}</strong> artikel
                </div>
                <div class="articles-search">
                    <input type="search" id="articleSearch" placeholder="Cari judul atau kategori..." aria-label="Cari artikel">
                </div>
            </div>

            <div class="article-categories" id="articleCategories">
                <button type="button" class="chip is-active" data-filter="all">Semua</button>
                @php $cats = array_unique(array_column($articles, 'category')); @endphp
                @foreach($cats as $cat)
                    <button type="button" class="chip" data-filter="{{ strtolower($cat) }}">{{ $cat }}</button>
                @endforeach
            </div>

            <div class="article-grid article-grid-wide" id="articleGrid">
                @foreach($articles as $item)
                    <a href="{{ route('artikel.show', ['slug' => $item['slug']]) }}" class="article-card" data-title="{{ strtolower($item['title']) }}" data-category="{{ strtolower($item['category']) }}">
                        <div class="card-img-wrap">
                            <span class="badge-tag {{ $item['tag_class'] }}">{{ $item['category'] }}</span>
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                        </div>
                        <div class="card-content">
                            <span class="date">{{ $item['date'] }}</span>
                            <h3>{{ $item['title'] }}</h3>
                            <p>{{ $item['excerpt'] }}</p>
                            <span class="read-more">Baca Selengkapnya &rsaquo;</span>
                        </div>
                    </a>
                @endforeach

                <div id="articleEmptyState" style="display:none; grid-column: 1/-1;">
                    <strong>Tidak ditemukan.</strong> Coba kata kunci lain atau pilih kategori berbeda.
                </div>
            </div>
        </div>
    </section>

    <script>
        (function () {
            var input = document.getElementById('articleSearch');
            var chips = document.querySelectorAll('#articleCategories .chip');
            var cards = document.querySelectorAll('#articleGrid .article-card');
            var empty = document.getElementById('articleEmptyState');
            var count = document.getElementById('articleVisibleCount');
            var total = cards.length;

            var state = { q: '', cat: 'all' };

            function applyFilter() {
                var visible = 0;
                cards.forEach(function (c) {
                    var title = c.getAttribute('data-title');
                    var cat = c.getAttribute('data-category');
                    var matchQ = state.q === '' || title.indexOf(state.q) !== -1 || cat.indexOf(state.q) !== -1;
                    var matchCat = state.cat === 'all' || cat === state.cat;
                    var show = matchQ && matchCat;
                    c.style.display = show ? '' : 'none';
                    if (show) visible++;
                });
                empty.style.display = visible === 0 ? 'block' : 'none';
                if (count) count.textContent = visible;
            }

            if (input) {
                input.addEventListener('input', function () {
                    state.q = input.value.trim().toLowerCase();
                    applyFilter();
                });
            }

            chips.forEach(function (chip) {
                chip.addEventListener('click', function () {
                    chips.forEach(function (c) { c.classList.remove('is-active'); });
                    chip.classList.add('is-active');
                    state.cat = chip.getAttribute('data-filter');
                    applyFilter();
                });
            });
        })();
    </script>

@endsection