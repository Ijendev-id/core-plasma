<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - Core Plasma</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-[#f5f6f6] text-[#1b1c1c] antialiased" style="font-family: Inter, ui-sans-serif, system-ui, sans-serif;">
    <aside class="fixed inset-y-0 left-0 z-20 hidden w-[288px] bg-white px-8 py-8 shadow-[12px_0_30px_rgba(0,0,0,0.04)] lg:block">
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-extrabold text-[#d40f22]">Core Plasma</a>
        <p class="mt-1 text-[10px] font-bold uppercase tracking-[1px] text-[#1b1c1c]">Academy Portal</p>
        <nav class="mt-12 flex flex-col gap-2 text-sm font-semibold text-[#727783]">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]' }} rounded-lg px-3 py-3">Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]' }} rounded-lg px-3 py-3">User Management</a>
            <a href="{{ route('admin.packages.index') }}" class="{{ request()->routeIs('admin.packages.*') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]' }} rounded-lg px-3 py-3">Package Inventory</a>
            <a href="{{ route('admin.leaderboard.index') }}" class="{{ request()->routeIs('admin.leaderboard.*') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]' }} rounded-lg px-3 py-3">Leaderboard</a>
            <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-3 hover:bg-[#f6f3f2]">Student Portal</a>
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

    @yield('content')
</body>
</html>
