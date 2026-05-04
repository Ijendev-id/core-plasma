@extends('backend.layout')

@section('title', 'User Management')

@section('content')
    <main class="min-h-screen px-5 pb-10 pt-[104px] lg:ml-[288px] lg:px-12">
        <section class="max-w-6xl">
            <div class="flex items-end justify-between">
                <div>
                    <h1 class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold">User Management</h1>
                    <p class="mt-2 text-sm font-medium text-[#727783]">Kelola akses siswa, paket aktif, dan status akun.</p>
                </div>
                <a href="{{ route('admin.users.create') }}" class="inline-flex h-11 items-center justify-center rounded-xl bg-gradient-to-br from-[#7f1c00] to-[#a80606] px-5 text-sm font-semibold text-white shadow-[0_10px_15px_-3px_rgba(0,64,127,0.18)] transition hover:translate-y-[-1px]">
                    + Tambah User
                </a>
            </div>

            @if (session('success'))
                <div class="mt-6 rounded-xl border border-[#8cfa96] bg-[#8cfa96]/25 px-4 py-3 text-sm font-semibold text-[#004b19]">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mt-8 overflow-hidden rounded-2xl bg-white shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#f6f3f2] text-xs font-bold uppercase tracking-[1px] text-[#727783]">
                        <tr>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Education</th>
                            <th class="px-6 py-4">Package</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0eded]">
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-6 py-5 font-bold">{{ $user['name'] }}</td>
                                <td class="px-6 py-5 text-[#727783]">{{ $user['email'] }}</td>
                                <td class="px-6 py-5">{{ $user['education'] }}</td>
                                <td class="px-6 py-5">{{ $user['package'] }}</td>
                                <td class="px-6 py-5">
                                    <span class="{{ $user['status'] === 'Active' ? 'bg-[#8cfa96]/40 text-[#004b19]' : 'bg-[#ffdbc8] text-[#984800]' }} rounded-full px-3 py-1 text-xs font-bold">{{ $user['status'] }}</span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <a href="{{ route('admin.users.edit', $user['id']) }}" class="rounded-lg px-3 py-2 text-xs font-bold text-[#00407f] hover:bg-[#00407f]/10">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user['id']) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg px-3 py-2 text-xs font-bold text-[#a80606] hover:bg-[#a80606]/10" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection
