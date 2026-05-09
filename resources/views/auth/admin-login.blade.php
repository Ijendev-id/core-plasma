<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - Core Plasma</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-[#f6f7f8] text-[#1b1c1c] antialiased" style="font-family: Inter, ui-sans-serif, system-ui, sans-serif;">
    <main class="grid min-h-screen place-items-center px-5 py-10">
        <section class="w-full max-w-md rounded-2xl bg-white p-8 shadow-[0_16px_50px_rgba(0,0,0,0.06)]">
            <p class="text-sm font-extrabold text-[#d40f22]">Core Plasma</p>
            <h1 class="mt-3 font-['Plus_Jakarta_Sans'] text-3xl font-extrabold">Login Admin</h1>
            <p class="mt-2 text-sm font-medium text-[#727783]">Masuk sebagai administrator.</p>

            <form method="POST" action="{{ route('admin.login.store') }}" class="mt-7 space-y-5">
                @csrf

                <label class="block">
                    <span class="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Email</span>
                    <input name="email" type="email" value="{{ old('email') }}" required autofocus class="mt-2 h-12 w-full rounded-xl border border-[#e5e0df] px-4 text-sm font-semibold outline-none focus:border-[#a80606]">
                    @error('email')
                        <span class="mt-2 block text-xs font-semibold text-[#d40f22]">{{ $message }}</span>
                    @enderror
                </label>

                <label class="block">
                    <span class="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Password</span>
                    <input name="password" type="password" required class="mt-2 h-12 w-full rounded-xl border border-[#e5e0df] px-4 text-sm font-semibold outline-none focus:border-[#a80606]">
                    @error('password')
                        <span class="mt-2 block text-xs font-semibold text-[#d40f22]">{{ $message }}</span>
                    @enderror
                </label>

                <label class="flex items-center gap-3 text-sm font-semibold text-[#727783]">
                    <input name="remember" value="1" type="checkbox" class="size-4 rounded border-[#e5e0df] text-[#a80606]">
                    Ingat saya
                </label>

                <button class="h-12 w-full rounded-xl bg-[#a80606] text-sm font-bold text-white shadow-[0_10px_20px_rgba(168,6,6,0.18)]">Masuk Admin</button>
            </form>

            <a href="{{ route('member.login') }}" class="mt-5 block text-center text-xs font-bold text-[#00407f]">Login Member</a>
        </section>
    </main>
</body>
</html>