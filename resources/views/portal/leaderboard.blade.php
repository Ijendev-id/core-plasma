@extends('portal.layout')

@section('title', 'Leaderboard')

@section('content')
    <section class="max-w-5xl">
        <div class="rounded-3xl bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
            <div class="text-center">
                <p class="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">Leaderboard</p>
                <h1 class="mt-2 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold">Puncak Pretul</h1>
                <p class="mt-2 text-sm font-medium text-[#727783]">Result of PR Nasional by CI Batch 3</p>
            </div>

            <div class="mt-8 grid items-end gap-4 md:grid-cols-3">
                @foreach ($podium as $person)
                    <div class="{{ $person['rank'] === 1 ? 'order-first bg-[#d40f22] text-white md:order-none md:min-h-[180px]' : 'bg-[#f4f6f8]' }} rounded-3xl p-6 text-center">
                        <div class="mx-auto size-16 rounded-full bg-[#ffd12e]"></div>
                        <p class="mt-4 text-sm font-bold">{{ $person['name'] }}</p>
                        <p class="mt-2 font-['Plus_Jakarta_Sans'] text-4xl font-extrabold">{{ match ($person['rank']) { 1 => '1ST', 2 => '2ND', 3 => '3RD', default => $person['rank'].'TH' } }}</p>
                        <p class="mt-2 text-xs font-semibold {{ $person['rank'] === 1 ? 'text-white/80' : 'text-[#727783]' }}">{{ $person['score'] }} point</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 overflow-hidden rounded-2xl border border-[#f0eded]">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#f8f7f7] text-xs font-bold uppercase tracking-[1px] text-[#727783]">
                        <tr>
                            <th class="px-5 py-4">Ranking</th>
                            <th class="px-5 py-4">Nama</th>
                            <th class="px-5 py-4">TWK</th>
                            <th class="px-5 py-4">TIU</th>
                            <th class="px-5 py-4">TKP</th>
                            <th class="px-5 py-4 text-right">Total Score</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0eded]">
                        @foreach ($rows as $row)
                            <tr>
                                <td class="px-5 py-4 font-bold">{{ $row['rank'] }}</td>
                                <td class="px-5 py-4 font-semibold">{{ $row['name'] }}</td>
                                <td class="px-5 py-4">{{ $row['twk'] }}</td>
                                <td class="px-5 py-4">{{ $row['tiu'] }}</td>
                                <td class="px-5 py-4">{{ $row['tkp'] }}</td>
                                <td class="px-5 py-4 text-right font-bold text-[#d40f22]">{{ $row['total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
