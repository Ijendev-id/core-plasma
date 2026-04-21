@extends('backend.layout')

@section('title', $package->name)

@section('content')
    <main class="min-h-screen px-5 pb-10 pt-[104px] lg:ml-[288px] lg:px-12">
        <section class="grid max-w-6xl gap-6 xl:grid-cols-[1fr_280px]">
            <div class="space-y-6">
                <div class="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <div class="flex items-start justify-between gap-5">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">{{ $package->category }}</p>
                            <h1 class="mt-2 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold">{{ $package->name }} Details</h1>
                            <p class="mt-2 text-sm font-medium text-[#727783]">{{ count($questions) }} questions, {{ number_format($package->participants_count) }} participants.</p>
                        </div>
                        <a href="{{ route('admin.packages.edit', $package) }}" class="rounded-xl bg-[#a80606] px-5 py-3 text-sm font-bold text-white">Edit Package</a>
                    </div>
                </div>

                <section class="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <div class="flex items-center justify-between">
                        <h2 class="font-['Plus_Jakarta_Sans'] text-xl font-bold">Question Bank</h2>
                        <span class="rounded-xl bg-[#a80606] px-4 py-2 text-xs font-bold text-white">{{ count($questions) }} Questions</span>
                    </div>
                    @if (session('status'))
                        <div class="mt-5 rounded-xl bg-[#8cfa96]/30 px-4 py-3 text-sm font-bold text-[#004b19]">{{ session('status') }}</div>
                    @endif
                    <div class="mt-5 space-y-3">
                        @foreach ($questions as $question)
                            <article class="rounded-xl border border-[#f0eded] p-4">
                                <div class="flex items-center justify-between gap-4">
                                    <span class="rounded-lg bg-[#f6f3f2] px-3 py-1 text-xs font-bold text-[#727783]">{{ $question['type'] }}</span>
                                    <div class="flex items-center gap-3">
                                        <span class="{{ $question['status'] === 'Active' ? 'text-[#004b19]' : 'text-[#984800]' }} text-xs font-bold">{{ $question['status'] }}</span>
                                        <form method="POST" action="{{ route('admin.packages.questions.destroy', [$package, $question['id']]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-xs font-bold text-[#d40f22]">Delete</button>
                                        </form>
                                    </div>
                                </div>
                                <p class="mt-3 text-sm font-semibold">{{ $question['text'] }}</p>
                                <p class="mt-2 text-xs font-semibold text-[#727783]">{{ $question['answers_count'] }} jawaban, {{ $question['points'] }} poin</p>
                            </article>
                        @empty
                            <div class="rounded-xl border border-dashed border-[#d8d1cf] p-5 text-sm font-semibold text-[#727783]">Belum ada soal untuk paket ini.</div>
                        @endforeach
                    </div>
                </section>
            </div>

            <aside class="space-y-5">
                <section class="rounded-2xl bg-[#ffdbc8] p-6 text-[#311300]">
                    <h2 class="font-['Plus_Jakarta_Sans'] text-xl font-bold">Package Status</h2>
                    <p class="mt-3 text-sm font-semibold">{{ ucfirst($package->status) }}</p>
                    <div class="mt-5 rounded-xl bg-white/55 p-4">
                        <p class="text-xs font-bold uppercase">Price</p>
                        <p class="mt-2 font-['Plus_Jakarta_Sans'] text-2xl font-extrabold">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                    </div>
                </section>

                <section class="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <h2 class="font-['Plus_Jakarta_Sans'] text-xl font-bold">Add Question</h2>
                    <form method="POST" action="{{ route('admin.packages.questions.store', $package) }}" class="mt-5 space-y-4">
                        @csrf

                        <div class="grid gap-3 sm:grid-cols-2">
                            <label class="block">
                                <span class="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Section</span>
                                <select name="section" class="mt-2 h-11 w-full rounded-xl border border-[#e5e0df] px-3 text-sm font-semibold outline-none">
                                    @foreach (['TWK', 'TIU', 'TKP'] as $section)
                                        <option value="{{ $section }}" @selected(old('section', 'TWK') === $section)>{{ $section }}</option>
                                    @endforeach
                                </select>
                            </label>

                            <label class="block">
                                <span class="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Correct</span>
                                <select name="correct_label" class="mt-2 h-11 w-full rounded-xl border border-[#e5e0df] px-3 text-sm font-semibold outline-none">
                                    @foreach (['A', 'B', 'C', 'D', 'E'] as $label)
                                        <option value="{{ $label }}" @selected(old('correct_label', 'A') === $label)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>

                        <label class="block">
                            <span class="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Prompt</span>
                            <textarea name="prompt" rows="4" class="mt-2 w-full rounded-xl border border-[#e5e0df] px-3 py-3 text-sm font-semibold outline-none">{{ old('prompt') }}</textarea>
                            @error('prompt')
                                <span class="mt-2 block text-xs font-semibold text-[#d40f22]">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="block">
                            <span class="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Attachment Path</span>
                            <input name="attachment_path" value="{{ old('attachment_path') }}" placeholder="image/package-bulk-upload.png" class="mt-2 h-11 w-full rounded-xl border border-[#e5e0df] px-3 text-sm font-semibold outline-none">
                        </label>

                        <input name="points" value="{{ old('points', 5) }}" type="hidden">
                        <input name="is_active" value="1" type="hidden">

                        <div class="space-y-3">
                            @foreach (['A', 'B', 'C', 'D', 'E'] as $label)
                                <label class="block">
                                    <span class="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Answer {{ $label }}</span>
                                    <input name="answers[{{ $label }}]" value="{{ old('answers.'.$label) }}" class="mt-2 h-11 w-full rounded-xl border border-[#e5e0df] px-3 text-sm font-semibold outline-none">
                                </label>
                            @endforeach
                        </div>

                        <button class="w-full rounded-xl bg-[#a80606] px-5 py-3 text-sm font-bold text-white">Add New Question</button>
                    </form>
                </section>
            </aside>
        </section>
    </main>
@endsection
