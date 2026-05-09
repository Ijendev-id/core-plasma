@extends('portal.layout')

@section('title', 'Paket Try Out')

@section('content')
    <section class="max-w-5xl">
        <div class="flex items-end justify-between gap-6">
            <div>
                <h1 class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold">Try Out Saya</h1>
                <p class="mt-2 text-sm font-medium text-[#727783]">Latihan penalaran dengan bank soal yang sudah disiapkan.</p>
            </div>
            <div class="hidden -space-x-2 md:flex">
                <span class="size-8 rounded-full border-2 border-white bg-[#e2e8f0]"></span>
                <span class="size-8 rounded-full border-2 border-white bg-[#ffd12e]"></span>
                <span class="size-8 rounded-full border-2 border-white bg-[#d40f22]"></span>
            </div>
        </div>

        <div class="mt-8 grid gap-5 md:grid-cols-3">
            @foreach ($packages as $package)
                <article class="rounded-2xl bg-white p-5 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <div class="flex items-center justify-between">
                        <span class="rounded-full bg-[#fff1d9] px-3 py-1 text-[10px] font-bold text-[#984800]">{{ $package['category'] }}</span>
                        <span class="text-[10px] font-bold text-[#727783]">{{ $package['duration'] }}</span>
                    </div>
                    <h2 class="mt-5 min-h-[56px] font-['Plus_Jakarta_Sans'] text-lg font-bold leading-7">{{ $package['name'] }}</h2>
                    <p class="mt-3 text-xs font-semibold text-[#727783]">{{ $package['question_count'] }} soal tryout premium</p>
                    <div class="mt-4 h-2 overflow-hidden rounded-full bg-[#eae7e7]">
                        <div class="h-full rounded-full bg-[#d40f22]" style="width: {{ $package['progress'] }}%"></div>
                    </div>
                    <div class="mt-5 flex items-center justify-between">
                        <span class="text-sm font-extrabold text-[#00407f]">{{ $package['price'] }}</span>
                        <a href="{{ route('tryouts.play', $package['slug']) }}" class="rounded-xl bg-[#a80606] px-4 py-2 text-xs font-bold text-white">Mulai Latihan</a>
                    </div>
                </article>
            @endforeach
        </div>

        <section class="mt-8 overflow-hidden rounded-3xl bg-gradient-to-r from-[#a80606] to-[#d31325] p-8 text-white shadow-[0_20px_50px_rgba(168,6,6,0.18)]">
            <h2 class="font-['Plus_Jakarta_Sans'] text-2xl font-bold">Butuh Konsultasi Strategi Belajar?</h2>
            <p class="mt-3 max-w-xl text-sm leading-6 text-white/80">Bingung mulai dari mana? Konsultasikan targetmu dan susun rencana belajar yang realistis.</p>
            <button class="mt-5 rounded-xl bg-[#ffd12e] px-5 py-3 text-sm font-bold text-[#311300]">Jadwalkan</button>
        </section>

        <section class="mt-8 grid gap-5 md:grid-cols-2">
            @foreach ($articles as $article)
                <article class="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <p class="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">Artikel</p>
                    <h3 class="mt-3 font-['Plus_Jakarta_Sans'] text-lg font-bold">{{ $article['title'] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-[#727783]">{{ $article['description'] }}</p>
                </article>
            @endforeach
        </section>
    </section>
@endsection
