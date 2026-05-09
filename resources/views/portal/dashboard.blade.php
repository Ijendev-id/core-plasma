@extends('portal.layout')

@section('title', 'Dashboard')

@section('content')
    <section class="grid gap-6 xl:grid-cols-[1fr_260px]">
        <div class="space-y-6">
            <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-[#d31325] to-[#8c0013] p-8 text-white shadow-[0_20px_50px_rgba(168,6,6,0.18)]">
                <p class="text-xs font-bold uppercase tracking-[1.2px] text-white/70">Next Tryout</p>
                <h1 class="mt-3 font-['Plus_Jakarta_Sans'] text-4xl font-extrabold leading-tight">Selamat Belajar,<br>{{ $member?->name ?? 'Peserta' }}!</h1>
                <p class="mt-4 max-w-xl text-sm leading-6 text-white/80">Selesaikan progres belajarmu hari ini dan lanjutkan simulasi tryout yang tertunda.</p>
                <a href="{{ route('tryouts.index') }}" class="mt-6 inline-flex rounded-xl bg-white px-5 py-3 text-sm font-bold text-[#a80606]">Lanjut Belajar</a>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <section class="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <div class="mb-5 flex items-center justify-between">
                        <h2 class="font-['Plus_Jakarta_Sans'] text-lg font-bold">Progres Belajar</h2>
                        <a href="{{ route('tryouts.index') }}" class="text-xs font-bold text-[#d40f22]">Lihat Paket</a>
                    </div>
                    <div class="space-y-4">
                        @foreach ($progress as $item)
                            <div class="rounded-xl border border-[#f0eded] p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="text-sm font-bold">{{ $item['title'] }}</p>
                                    <span class="rounded-full bg-[#fff1d9] px-2 py-1 text-[10px] font-bold text-[#984800]">{{ $item['tag'] }}</span>
                                </div>
                                <div class="mt-4 h-2 overflow-hidden rounded-full bg-[#eae7e7]">
                                    <div class="h-full rounded-full bg-[#d40f22]" style="width: {{ $item['percent'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <h2 class="font-['Plus_Jakarta_Sans'] text-lg font-bold">Hasil Try Out Terakhir</h2>
                    <div class="mt-5 space-y-3">
                        @foreach ($recentResults as $result)
                            <div class="flex items-center justify-between rounded-xl bg-[#f8f7f7] p-4">
                                <div>
                                    <p class="text-sm font-bold">{{ $result['title'] }}</p>
                                    <p class="mt-1 text-xs font-semibold text-[#727783]">Score {{ $result['score'] }}</p>
                                </div>
                                <span class="rounded-full bg-[#fff1f1] px-3 py-1 text-[10px] font-bold text-[#d40f22]">{{ $result['status'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>

        <aside class="space-y-5">
            <section class="rounded-2xl bg-white p-5 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                <h2 class="font-['Plus_Jakarta_Sans'] text-lg font-bold">Ranking Siswa</h2>
                <div class="mt-5 space-y-3">
                    @foreach ($ranking as $row)
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-semibold">{{ $row['name'] }}</span>
                            <span class="font-bold text-[#d40f22]">{{ $row['score'] }}</span>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('leaderboard') }}" class="mt-5 block rounded-xl bg-[#ffd12e] px-4 py-3 text-center text-sm font-bold text-[#311300]">Lihat Ranking Lengkap</a>
            </section>
        </aside>
    </section>
@endsection
