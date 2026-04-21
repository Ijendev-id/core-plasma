<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - Core Plasma</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-[#f5f6f6] text-[#1b1c1c] antialiased" style="font-family: Inter, ui-sans-serif, system-ui, sans-serif;">
    @php
        $value = fn (string $key) => old($key, $package[$key] ?? '');
        $checked = old('show_participant_preview', $package['show_participant_preview'] ?? false);
    @endphp

    <main class="mx-auto flex w-full max-w-[980px] flex-col gap-8 px-5 py-10 sm:px-8 lg:py-14">
        <section class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
            <div>
                <a href="{{ route('admin.packages.index') }}" class="text-sm font-semibold text-[#00407f] hover:underline">
                    Back to inventory
                </a>
                <h1 class="mt-3 font-['Plus_Jakarta_Sans'] text-4xl font-extrabold leading-10 tracking-normal text-[#1b1c1c]">
                    {{ $title }}
                </h1>
                <p class="mt-1 text-base font-medium leading-6 text-[#727783]">
                    Kelola metadata paket, harga, status publish, dan tampilan row inventory.
                </p>
            </div>
        </section>

        @if (session('status'))
            <div class="rounded-xl border border-[#8cfa96] bg-[#8cfa96]/25 px-4 py-3 text-sm font-semibold text-[#004b19]">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-[#a80606]/20 bg-[#a80606]/10 px-4 py-3 text-sm font-semibold text-[#7f1c00]">
                Ada input yang belum valid. Cek field yang ditandai.
            </div>
        @endif

        <form method="POST" action="{{ $action }}" class="overflow-hidden rounded-2xl bg-white shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <div class="grid gap-6 p-6 md:grid-cols-2 lg:p-8">
                <div class="md:col-span-2">
                    <label for="name" class="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Package Name</label>
                    <input
                        id="name"
                        name="name"
                        value="{{ $value('name') }}"
                        type="text"
                        class="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                        required
                    >
                    @error('name')
                        <p class="mt-2 text-sm font-semibold text-[#a80606]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category" class="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Category</label>
                    <input
                        id="category"
                        name="category"
                        value="{{ $value('category') }}"
                        type="text"
                        list="category-options"
                        class="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold uppercase text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                        required
                    >
                    <datalist id="category-options">
                        @foreach ($categories as $category)
                            <option value="{{ $category }}"></option>
                        @endforeach
                    </datalist>
                    @error('category')
                        <p class="mt-2 text-sm font-semibold text-[#a80606]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Status</label>
                    <select
                        id="status"
                        name="status"
                        class="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                    >
                        @foreach ($statuses as $status => $label)
                            <option value="{{ $status }}" @selected($value('status') === $status)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm font-semibold text-[#a80606]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="question_count" class="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Questions</label>
                    <input
                        id="question_count"
                        name="question_count"
                        value="{{ $value('question_count') }}"
                        type="number"
                        min="0"
                        class="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                        required
                    >
                    @error('question_count')
                        <p class="mt-2 text-sm font-semibold text-[#a80606]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="participants_count" class="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Participants</label>
                    <input
                        id="participants_count"
                        name="participants_count"
                        value="{{ $value('participants_count') }}"
                        type="number"
                        min="0"
                        class="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                        required
                    >
                    @error('participants_count')
                        <p class="mt-2 text-sm font-semibold text-[#a80606]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Price</label>
                    <input
                        id="price"
                        name="price"
                        value="{{ $value('price') }}"
                        type="number"
                        min="0"
                        class="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                        required
                    >
                    @error('price')
                        <p class="mt-2 text-sm font-semibold text-[#a80606]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="icon" class="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Icon</label>
                    <select
                        id="icon"
                        name="icon"
                        class="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                    >
                        @foreach ($icons as $icon => $label)
                            <option value="{{ $icon }}" @selected($value('icon') === $icon)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('icon')
                        <p class="mt-2 text-sm font-semibold text-[#a80606]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tone" class="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Tone</label>
                    <select
                        id="tone"
                        name="tone"
                        class="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                    >
                        @foreach ($tones as $tone => $label)
                            <option value="{{ $tone }}" @selected($value('tone') === $tone)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('tone')
                        <p class="mt-2 text-sm font-semibold text-[#a80606]">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-3 rounded-xl bg-[#f6f3f2] px-4 py-4 md:col-span-2">
                    <input
                        name="show_participant_preview"
                        value="1"
                        type="checkbox"
                        class="size-4 rounded border-[#cfcaca] text-[#00407f] focus:ring-[#00407f]/20"
                        @checked((bool) $checked)
                    >
                    <span class="text-sm font-semibold text-[#1b1c1c]">Show stacked participant preview in table</span>
                </label>
            </div>

            <div class="flex flex-col-reverse gap-3 bg-[#f0eded] px-6 py-4 sm:flex-row sm:justify-end lg:px-8">
                <a href="{{ route('admin.packages.index') }}" class="inline-flex h-11 items-center justify-center rounded-xl px-5 text-sm font-semibold text-[#727783] transition hover:bg-white">
                    Cancel
                </a>
                <button type="submit" class="inline-flex h-11 items-center justify-center rounded-xl bg-gradient-to-br from-[#7f1c00] to-[#a80606] px-5 text-sm font-semibold text-white shadow-[0_10px_15px_-3px_rgba(0,64,127,0.18)] transition hover:translate-y-[-1px]">
                    Save Package
                </button>
            </div>
        </form>
    </main>
</body>
</html>
