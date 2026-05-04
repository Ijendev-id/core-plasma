@extends('backend.layout')

@section('title', 'User Management')

@section('content')
    <main class="min-h-screen px-5 pb-10 pt-[104px] lg:ml-[288px] lg:px-12">
        <section>
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
                                    <button type="button" class="rounded-lg px-3 py-2 text-xs font-bold text-[#a80606] hover:bg-[#a80606]/10" onclick="document.getElementById('delete-modal-{{ $user['id'] }}').showModal()">Hapus</button>
                                </td>
                            </tr>

                            <dialog id="delete-modal-{{ $user['id'] }}" class="modal rounded-2xl p-6 backdrop:bg-black/50">
                                <div class="mb-4 text-left">
                                    <h3 class="text-xl font-bold text-[#1b1c1c]">Hapus User</h3>
                                    <p class="mt-2 text-sm text-[#727783]">Apakah Anda yakin ingin menghapus <span class="font-bold text-[#1b1c1c]">{{ $user['name'] }}</span>?</p>
                                    <p class="text-xs text-[#a80606]">Tindakan ini tidak dapat dibatalkan.</p>
                                </div>
                                <div class="flex justify-end gap-3">
                                    <button type="button" class="rounded-xl bg-[#f0eded] px-4 py-2 text-sm font-semibold text-[#727783] hover:bg-[#e0dddd]" onclick="document.getElementById('delete-modal-{{ $user['id'] }}').close()">Batal</button>
                                    <form action="{{ route('admin.users.destroy', $user['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-xl bg-[#a80606] px-4 py-2 text-sm font-semibold text-white hover:bg-[#7f1c00]">Hapus</button>
                                    </form>
                                </div>
                            </dialog>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection
