import { Head, Link, useForm } from '@inertiajs/react';
import { type FormEvent } from 'react';

export default function MemberRegister() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    function handleSubmit(e: FormEvent) {
        e.preventDefault();
        post(route('member.register.store'));
    }

    return (
        <>
            <Head title="Daftar Member" />
            <div className="min-h-screen bg-[#f6f7f8] text-[#1b1c1c] antialiased" style={{ fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif' }}>
                <main className="grid min-h-screen place-items-center px-5 py-10">
                    <section className="w-full max-w-md rounded-2xl bg-white p-8 shadow-[0_16px_50px_rgba(0,0,0,0.06)]">
                        <p className="text-sm font-extrabold text-[#d40f22]">Core Plasma</p>
                        <h1 className="mt-3 text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Daftar Member</h1>
                        <p className="mt-2 text-sm font-medium text-[#727783]">Buat akun baru sebagai peserta.</p>

                        <form onSubmit={handleSubmit} className="mt-7 space-y-5">
                            <label className="block">
                                <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Nama</span>
                                <input
                                    name="name"
                                    type="text"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    required
                                    autoFocus
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e5e0df] px-4 text-sm font-semibold outline-none focus:border-[#a80606]"
                                />
                                {errors.name && <span className="mt-2 block text-xs font-semibold text-[#d40f22]">{errors.name}</span>}
                            </label>

                            <label className="block">
                                <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Email</span>
                                <input
                                    name="email"
                                    type="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e5e0df] px-4 text-sm font-semibold outline-none focus:border-[#a80606]"
                                />
                                {errors.email && <span className="mt-2 block text-xs font-semibold text-[#d40f22]">{errors.email}</span>}
                            </label>

                            <label className="block">
                                <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Password</span>
                                <input
                                    name="password"
                                    type="password"
                                    value={data.password}
                                    onChange={(e) => setData('password', e.target.value)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e5e0df] px-4 text-sm font-semibold outline-none focus:border-[#a80606]"
                                />
                                {errors.password && <span className="mt-2 block text-xs font-semibold text-[#d40f22]">{errors.password}</span>}
                            </label>

                            <label className="block">
                                <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Konfirmasi Password</span>
                                <input
                                    name="password_confirmation"
                                    type="password"
                                    value={data.password_confirmation}
                                    onChange={(e) => setData('password_confirmation', e.target.value)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e5e0df] px-4 text-sm font-semibold outline-none focus:border-[#a80606]"
                                />
                            </label>

                            <button
                                type="submit"
                                disabled={processing}
                                className="h-12 w-full rounded-xl bg-[#a80606] text-sm font-bold text-white shadow-[0_10px_20px_rgba(168,6,6,0.18)] disabled:opacity-70"
                            >
                                {processing ? 'Memproses...' : 'Daftar Member'}
                            </button>
                        </form>

                        <Link href={route('member.login')} className="mt-5 block text-center text-xs font-bold text-[#00407f]">
                            Sudah punya akun? Masuk
                        </Link>
                    </section>
                </main>
            </div>
        </>
    );
}
