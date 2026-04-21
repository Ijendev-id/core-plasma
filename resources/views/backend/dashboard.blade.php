@extends('backend.layout')

@section('title', 'Admin Dashboard')

@section('content')
    <main class="min-h-screen px-5 pb-10 pt-[104px] lg:ml-[288px] lg:px-12">
        <section class="max-w-6xl">
            <h1 class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold">Dashboard</h1>
            <p class="mt-2 text-sm font-medium text-[#727783]">Monitor performa tryout dan aktivitas siswa.</p>

            <div class="mt-8 grid gap-5 md:grid-cols-4">
                @foreach ($cards as $card)
                    <article class="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                        <p class="text-xs font-bold uppercase tracking-[1px] text-[#727783]">{{ $card['label'] }}</p>
                        <p class="mt-4 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold">{{ $card['value'] }}</p>
                    </article>
                @endforeach
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_320px]">
                <section class="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <h2 class="font-['Plus_Jakarta_Sans'] text-xl font-bold">Recent Activity</h2>
                    <div class="mt-5 space-y-4">
                        @foreach ($recentUsers as $user)
                            <div class="flex items-center justify-between rounded-xl bg-[#f8f7f7] p-4">
                                <div>
                                    <p class="text-sm font-bold">{{ $user['name'] }}</p>
                                    <p class="text-xs font-semibold text-[#727783]">{{ $user['role'] }}</p>
                                </div>
                                <span class="rounded-full bg-[#8cfa96] px-3 py-1 text-[10px] font-bold text-[#004b19]">{{ $user['status'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="rounded-2xl bg-[#ffd12e] p-6 text-[#311300]">
                    <p class="text-xs font-bold uppercase tracking-[1px]">Quick Action</p>
                    <h2 class="mt-3 font-['Plus_Jakarta_Sans'] text-xl font-bold">Buat atau update paket tryout</h2>
                    <p class="mt-3 text-sm leading-6 text-[#311300]/75">Kelola inventory, soal, dan leaderboard langsung dari area admin.</p>
                    <a href="{{ route('admin.packages.index') }}" class="mt-5 inline-flex rounded-xl bg-[#a80606] px-5 py-3 text-sm font-bold text-white">Package Inventory</a>
                </section>
            </div>
        </section>
    </main>
@endsection
