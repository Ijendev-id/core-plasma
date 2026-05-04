<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Package Inventory - Core Plasma</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-[#f5f6f6] text-[#1b1c1c] antialiased" style="font-family: Inter, ui-sans-serif, system-ui, sans-serif;">
    @php
        $statAccentClasses = [
            'blue' => 'border-l-[#00407f]',
            'amber' => 'border-l-[#984800]',
            'green' => 'border-l-[#004b19]',
        ];

        $packageToneClasses = [
            'blue' => [
                'overlay' => 'bg-[#00407f]/5 text-[#00407f]',
                'avatar' => 'bg-[#00407f]',
            ],
            'amber' => [
                'overlay' => 'bg-[#984800]/5 text-[#984800]',
                'avatar' => 'bg-[#984800]',
            ],
            'muted' => [
                'overlay' => 'bg-[#727783]/5 text-[#727783]',
                'avatar' => 'bg-[#727783]',
            ],
        ];
    @endphp

    <aside class="fixed inset-y-0 left-0 z-20 hidden w-[288px] bg-white px-8 py-8 shadow-[12px_0_30px_rgba(0,0,0,0.04)] lg:block">
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-extrabold text-[#d40f22]">Core Plasma</a>
        <p class="mt-1 text-[10px] font-bold uppercase tracking-[1px] text-[#1b1c1c]">Academy Portal</p>
        <nav class="mt-12 flex flex-col gap-2 text-sm font-semibold text-[#727783]">
            <a href="{{ route('admin.dashboard') }}" class="rounded-lg px-3 py-3 hover:bg-[#f6f3f2]">Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="rounded-lg px-3 py-3 hover:bg-[#f6f3f2]">User Management</a>
            <a href="{{ route('admin.packages.index') }}" class="rounded-lg bg-[#fff1f1] px-3 py-3 text-[#d40f22]">Package Inventory</a>
            <a href="{{ route('admin.leaderboard.index') }}" class="rounded-lg px-3 py-3 hover:bg-[#f6f3f2]">Leaderboard</a>
        </nav>
        <a href="{{ route('admin.packages.create') }}" class="absolute bottom-8 left-8 right-8 rounded-xl bg-[#a80606] px-4 py-4 text-center text-sm font-bold text-white shadow-[0_10px_20px_rgba(168,6,6,0.2)]">+ New Course</a>
    </aside>

    <header class="fixed left-0 right-0 top-0 z-10 flex h-[80px] items-center justify-between bg-white/90 px-5 shadow-[0_1px_20px_rgba(0,0,0,0.03)] backdrop-blur lg:left-[288px] lg:px-8">
        <input type="search" placeholder="Search data..." class="h-8 w-72 rounded-full bg-[#f2f2f2] px-4 text-xs font-medium outline-none">
        <div class="flex items-center gap-4">
            <span class="size-2 rounded-full bg-[#d40f22]"></span>
            <span class="text-xs font-semibold text-[#727783]">Core Admin</span>
            <div class="size-8 rounded-full bg-[#00407f]"></div>
        </div>
    </header>

    <main class="w-full pb-[56px] pt-[112px] lg:ml-[288px] lg:px-12">
        <div class="flex w-full flex-col gap-8 p-8">
        <section class="flex flex-col gap-6">
            <div class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                <div>
                    <h1 class="font-['Plus_Jakarta_Sans'] text-4xl font-extrabold leading-10 tracking-normal text-[#1b1c1c]">
                        Package Inventory
                    </h1>
                    <p class="mt-1 text-base font-medium leading-6 text-[#727783]">
                        Manage and curate your elite academic tryout offerings.
                    </p>
                </div>

                <a
                    href="{{ route('admin.packages.create') }}"
                    class="inline-flex h-[52px] items-center justify-center gap-2 rounded-xl bg-gradient-to-br from-[#7f1c00] to-[#a80606] px-6 text-base font-semibold text-white shadow-[0_10px_15px_-3px_rgba(0,64,127,0.2),0_4px_6px_-4px_rgba(0,64,127,0.2)] transition hover:translate-y-[-1px] hover:shadow-[0_16px_24px_-12px_rgba(127,28,0,0.55)] focus:outline-none focus:ring-2 focus:ring-[#a80606]/30"
                >
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <span>Create New Package</span>
                </a>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($stats as $stat)
                    @if ($stat['accent'] === 'premium')
                        <article class="relative min-h-[108px] overflow-hidden rounded-xl bg-[#7f2000] p-6 text-white shadow-[0_20px_25px_-5px_rgba(0,64,127,0.1),0_8px_10px_-6px_rgba(0,64,127,0.1)]">
                            <div class="absolute -bottom-4 -right-4 h-16 w-[88px] opacity-60">
                                <div class="absolute bottom-0 right-0 size-10 rounded-full bg-white/10"></div>
                                <div class="absolute bottom-1 right-6 size-7 rounded-full bg-white/10"></div>
                                <div class="absolute bottom-3 right-12 size-4 rounded-full bg-white/10"></div>
                            </div>
                            <p class="text-xs font-semibold uppercase leading-4 tracking-[0.6px] text-white/80">
                                {{ $stat['label'] }}
                            </p>
                            <p class="mt-2 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold leading-9">
                                {{ $stat['value'] }}
                            </p>
                        </article>
                    @else
                        <article class="{{ $statAccentClasses[$stat['accent']] ?? 'border-l-[#00407f]' }} min-h-[108px] rounded-xl border-l-4 bg-white px-6 py-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                            <p class="text-xs font-semibold uppercase leading-4 tracking-[0.6px] text-[#727783]">
                                {{ $stat['label'] }}
                            </p>
                            <div class="mt-2 flex items-end justify-between gap-4">
                                <p class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold leading-9">
                                    {{ $stat['value'] }}
                                </p>

                                @if ($stat['meta_type'] === 'trend')
                                    <span class="inline-flex items-center gap-1 rounded-lg bg-[#8cfa96] px-2 py-1 text-xs font-semibold leading-4 text-[#004b19]">
                                        <svg class="h-[7px] w-3" viewBox="0 0 12 8" fill="none" aria-hidden="true">
                                            <path d="M1 7L4.4 3.6L6.8 5.8L11 1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        {{ $stat['meta'] }}
                                    </span>
                                @elseif ($stat['meta_type'] === 'live')
                                    <span class="rounded-lg bg-[#ffdbc8] px-2 py-1 text-xs font-semibold leading-4 text-[#984800]">
                                        {{ $stat['meta'] }}
                                    </span>
                                @elseif ($stat['meta_type'] === 'progress')
                                    <span class="mb-2 block h-2 w-16 overflow-hidden rounded-full bg-[#eae7e7]">
                                        <span class="block h-full rounded-full bg-[#004b19]" style="width: {{ (int) $stat['meta'] }}%"></span>
                                    </span>
                                @endif
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl bg-[#f6f3f2] shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
            @if (session('status'))
                <div class="mx-4 mt-4 rounded-xl border border-[#8cfa96] bg-[#8cfa96]/25 px-4 py-3 text-sm font-semibold text-[#004b19]">
                    {{ session('status') }}
                </div>
            @endif

            <div class="overflow-x-auto px-4 py-2">
                <table class="w-full min-w-[800px] border-separate border-spacing-y-2 text-left">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold uppercase leading-4 tracking-[1.2px] text-[#727783]">Package Name</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase leading-4 tracking-[1.2px] text-[#727783]">Category</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase leading-4 tracking-[1.2px] text-[#727783]">Questions</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase leading-4 tracking-[1.2px] text-[#727783]">Participants</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase leading-4 tracking-[1.2px] text-[#727783]">Price</th>
                            <th class="px-6 py-4 text-xs font-semibold uppercase leading-4 tracking-[1.2px] text-[#727783]">Aksi</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase leading-4 tracking-[1.2px] text-[#727783]">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($packages as $package)
                            @php
                                $tone = $packageToneClasses[$package['tone']] ?? $packageToneClasses['blue'];
                            @endphp
                            <tr class="group bg-white">
                                <td class="rounded-l-sm px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="{{ $tone['overlay'] }} inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg">
                                            @switch($package['icon'])
                                                @case('rocket')
                                                    <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                        <path d="M5 16c-1.2 1-2 2.7-2 5c2.3 0 4-0.8 5-2M9 15l-2-2c0-4.5 3.5-8.5 10.5-10.5C19.5 9.5 15.5 13 11 13l-2 2ZM14 6l4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    @break
                                                @case('briefcase')
                                                    <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                        <path d="M9 7V5.8A1.8 1.8 0 0 1 10.8 4h2.4A1.8 1.8 0 0 1 15 5.8V7M5 8h14a1 1 0 0 1 1 1v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    @break
                                                @case('school')
                                                    <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                        <path d="M12 3l8 4.5l-8 4.5l-8-4.5L12 3ZM6.5 10.5V16c0 1.7 2.5 3 5.5 3s5.5-1.3 5.5-3v-5.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    @break
                                                @default
                                                    <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                        <path d="M12 4L3.5 8.5L12 13L20.5 8.5L12 4ZM6 11v4.5c0 1.4 2.7 3.5 6 3.5s6-2.1 6-3.5V11" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                            @endswitch
                                        </span>
                                        <span class="max-w-[11rem] text-base font-semibold leading-tight text-[#1b1c1c]">
                                            {{ $package['name'] }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-lg bg-[#eae7e7] px-3 py-1 text-[11px] font-semibold uppercase leading-none tracking-normal text-[#1b1c1c]">
                                        {{ $package['category'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-base font-medium text-[#727783]">
                                    {{ $package['questions'] }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($package['has_participant_preview'])
                                        <div class="flex items-center">
                                            <span class="-mr-2 size-7 rounded-full border-2 border-white bg-[#e2e8f0]"></span>
                                            <span class="-mr-2 size-7 rounded-full border-2 border-white bg-[#cbd5e1]"></span>
                                            <span class="{{ $tone['avatar'] }} inline-flex h-7 min-w-8 items-center justify-center rounded-full border-2 border-white px-1 text-[10px] font-semibold text-white">
                                                {{ $package['participants'] }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-base font-medium text-[#1b1c1c]">{{ $package['participants'] }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        [$currency, $amount] = explode(' ', $package['price'], 2);
                                    @endphp
                                    <span class="block max-w-[86px] text-base font-semibold leading-tight text-[#00407f]">
                                        {{ $currency }}<br>{{ $amount }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="{{ $package['status'] === 'published' ? 'bg-[#004b19]' : 'bg-[#727783]' }} size-2 rounded-full"></span>
                                        <div class="flex flex-col text-xs font-semibold leading-4 {{ $package['status'] === 'published' ? 'text-[#004b19]' : 'text-[#727783]' }}">
                                            <span>{{ $package['status_label'] }}</span>
                                            <a href="{{ route('admin.packages.tryout', $package['slug']) }}" class="hover:underline">edit soal</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="rounded-r-sm px-6 py-4">
                                    <div class="flex items-center justify-end gap-1 opacity-0 transition group-hover:opacity-100">
                                        <a
                                            href="{{ route('admin.packages.edit', $package['slug']) }}"
                                            class="inline-flex size-8 items-center justify-center rounded-lg text-[#00407f] transition hover:bg-[#00407f]/10"
                                            aria-label="Edit {{ $package['name'] }}"
                                        >
                                            <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                <path d="M4 20h4L18.5 9.5a2.12 2.12 0 0 0-3-3L5 17v3ZM13.5 8.5l3 3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.packages.destroy', $package['slug']) }}" onsubmit="return confirm('Hapus package ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="inline-flex size-8 items-center justify-center rounded-lg text-[#a80606] transition hover:bg-[#a80606]/10"
                                                aria-label="Delete {{ $package['name'] }}"
                                            >
                                                <svg class="size-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                    <path d="M5 7h14M10 11v6M14 11v6M9 7l1-2h4l1 2M7 7l1 13h8l1-13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="rounded-sm bg-white px-6 py-10 text-center text-sm font-medium text-[#727783]">
                                    Package tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-4 bg-[#f0eded] px-6 py-4 sm:flex-row sm:items-center sm:justify-between lg:px-8">
                <p class="text-xs font-medium leading-4 text-[#727783]">
                    Showing {{ $pagination['from'] }} to {{ $pagination['to'] }} of {{ $pagination['total'] }} packages
                </p>
                <nav class="flex items-center gap-1" aria-label="Pagination">
                    <a href="{{ $paginator->previousPageUrl() ?? '#' }}" class="{{ $paginator->onFirstPage() ? 'pointer-events-none opacity-40' : 'hover:bg-white' }} inline-flex size-8 items-center justify-center rounded-lg text-[#727783] transition" aria-label="Previous page">
                        <svg class="h-3 w-2" viewBox="0 0 8 12" fill="none" aria-hidden="true">
                            <path d="M6.5 1L1.5 6L6.5 11" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>

                    @for ($page = 1; $page <= min(3, $pagination['last_page']); $page++)
                        <a
                            href="{{ $paginator->url($page) }}"
                            class="{{ $page === $pagination['current'] ? 'bg-[#00407f] text-white' : 'text-[#727783] hover:bg-white' }} inline-flex size-8 items-center justify-center rounded-lg text-xs font-semibold transition"
                        >
                            {{ $page }}
                        </a>
                    @endfor

                    @if ($pagination['last_page'] > 4)
                        <span class="px-2 text-base leading-6 text-[#727783]">...</span>
                    @endif

                    @if ($pagination['last_page'] > 3)
                        <a
                            href="{{ $paginator->url($pagination['last_page']) }}"
                            class="{{ $pagination['last_page'] === $pagination['current'] ? 'bg-[#00407f] text-white' : 'text-[#727783] hover:bg-white' }} inline-flex size-8 items-center justify-center rounded-lg text-xs font-semibold transition"
                        >
                            {{ $pagination['last_page'] }}
                        </a>
                    @endif

                    <a href="{{ $paginator->nextPageUrl() ?? '#' }}" class="{{ $paginator->hasMorePages() ? 'hover:bg-white' : 'pointer-events-none opacity-40' }} inline-flex size-8 items-center justify-center rounded-lg text-[#727783] transition" aria-label="Next page">
                        <svg class="h-3 w-2" viewBox="0 0 8 12" fill="none" aria-hidden="true">
                            <path d="M1.5 1L6.5 6L1.5 11" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </nav>
            </div>
        </section>

        <section class="grid gap-8 lg:grid-cols-2">
            <article class="relative min-h-[204px] overflow-hidden rounded-2xl p-8 text-white">
                <img
                    src="{{ asset($helpers['bulk_upload']['image']) }}"
                    alt=""
                    class="absolute inset-0 h-full w-full object-cover"
                >
                <div class="absolute inset-0 bg-gradient-to-r from-[#7f0f00]/90 to-[#00407f]/0"></div>
                <div class="relative flex max-w-md flex-col items-start gap-3">
                    <h2 class="font-['Plus_Jakarta_Sans'] text-xl font-bold leading-7">
                        {{ $helpers['bulk_upload']['title'] }}
                    </h2>
                    <p class="text-sm font-normal leading-5 text-white/90">
                        {{ $helpers['bulk_upload']['description'] }}
                    </p>
                    <a href="#" class="mt-1 inline-flex rounded-lg bg-white px-4 py-2 text-xs font-semibold leading-4 text-[#7f0800] transition hover:bg-[#fff7f5]">
                        {{ $helpers['bulk_upload']['button'] }}
                    </a>
                </div>
            </article>

            <article class="flex min-h-[204px] flex-col justify-center rounded-2xl bg-[#ffdbc8] p-8 text-[#311300]">
                <span class="inline-flex size-10 items-center justify-center rounded-full bg-[#fd811d] text-white">
                    <svg class="h-5 w-[15px]" viewBox="0 0 18 24" fill="none" aria-hidden="true">
                        <path d="M9 2a7 7 0 0 0-4 12.75V18h8v-3.25A7 7 0 0 0 9 2Z" fill="currentColor"/>
                        <path d="M6.5 21h5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
                <h2 class="mt-5 font-['Plus_Jakarta_Sans'] text-xl font-bold leading-7">
                    {{ $helpers['tip']['title'] }}
                </h2>
                <p class="mt-3 max-w-md text-sm font-normal leading-5 text-[#311300]/80">
                    {{ $helpers['tip']['description'] }}
                </p>
            </article>
        </section>
        </div>
    </main>
</body>
</html>
