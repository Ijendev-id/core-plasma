@extends('landing.app')

@section('content')

    <section class="article-hero">
        <div class="container">
            <nav class="article-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="bc-sep">/</span>
                <a href="{{ route('artikel') }}">Artikel</a>
                <span class="bc-sep">/</span>
                <span class="bc-current">{{ $article['category'] }}</span>
            </nav>

            <div class="article-hero-content">
                <span class="badge-tag {{ $article['tag_class'] }}">{{ $article['category'] }}</span>
                <h1 class="article-title">{{ $article['title'] }}</h1>
                <p class="article-excerpt">{{ $article['excerpt'] }}</p>
                <div class="article-meta">
                    <div class="meta-item">
                        <span class="meta-icon">&#128197;</span>
                        <span>{{ $article['date'] }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-icon">&#9201;</span>
                        <span>{{ $article['reading_time'] }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-icon">&#128100;</span>
                        <span>{{ $article['author'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="article-cover">
        <div class="container">
            <div class="article-cover-wrap">
                <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}">
            </div>
        </div>
    </section>

    <section class="article-body-section">
        <div class="container article-layout">
            <article class="article-content">
                @foreach($article['content'] as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach

                <div class="article-tip-box">
                    <h4>&#128161; Poin Penting</h4>
                    <ul>
                        @foreach($article['tips'] as $tip)
                            <li>{{ $tip }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="article-author-box">
                    <span class="article-author-avatar">{{ mb_substr($article['author'], 0, 1) }}</span>
                    <div class="article-author-info">
                        <h5>{{ $article['author'] }}</h5>
                        <span>Mentor &amp; kontributor di Core Plasma</span>
                    </div>
                </div>

                <p class="article-closing">Tertarik memperdalam strategi belajar ini? Bergabung bersama <strong>Core Plasma</strong> dan akses try out eksklusif, analisis skor otomatis, serta mentoring langsung dari Super Teacher.</p>

                <div class="article-cta">
                    <a href="{{ route('member.register') }}" class="btn-primary">Mulai Latihan Sekarang</a>
                    <a href="{{ route('artikel') }}" class="btn-secondary-outline">&larr; Kembali ke Daftar Artikel</a>
                </div>
            </article>

            <aside class="article-sidebar">
                <div class="sidebar-card share-card">
                    <h5>Bagikan Artikel</h5>
                    <p>Yuk, bantu temanmu yang juga sedang berjuang!</p>
                    <div class="share-buttons">
                        <a href="#" class="share-btn share-wa" aria-label="WhatsApp">WhatsApp</a>
                        <a href="#" class="share-btn share-fb" aria-label="Facebook">Facebook</a>
                        <a href="#" class="share-btn share-x" aria-label="X / Twitter">Twitter</a>
                    </div>
                </div>

                <div class="sidebar-card highlight-card">
                    <h5>Kenapa Core Plasma?</h5>
                    <ul class="highlight-list">
                        <li>Try out adaptif setiap minggu</li>
                        <li>Analisis skor otomatis</li>
                        <li>Mentoring langsung dengan expert</li>
                        <li>Bank soal 10.000+ butir</li>
                    </ul>
                </div>
            </aside>
        </div>
    </section>

    <section class="section-padding bg-light-alt" id="related-articles">
        <div class="container">
            <div class="section-header flex-header">
                <div>
                    <p class="subtitle">BACA JUGA</p>
                    <h2>Artikel <span class="text-red">Lainnya</span></h2>
                </div>
                <a href="{{ route('artikel') }}" class="view-all">Lihat Semua &rarr;</a>
            </div>

            <div class="article-grid">
                @foreach($related as $item)
                    <a href="{{ route('artikel.show', ['slug' => $item['slug']]) }}" class="article-card">
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
            </div>
        </div>
    </section>

@endsection