@extends('landing.app')

@section('title', $article['title'] . ' - Core Plasma')

@section('content')
<article class="article-detail" style="margin-top: 80px; padding-bottom: 80px;">
    <div class="container-small">
        <div class="article-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a> &rsaquo; 
            <a href="{{ route('artikel') }}">Artikel</a> &rsaquo; 
            <span>{{ $article['category'] }}</span>
        </div>

        <header class="article-header">
            <span class="badge-tag">{{ $article['category'] }}</span>
            <h1 class="article-title">{{ $article['title'] }}</h1>
            <div class="article-meta">
                <span class="meta-item">Oleh <strong>{{ $article['author'] }}</strong></span>
                <span class="meta-sep">|</span>
                <span class="meta-item">{{ $article['date'] }}</span>
            </div>
        </header>

        <div class="article-featured-image">
            <img src="{{ $article['thumbnail'] }}" alt="{{ $article['title'] }}" class="img-radius shadow-lg">
        </div>

        <div class="article-body">
            {!! $article['content'] !!}
        </div>

        <footer class="article-footer">
            <div class="share-box">
                <p>Bagikan artikel ini:</p>
                <div class="share-links">
                    <a href="#" class="share-icon">WA</a>
                    <a href="#" class="share-icon">FB</a>
                    <a href="#" class="share-icon">TW</a>
                </div>
            </div>
            
            <div class="back-to-blog">
                <a href="{{ route('artikel') }}" class="btn-outline">&larr; Kembali ke Blog</a>
            </div>
        </footer>
    </div>
</article>

<style>
    .container-small {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .article-breadcrumb {
        margin-bottom: 20px;
        font-size: 0.85rem;
        color: #727783;
    }
    .article-breadcrumb a {
        color: #d40f22;
        text-decoration: none;
    }
    .article-header {
        margin-bottom: 30px;
    }
    .article-title {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin: 15px 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .article-meta {
        font-size: 0.9rem;
        color: #727783;
    }
    .meta-sep {
        margin: 0 10px;
    }
    .article-featured-image {
        margin-bottom: 40px;
    }
    .article-featured-image img {
        width: 100%;
        height: auto;
        display: block;
    }
    .article-body {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
    }
    .article-body p {
        margin-bottom: 20px;
    }
    .article-body strong {
        font-weight: 700;
        color: #000;
    }
    .article-footer {
        margin-top: 50px;
        padding-top: 30px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    .share-box p {
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .share-links {
        display: flex;
        gap: 10px;
    }
    .share-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f6f7f8;
        color: #333;
        font-size: 0.8rem;
        font-weight: bold;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .share-icon:hover {
        background: #d40f22;
        color: #fff;
    }
    @media (max-width: 768px) {
        .article-title {
            font-size: 1.8rem;
        }
    }
</style>
@endsection
