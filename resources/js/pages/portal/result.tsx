import { Head, Link } from '@inertiajs/react';
import PortalLayout from '../../layouts/PortalLayout';

interface PackageInfo {
    name: string;
    slug: string;
    category: string;
}

interface ResultData {
    score: number;
    twk: number;
    tiu: number;
    tkp: number;
    correct: number;
    answered: number;
    total: number;
    status: string;
    duration: string;
}

interface Props {
    package: PackageInfo;
    result: ResultData;
}

export default function Result({ package: pkg, result }: Props) {
    const passed = result.status === 'Certified';

    return (
        <PortalLayout>
            <Head title={`Hasil - ${pkg.name}`} />
            <section className="mx-auto max-w-3xl">
                <div className="rounded-3xl bg-white p-8 text-center shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <p className="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">{pkg.category}</p>
                    <h1 className="mt-2 text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>{pkg.name}</h1>

                    <span className={`mt-4 inline-flex rounded-full px-4 py-2 text-sm font-bold ${passed ? 'bg-[#8cfa96]/40 text-[#004b19]' : 'bg-[#ffdbc8] text-[#984800]'}`}>
                        {passed ? 'LULUS' : 'BELUM LULUS'} · {result.status}
                    </span>

                    <div className="mt-6">
                        <p className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Total Skor</p>
                        <p className="text-6xl font-extrabold text-[#a80606]" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>{result.score}</p>
                    </div>

                    <div className="mt-8 grid grid-cols-3 gap-4">
                        {[
                            { label: 'TWK', value: result.twk },
                            { label: 'TIU', value: result.tiu },
                            { label: 'TKP', value: result.tkp },
                        ].map((s) => (
                            <div key={s.label} className="rounded-2xl bg-[#f6f3f2] p-5">
                                <p className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">{s.label}</p>
                                <p className="mt-2 text-2xl font-extrabold">{s.value}</p>
                            </div>
                        ))}
                    </div>

                    <div className="mt-6 grid grid-cols-3 gap-4 text-sm">
                        <div className="rounded-xl border border-[#f0eded] p-4">
                            <p className="text-xs font-semibold text-[#727783]">Benar</p>
                            <p className="mt-1 text-lg font-bold text-[#004b19]">{result.correct}/{result.total}</p>
                        </div>
                        <div className="rounded-xl border border-[#f0eded] p-4">
                            <p className="text-xs font-semibold text-[#727783]">Terjawab</p>
                            <p className="mt-1 text-lg font-bold">{result.answered}/{result.total}</p>
                        </div>
                        <div className="rounded-xl border border-[#f0eded] p-4">
                            <p className="text-xs font-semibold text-[#727783]">Durasi</p>
                            <p className="mt-1 text-lg font-bold">{result.duration}</p>
                        </div>
                    </div>

                    <div className="mt-8 flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
                        <Link href={route('leaderboard', { package: pkg.slug })} className="rounded-xl bg-[#00407f] px-6 py-3 text-sm font-bold text-white">
                            Lihat Leaderboard
                        </Link>
                        <Link href={route('tryouts.index')} className="rounded-xl bg-[#f6f3f2] px-6 py-3 text-sm font-bold text-[#1b1c1c]">
                            Kembali ke Tryout
                        </Link>
                    </div>
                </div>
            </section>
        </PortalLayout>
    );
}
