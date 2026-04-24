@extends('landing.app')

@section('title', 'Artikel & Wawasan Terbaru - Core Plasma')

@section('content')
<section class="section-padding bg-light-alt" style="margin-top: 80px;">
    <div class="container">
        <div class="section-header text-center">
            <p class="subtitle">WAWASAN TERBARU</p>
            <h2>Blog & <span class="text-red">Artikel Edukasi</span></h2>
            <p class="desc">Kumpulan tips, trik, dan informasi terbaru seputar dunia pendidikan dan persiapan ujian.</p>
        </div>

        <div class="article-grid">
            @foreach($articles as $article)
                <div class="article-card">
                    <div class="card-img-wrap">
                        <span class="badge-tag">{{ $article['category'] }}</span>
                        <img src="{{ $article['thumbnail'] }}" alt="{{ $article['title'] }}">
                    </div>
                    <div class="card-content">
                        <span class="date">{{ $article['date'] }}</span>
                        <h3>{{ $article['title'] }}</h3>
                        <p>{{ $article['excerpt'] }}</p>
                        <a href="{{ route('artikel.show', $article['slug']) }}" class="read-more">Baca Selengkapnya &rsaquo;</a>
                    </div>
                </div>
            @endforeach
        </div>

        @if(count($articles) === 0)
            <div class="text-center py-50">
                <p>Belum ada artikel yang tersedia saat ini.</p>
            </div>
        @endif
    </div>
</section>
@endsection
