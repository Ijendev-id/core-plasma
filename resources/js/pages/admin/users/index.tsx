import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import AdminLayout from '../../../layouts/AdminLayout';

interface User {
    id: number;
    name: string;
    email: string;
    education: string;
    package: string;
    status: string;
}

interface Props {
    users: User[];
    flash?: { success?: string };
}

export default function UsersIndex({ users, flash }: Props) {
    const [deleteId, setDeleteId] = useState<number | null>(null);

    function handleDelete(id: number) {
        router.delete(route('admin.users.destroy', id), {
            onSuccess: () => setDeleteId(null),
        });
    }

    return (
        <AdminLayout>
            <Head title="User Management" />
            <main className="min-h-screen px-5 pb-10 pt-[104px] lg:ml-[288px] lg:px-12">
                <section>
                    <div className="flex items-end justify-between">
                        <div>
                            <h1 className="text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>User Management</h1>
                            <p className="mt-2 text-sm font-medium text-[#727783]">Kelola akses siswa, paket aktif, dan status akun.</p>
                        </div>
                        <Link
                            href={route('admin.users.create')}
                            className="inline-flex h-11 items-center justify-center rounded-xl bg-gradient-to-br from-[#7f1c00] to-[#a80606] px-5 text-sm font-semibold text-white shadow-[0_10px_15px_-3px_rgba(0,64,127,0.18)] transition hover:-translate-y-px"
                        >
                            + Tambah User
                        </Link>
                    </div>

                    {flash?.success && (
                        <div className="mt-6 rounded-xl border border-[#8cfa96] bg-[#8cfa96]/25 px-4 py-3 text-sm font-semibold text-[#004b19]">
                            {flash.success}
                        </div>
                    )}

                    <div className="mt-8 overflow-hidden rounded-2xl bg-white shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                        <table className="w-full text-left text-sm">
                            <thead className="bg-[#f6f3f2] text-xs font-bold uppercase tracking-[1px] text-[#727783]">
                                <tr>
                                    <th className="px-6 py-4">User</th>
                                    <th className="px-6 py-4">Email</th>
                                    <th className="px-6 py-4">Education</th>
                                    <th className="px-6 py-4">Package</th>
                                    <th className="px-6 py-4">Status</th>
                                    <th className="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-[#f0eded]">
                                {users.map((user) => (
                                    <tr key={user.id}>
                                        <td className="px-6 py-5 font-bold">{user.name}</td>
                                        <td className="px-6 py-5 text-[#727783]">{user.email}</td>
                                        <td className="px-6 py-5">{user.education}</td>
                                        <td className="px-6 py-5">{user.package}</td>
                                        <td className="px-6 py-5">
                                            <span className={`rounded-full px-3 py-1 text-xs font-bold ${user.status === 'Active' ? 'bg-[#8cfa96]/40 text-[#004b19]' : 'bg-[#ffdbc8] text-[#984800]'}`}>
                                                {user.status}
                                            </span>
                                        </td>
                                        <td className="px-6 py-5 text-right">
                                            <Link href={route('admin.users.edit', user.id)} className="rounded-lg px-3 py-2 text-xs font-bold text-[#00407f] hover:bg-[#00407f]/10">
                                                Edit
                                            </Link>
                                            <button
                                                type="button"
                                                onClick={() => setDeleteId(user.id)}
                                                className="rounded-lg px-3 py-2 text-xs font-bold text-[#a80606] hover:bg-[#a80606]/10"
                                            >
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>

            {/* Delete Modal */}
            {deleteId !== null && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                    <div className="w-full max-w-sm rounded-2xl bg-white p-6">
                        <h3 className="text-xl font-bold text-[#1b1c1c]">Hapus User</h3>
                        <p className="mt-2 text-sm text-[#727783]">
                            Apakah Anda yakin ingin menghapus user ini?
                        </p>
                        <p className="text-xs text-[#a80606]">Tindakan ini tidak dapat dibatalkan.</p>
                        <div className="mt-4 flex justify-end gap-3">
                            <button
                                type="button"
                                onClick={() => setDeleteId(null)}
                                className="rounded-xl bg-[#f0eded] px-4 py-2 text-sm font-semibold text-[#727783] hover:bg-[#e0dddd]"
                            >
                                Batal
                            </button>
                            <button
                                type="button"
                                onClick={() => handleDelete(deleteId)}
                                className="rounded-xl bg-[#a80606] px-4 py-2 text-sm font-semibold text-white hover:bg-[#7f1c00]"
                            >
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </AdminLayout>
    );
}
