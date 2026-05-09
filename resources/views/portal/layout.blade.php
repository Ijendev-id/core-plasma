<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Academy Portal') - Core Plasma</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-[#f6f7f8] text-[#1b1c1c] antialiased" style="font-family: Inter, ui-sans-serif, system-ui, sans-serif;">
    <aside class="fixed inset-y-0 left-0 z-20 hidden w-[176px] flex-col bg-white px-5 py-6 shadow-[12px_0_30px_rgba(0,0,0,0.04)] lg:flex">
        <a href="{{ route('dashboard') }}" class="text-sm font-extrabold text-[#d40f22]">Core Plasma</a>
        <p class="mt-1 text-[10px] font-bold uppercase tracking-[1px] text-[#1b1c1c]">Academy Portal</p>
        <nav class="mt-10 flex flex-col gap-2 text-xs font-semibold text-[#727783]">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]' }} rounded-lg px-3 py-2">Dashboard</a>
            <a href="{{ route('tryouts.index') }}" class="{{ request()->routeIs('tryouts.*') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]' }} rounded-lg px-3 py-2">My Try Out</a>
            <a href="{{ route('leaderboard') }}" class="{{ request()->routeIs('leaderboard') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]' }} rounded-lg px-3 py-2">Leaderboard</a>
        </nav>
        <form method="POST" action="{{ route('member.logout') }}" class="mt-auto">
            @csrf
            <button class="w-full rounded-lg bg-[#a80606] px-3 py-3 text-center text-xs font-bold text-white shadow-[0_10px_20px_rgba(168,6,6,0.2)]">Logout</button>
        </form>
    </aside>

    <header class="fixed left-0 right-0 top-0 z-10 flex h-[72px] items-center justify-between bg-white/90 px-5 shadow-[0_1px_20px_rgba(0,0,0,0.03)] backdrop-blur lg:left-[176px] lg:px-8">
        <input type="search" placeholder="Search here..." class="h-8 w-64 rounded-full bg-[#f2f2f2] px-4 text-xs font-medium outline-none">
        <div class="flex items-center gap-4">
            <span class="size-2 rounded-full bg-[#d40f22]"></span>
            @auth('member')
                <span class="hidden text-xs font-semibold text-[#727783] sm:inline">{{ auth('member')->user()->name }}</span>
            @endauth
            <div class="size-8 rounded-full bg-[#00407f]"></div>
        </div>
    </header>

    <main class="min-h-screen px-5 pb-10 pt-[96px] lg:ml-[176px] lg:px-8">
        @yield('content')
    </main>
</body>
</html>
