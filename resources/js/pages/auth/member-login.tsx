import { Head, Link, useForm } from '@inertiajs/react';
import { type FormEvent } from 'react';

export default function MemberLogin() {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    function handleSubmit(e: FormEvent) {
        e.preventDefault();
        post(route('member.login.store'));
    }

    return (
        <>
            <Head title="Login Member - Core Plasma" />
            <div
                className="min-h-screen text-[#1b1c1c] antialiased"
                style={{
                    fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif',
                    background: 'linear-gradient(135deg, #fff5f5 0%, #ffffff 60%, #fff0f0 100%)',
                }}
            >
                <main className="grid min-h-screen place-items-center px-5 py-10">
                    <section className="w-full max-w-md rounded-2xl bg-white p-8 shadow-[0_16px_50px_rgba(0,0,0,0.06)]">
                        <p className="text-sm font-extrabold text-[#d40f22]">Core Plasma</p>
                        <h1
                            className="mt-3 text-3xl font-extrabold"
                            style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}
                        >
                            Login Member
                        </h1>
                        <p className="mt-2 text-sm font-medium text-[#727783]">
                            Masuk untuk mengakses try out, leaderboard, dan analisis skormu.
                        </p>

                        <form onSubmit={handleSubmit} className="mt-7 space-y-5">
                            <label className="block">
                                <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">
                                    Email
                                </span>
                                <input
                                    name="email"
                                    type="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    required
                                    autoFocus
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e5e0df] px-4 text-sm font-semibold outline-none transition focus:border-[#a80606]"
                                />
                                {errors.email && (
                                    <span className="mt-2 block text-xs font-semibold text-[#d40f22]">
                                        {errors.email}
                                    </span>
                                )}
                            </label>

                            <label className="block">
                                <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">
                                    Password
                                </span>
                                <input
                                    name="password"
                                    type="password"
                                    value={data.password}
                                    onChange={(e) => setData('password', e.target.value)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e5e0df] px-4 text-sm font-semibold outline-none transition focus:border-[#a80606]"
                                />
                                {errors.password && (
                                    <span className="mt-2 block text-xs font-semibold text-[#d40f22]">
                                        {errors.password}
                                    </span>
                                )}
                            </label>

                            <label className="flex items-center gap-3 text-sm font-semibold text-[#727783]">
                                <input
                                    name="remember"
                                    type="checkbox"
                                    checked={data.remember}
                                    onChange={(e) => setData('remember', e.target.checked)}
                                    className="size-4 rounded border-[#e5e0df] text-[#a80606]"
                                />
                                Ingat saya
                            </label>

                            <button
                                type="submit"
                                disabled={processing}
                                className="h-12 w-full rounded-xl bg-[#a80606] text-sm font-bold text-white shadow-[0_10px_20px_rgba(168,6,6,0.18)] transition hover:bg-[#8a0505] disabled:opacity-70"
                            >
                                {processing ? 'Memproses...' : 'Masuk'}
                            </button>
                        </form>

                        <p className="mt-6 text-center text-xs font-semibold text-[#727783]">
                            Belum punya akun?{' '}
                            <Link href={route('member.register')} className="font-bold text-[#d40f22] hover:underline">
                                Daftar sekarang
                            </Link>
                        </p>

                        <div className="mt-8 border-t border-[#eee] pt-5 text-center">
                            <a
                                href="/"
                                className="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-[1px] text-[#727783] transition hover:text-[#d40f22]"
                            >
                                <span aria-hidden="true">&larr;</span>
                                <span>Kembali ke Beranda</span>
                            </a>
                        </div>
                    </section>
                </main>
            </div>
        </>
    );
}