<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah User - Core Plasma</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-[#f5f6f6] text-[#1b1c1c] antialiased" style="font-family: Inter, ui-sans-serif, system-ui, sans-serif;">

    <main class="mx-auto flex w-full max-w-[980px] flex-col gap-8 px-5 py-10 sm:px-8 lg:py-14">
        <section class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
            <div>
                <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-[#00407f] hover:underline">
                    Back to users
                </a>
                <h1 class="mt-3 font-['Plus_Jakarta_Sans'] text-4xl font-extrabold leading-10 tracking-normal text-[#1b1c1c]">
                    Tambah User
                </h1>
                <p class="mt-1 text-base font-medium leading-6 text-[#727783]">
                    Tambahkan user baru untuk mengakses platform.
                </p>
            </div>
        </section>

        @if (session('success'))
            <div class="rounded-xl border border-[#8cfa96] bg-[#8cfa96]/25 px-4 py-3 text-sm font-semibold text-[#004b19]">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-[#a80606]/20 bg-[#a80606]/10 px-4 py-3 text-sm font-semibold text-[#7f1c00]">
                Ada input yang belum valid. Cek field yang ditandai.
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}" class="overflow-hidden rounded-2xl bg-white shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
            @csrf

            <div class="grid gap-6 p-6 md:grid-cols-2 lg:p-8">
                <div class="md:col-span-2">
                    <label for="name" class="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Nama Lengkap</label>
                    <input
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        type="text"
                        class="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                        required
                    >
                    @error('name')
                        <p class="mt-2 text-sm font-semibold text-[#a80606]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="email" class="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Email</label>
                    <input
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        type="email"
                        class="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                        required
                    >
                    @error('email')
                        <p class="mt-2 text-sm font-semibold text-[#a80606]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="password" class="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                        required
                    >
                    @error('password')
                        <p class="mt-2 text-sm font-semibold text-[#a80606]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="pendidikan_terakhir" class="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Pendidikan Terakhir</label>
                    <input
                        id="pendidikan_terakhir"
                        name="pendidikan_terakhir"
                        value="{{ old('pendidikan_terakhir') }}"
                        type="text"
                        list="education-options"
                        class="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                    >
                    <datalist id="education-options">
                        <option value="SMA/SMK"></option>
                        <option value="D3"></option>
                        <option value="S1"></option>
                        <option value="S2"></option>
                        <option value="S3"></option>
                    </datalist>
                    @error('pendidikan_terakhir')
                        <p class="mt-2 text-sm font-semibold text-[#a80606]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 bg-[#f0eded] px-6 py-4 sm:flex-row sm:justify-end lg:px-8">
                <a href="{{ route('admin.users.index') }}" class="inline-flex h-11 items-center justify-center rounded-xl px-5 text-sm font-semibold text-[#727783] transition hover:bg-white">
                    Cancel
                </a>
                <button type="submit" class="inline-flex h-11 items-center justify-center rounded-xl bg-gradient-to-br from-[#7f1c00] to-[#a80606] px-5 text-sm font-semibold text-white shadow-[0_10px_15px_-3px_rgba(0,64,127,0.18)] transition hover:translate-y-[-1px]">
                    Simpan User
                </button>
            </div>
        </form>
    </main>
</body>
</html>