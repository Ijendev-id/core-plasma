@extends('portal.layout')

@section('title', 'Tryout')

@section('content')
    <section class="grid gap-6 xl:grid-cols-[1fr_260px]">
        <div class="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">{{ $package?->name ?? 'Tryout' }}</p>
                    <h1 class="mt-1 font-['Plus_Jakarta_Sans'] text-2xl font-extrabold">Soal {{ $question['number'] }} dari {{ $question['total'] }}</h1>
                </div>
                <span class="rounded-full bg-[#f6f3f2] px-4 py-2 text-xs font-bold text-[#727783]">01:42:15</span>
            </div>

            <p class="mt-6 text-sm font-medium leading-7 text-[#1b1c1c]">{{ $question['text'] }}</p>
            <div class="mt-5 overflow-hidden rounded-xl bg-[#eae7e7]">
                <img src="{{ asset($question['image']) }}" alt="" class="h-48 w-full object-cover">
            </div>

            <div class="mt-5 space-y-3">
                @foreach ($question['answers'] as $answer)
                    <label class="{{ $answer['state'] === 'selected' ? 'border-[#a80606] bg-[#d9a1a1]' : 'border-[#f0eded] bg-[#f8f7f7]' }} flex cursor-pointer items-center gap-3 rounded-xl border px-4 py-4">
                        <span class="{{ $answer['state'] === 'selected' ? 'bg-[#a80606] text-white' : 'bg-white text-[#727783]' }} inline-flex size-6 items-center justify-center rounded-md text-xs font-bold">{{ $answer['label'] }}</span>
                        <input class="sr-only" type="radio" name="answer" @checked($answer['state'] === 'selected')>
                        <span class="text-sm font-semibold">{{ $answer['text'] }}</span>
                    </label>
                @endforeach
            </div>

            <div class="mt-6 flex items-center justify-between">
                <button class="rounded-xl bg-[#a80606] px-5 py-3 text-xs font-bold text-white">&lt; Sebelumnya</button>
                <label class="flex items-center gap-2 text-xs font-semibold text-[#727783]">
                    <input type="checkbox" class="size-4 rounded border-[#cfcaca]">
                    Ragu-ragu
                </label>
                <button class="rounded-xl bg-[#a80606] px-5 py-3 text-xs font-bold text-white">Selanjutnya &gt;</button>
            </div>
        </div>

        <aside class="space-y-5">
            <section class="rounded-2xl bg-white p-5 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                <h2 class="font-['Plus_Jakarta_Sans'] text-lg font-bold">Navigasi Soal</h2>
                <div class="mt-4 grid grid-cols-5 gap-2">
                    @foreach ($palette as $item)
                        <button class="{{ match ($item['state']) {
                            'done' => 'bg-[#004b19] text-white',
                            'current' => 'bg-[#a80606] text-white',
                            default => 'bg-[#f0eded] text-[#727783]',
                        } }} size-9 rounded-lg text-xs font-bold">{{ $item['number'] }}</button>
                    @endforeach
                </div>
                <div class="mt-5 rounded-xl bg-[#f6f3f2] p-4">
                    <p class="text-xs font-bold uppercase text-[#984800]">Current Package</p>
                    <p class="mt-1 text-sm font-bold">{{ $package?->name }}</p>
                </div>
            </section>
        </aside>
    </section>
@endsection
