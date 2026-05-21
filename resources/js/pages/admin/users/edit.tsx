import { Head, Link, useForm } from '@inertiajs/react';
import { type FormEvent } from 'react';
import { type Member } from '../../../types';

const EDUCATION_OPTIONS = ['SMA/SMK', 'D3', 'S1', 'S2', 'S3'];

interface Props {
    member: Member;
    flash?: { success?: string };
}

export default function UserEdit({ member, flash }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        name: member.name,
        email: member.email,
        password: '',
        pendidikan_terakhir: member.pendidikan_terakhir ?? '',
    });

    function handleSubmit(e: FormEvent) {
        e.preventDefault();
        put(route('admin.users.update', member.id));
    }

    return (
        <>
            <Head title="Edit User" />
            <div className="min-h-screen bg-[#f5f6f6] text-[#1b1c1c] antialiased" style={{ fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif' }}>
                <main className="mx-auto flex w-full max-w-[980px] flex-col gap-8 px-5 py-10 sm:px-8 lg:py-14">
                    <section className="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                        <div>
                            <Link href={route('admin.users.index')} className="text-sm font-semibold text-[#00407f] hover:underline">
                                Back to users
                            </Link>
                            <h1 className="mt-3 text-4xl font-extrabold leading-10 text-[#1b1c1c]" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                                Edit User
                            </h1>
                            <p className="mt-1 text-base font-medium leading-6 text-[#727783]">Edit informasi user.</p>
                        </div>
                    </section>

                    {flash?.success && (
                        <div className="rounded-xl border border-[#8cfa96] bg-[#8cfa96]/25 px-4 py-3 text-sm font-semibold text-[#004b19]">
                            {flash.success}
                        </div>
                    )}

                    {Object.keys(errors).length > 0 && (
                        <div className="rounded-xl border border-[#a80606]/20 bg-[#a80606]/10 px-4 py-3 text-sm font-semibold text-[#7f1c00]">
                            Ada input yang belum valid. Cek field yang ditandai.
                        </div>
                    )}

                    <form onSubmit={handleSubmit} className="overflow-hidden rounded-2xl bg-white shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                        <div className="grid gap-6 p-6 md:grid-cols-2 lg:p-8">
                            <div className="md:col-span-2">
                                <label htmlFor="name" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Nama Lengkap</label>
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                                />
                                {errors.name && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.name}</p>}
                            </div>

                            <div className="md:col-span-2">
                                <label htmlFor="email" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Email</label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                                />
                                {errors.email && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.email}</p>}
                            </div>

                            <div className="md:col-span-2">
                                <label htmlFor="password" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">
                                    Password (Kosongkan jika tidak ingin mengubah)
                                </label>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    value={data.password}
                                    onChange={(e) => setData('password', e.target.value)}
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                                />
                                {errors.password && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.password}</p>}
                            </div>

                            <div className="md:col-span-2">
                                <label htmlFor="pendidikan_terakhir" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Pendidikan Terakhir</label>
                                <input
                                    id="pendidikan_terakhir"
                                    name="pendidikan_terakhir"
                                    type="text"
                                    list="education-options"
                                    value={data.pendidikan_terakhir}
                                    onChange={(e) => setData('pendidikan_terakhir', e.target.value)}
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                                />
                                <datalist id="education-options">
                                    {EDUCATION_OPTIONS.map((opt) => <option key={opt} value={opt} />)}
                                </datalist>
                                {errors.pendidikan_terakhir && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.pendidikan_terakhir}</p>}
                            </div>
                        </div>

                        <div className="flex flex-col-reverse gap-3 bg-[#f0eded] px-6 py-4 sm:flex-row sm:justify-end lg:px-8">
                            <Link href={route('admin.users.index')} className="inline-flex h-11 items-center justify-center rounded-xl px-5 text-sm font-semibold text-[#727783] transition hover:bg-white">
                                Cancel
                            </Link>
                            <button
                                type="submit"
                                disabled={processing}
                                className="inline-flex h-11 items-center justify-center rounded-xl bg-gradient-to-br from-[#7f1c00] to-[#a80606] px-5 text-sm font-semibold text-white shadow-[0_10px_15px_-3px_rgba(0,64,127,0.18)] transition hover:-translate-y-px disabled:opacity-70"
                            >
                                {processing ? 'Menyimpan...' : 'Update User'}
                            </button>
                        </div>
                    </form>
                </main>
            </div>
        </>
    );
}
