@extends('backend.layout')

@section('title', 'Leaderboard Management')

@section('content')
    <main class="min-h-screen px-5 pb-10 pt-[104px] lg:ml-[288px] lg:px-12">
        <section>
            <h1 class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold">Leaderboard Management</h1>
            <p class="mt-2 text-sm font-medium text-[#727783]">Pantau hasil tryout, hall of fame, dan score siswa.</p>

            <div class="mt-8 grid gap-5 md:grid-cols-3">
                @foreach ($summary as $card)
                    <article class="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                        <p class="text-xs font-bold uppercase tracking-[1px] text-[#727783]">{{ $card['label'] }}</p>
                        <p class="mt-4 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold">{{ $card['value'] }}</p>
                    </article>
                @endforeach
            </div>

            <div class="mt-8 overflow-hidden rounded-2xl bg-white shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#f6f3f2] text-xs font-bold uppercase tracking-[1px] text-[#727783]">
                        <tr>
                            <th class="px-6 py-4">Student</th>
                            <th class="px-6 py-4">Score</th>
                            <th class="px-6 py-4">Time</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0eded]">
                        @foreach ($rows as $row)
                            <tr>
                                <td class="px-6 py-5 font-bold">{{ $row['name'] }}</td>
                                <td class="px-6 py-5 font-bold text-[#00407f]">{{ $row['score'] }}</td>
                                <td class="px-6 py-5 text-[#727783]">{{ $row['time'] }}</td>
                                <td class="px-6 py-5">
                                    <span class="{{ $row['status'] === 'Certified' ? 'bg-[#8cfa96]/40 text-[#004b19]' : 'bg-[#ffdbc8] text-[#984800]' }} rounded-full px-3 py-1 text-xs font-bold">{{ $row['status'] }}</span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <button class="rounded-lg px-3 py-2 text-xs font-bold text-[#00407f] hover:bg-[#00407f]/10">Review</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection
