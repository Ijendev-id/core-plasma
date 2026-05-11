@extends('backend.layout')

@section('title', 'Leaderboard Management')

@section('content')
    <main class="min-h-screen px-5 pb-10 pt-[104px] lg:ml-[288px] lg:px-12">
        <section class="max-w-6xl">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <div>
                    <h1 class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold text-[#1b1c1c]">Leaderboard Management</h1>
                    <p class="mt-2 text-sm font-medium text-[#727783]">Monitor student performance, Hall of Fame, and score validation.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-xs font-bold text-[#727783] shadow-sm border border-[#e5e0df] hover:bg-[#f6f3f2]">
                        <span>Export CSV</span>
                    </button>
                    <button class="flex items-center gap-2 rounded-xl bg-[#a80606] px-4 py-2.5 text-xs font-bold text-white shadow-[0_10px_20px_rgba(168,6,6,0.15)] hover:bg-[#8c0013]">
                        <span>Refresh Data</span>
                    </button>
                </div>
            </div>

            <!-- Package Selector (Dropdown) -->
            <div class="mt-10 flex flex-wrap items-center gap-4 border-b border-[#e5e0df] pb-6">
                <div class="w-full max-w-sm">
                    <label for="package-selector" class="mb-2 block text-[10px] font-black uppercase tracking-[1px] text-[#727783]">Select Tryout Package</label>
                    <select id="package-selector" onchange="window.location.href = this.value" class="h-12 w-full rounded-xl border border-[#e5e0df] bg-white px-4 text-sm font-bold text-[#1b1c1c] shadow-sm outline-none focus:border-[#a80606] transition-all">
                        <option value="{{ route('admin.leaderboard.index') }}" {{ !$selectedPackage ? 'selected' : '' }}>All Categories / General Ranking</option>
                        @foreach($packages as $pkg)
                            <option value="{{ route('admin.leaderboard.index', ['package_id' => $pkg->id]) }}" {{ $selectedPackage == $pkg->id ? 'selected' : '' }}>
                                {{ $pkg->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-6 flex flex-wrap gap-2 md:mt-0 md:ml-auto">
                    <!-- Quick category filters can go here if needed -->
                </div>
            </div>

            <div class="mt-8 grid gap-6 md:grid-cols-3">
                @foreach ($summary as $card)
                    <article class="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-[#f0eded]">
                        <p class="text-[10px] font-bold uppercase tracking-[1.2px] text-[#727783]">{{ $card['label'] }}</p>
                        <p class="mt-4 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold text-[#1b1c1c]">{{ $card['value'] }}</p>
                    </article>
                @endforeach
            </div>

            <!-- Hall of Fame Spotlight (Podium) -->
            <div class="mt-12">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="font-['Plus_Jakarta_Sans'] text-xl font-extrabold text-[#1b1c1c]">Hall of Fame Spotlight</h2>
                    <span class="text-xs font-bold text-[#a80606] uppercase tracking-[1px]">Top 3 Achievers</span>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    @foreach($podium as $winner)
                        <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-[0_15px_40px_rgba(0,0,0,0.06)] border border-[#f0eded]">
                            <div class="absolute -right-4 -top-4 size-24 rounded-full {{ $winner['rank'] == 1 ? 'bg-[#ffd12e]/10' : ($winner['rank'] == 2 ? 'bg-[#727783]/10' : 'bg-[#a80606]/10') }}"></div>
                            <div class="relative flex items-center gap-4">
                                <div class="relative">
                                    <img src="{{ $winner['avatar'] }}" class="size-16 rounded-full border-2 {{ $winner['rank'] == 1 ? 'border-[#ffd12e]' : ($winner['rank'] == 2 ? 'border-[#727783]' : 'border-[#a80606]') }}" alt="">
                                    <span class="absolute -bottom-1 -right-1 flex size-6 items-center justify-center rounded-full {{ $winner['rank'] == 1 ? 'bg-[#ffd12e]' : ($winner['rank'] == 2 ? 'bg-[#727783]' : 'bg-[#a80606]') }} text-[10px] font-black text-white">#{{ $winner['rank'] }}</span>
                                </div>
                                <div>
                                    <h3 class="font-['Plus_Jakarta_Sans'] text-lg font-bold text-[#1b1c1c]">{{ $winner['name'] }}</h3>
                                    <p class="text-xs font-bold text-[#a80606]">{{ $winner['package'] }}</p>
                                </div>
                            </div>
                            <div class="mt-6 flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-bold uppercase text-[#727783]">Final Score</p>
                                    <p class="text-2xl font-black text-[#00407f]">{{ $winner['score'] }}</p>
                                </div>
                                <button class="rounded-lg bg-[#f6f3f2] px-3 py-1.5 text-[10px] font-bold text-[#727783] hover:bg-[#e5e0df]">View Profile</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Detailed Ranking Table -->
            <div class="mt-12 overflow-hidden rounded-2xl bg-white shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-[#f0eded]">
                <div class="bg-[#fcfbfb] px-6 py-4 border-b border-[#f0eded]">
                    <h3 class="font-['Plus_Jakarta_Sans'] text-sm font-bold text-[#1b1c1c]">Full Leaderboard Ranking</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-[#f6f3f2] text-[10px] font-black uppercase tracking-[1.5px] text-[#727783]">
                            <tr>
                                <th class="px-6 py-4">Student</th>
                                <th class="px-6 py-4">Package</th>
                                <th class="px-6 py-4">Score</th>
                                <th class="px-6 py-4">Time</th>
                                <th class="px-6 py-4">Audit Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f0eded]">
                            @foreach ($rows as $row)
                                <tr class="hover:bg-[#fafafa] transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="font-bold text-[#1b1c1c]">{{ $row['name'] }}</div>
                                        <div class="text-[10px] text-[#727783]">Member ID: #{{ 1000 + $row['id'] }}</div>
                                    </td>
                                    <td class="px-6 py-5 font-semibold text-[#727783]">{{ $row['package'] }}</td>
                                    <td class="px-6 py-5">
                                        <span class="text-lg font-black text-[#00407f]">{{ $row['score'] }}</span>
                                    </td>
                                    <td class="px-6 py-5 text-[#727783] font-medium">{{ $row['time'] }}</td>
                                    <td class="px-6 py-5">
                                        @if($row['is_flagged'])
                                            <span class="inline-flex items-center gap-1 rounded-full bg-[#ffdbc8] px-3 py-1 text-[10px] font-bold text-[#984800]">
                                                <span class="size-1.5 rounded-full bg-[#984800]"></span> SUSPICIOUS
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-[#8cfa96]/30 px-3 py-1 text-[10px] font-bold text-[#004b19]">
                                                <span class="size-1.5 rounded-full bg-[#004b19]"></span> VERIFIED
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button title="Edit Score" class="rounded-lg p-2 text-[#727783] hover:bg-[#f6f3f2] hover:text-[#00407f]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button title="Flag / Unflag" class="rounded-lg p-2 {{ $row['is_flagged'] ? 'text-[#a80606] bg-[#a80606]/10' : 'text-[#727783]' }} hover:bg-[#f6f3f2]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
@endsection
