@extends('backend.layout')

@section('title', 'User Management')

@section('content')
    <main class="min-h-screen px-5 pb-10 pt-[104px] lg:ml-[288px] lg:px-12">
        <section class="max-w-6xl">
            <h1 class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold">User Management</h1>
            <p class="mt-2 text-sm font-medium text-[#727783]">Kelola akses siswa, paket aktif, dan status akun.</p>

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
                                    <button class="rounded-lg px-3 py-2 text-xs font-bold text-[#00407f] hover:bg-[#00407f]/10">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection
