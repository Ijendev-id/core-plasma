import { Head, Link } from '@inertiajs/react';
import { useMemo, useState } from 'react';
import PortalLayout from '../../layouts/PortalLayout';

interface MyTryout {
    attempt_id: number | null;
    package_name: string;
    package_slug: string;
    category: string;
    score: number;
    twk: number;
    tiu: number;
    tkp: number;
    status: string;
    date: string;
    duration: string;
    certificate_printed_at: string | null;
}

interface Package {
    name: string;
    slug: string;
    category: string;
    question_count: number;
    progress: number;
    price: string;
    duration: string;
    leaderboard_price: number;
}

interface TopRow {
    rank: number;
    name: string;
    score: number;
}

interface Props {
    myTryouts: MyTryout[];
    myCategories: string[];
    packages: Package[];
    topByPackage: Record<string, TopRow[]>;
}
function LockBadge() {
    return (
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
        </svg>
    );
}

function rankLabel(rank: number): string {
    if (rank === 1) return '1ST';
    if (rank === 2) return '2ND';
    if (rank === 3) return '3RD';
    return rank + 'TH';
}

interface LeaderboardProps {
    myTryouts: MyTryout[];
    packages: Package[];
    topByPackage: Record<string, TopRow[]>;
}

function LeaderboardCard({ myTryouts, packages, topByPackage }: LeaderboardProps) {
    // Lock dihitung PER TRY OUT (per paket). Tiap paket punya leaderboard_price sendiri.
    // Paket dengan leaderboard_price = 0 dianggap gratis (tidak di-blur). Default fee
    // fallback Rp 29.000 untuk popup kalau admin belum isi harga.
    const packagePriceMap = useMemo(() => {
        const m = new Map<string, number>();
        packages.forEach((p) => m.set(p.slug, p.leaderboard_price || 0));
        return m;
    }, [packages]);

    const [selectedSlug, setSelectedSlug] = useState<string>('');

    const orderedTryouts = useMemo(
        () => [...myTryouts].sort((a, b) => b.score - a.score),
        [myTryouts],
    );

    const activeSlug = selectedSlug || orderedTryouts[0]?.package_slug || '';
    const activeAttempt = orderedTryouts.find((t) => t.package_slug === activeSlug);
    const activePrice = activeSlug ? packagePriceMap.get(activeSlug) ?? 0 : 0;
    // Default terkunci selama ada try out yang dipilih (konsisten dengan /leaderboard).
    // Paket dengan leaderboard_price = 0 tetap dianggap free (tidak perlu unlock),
    // tapi UI defaultnya blur + popup hingga admin set harga unlock di form paket.
    const isLocked = activeSlug !== '';
    const displayPrice = activePrice > 0 ? activePrice : 29000;
    const formattedPrice = 'Rp ' + displayPrice.toLocaleString('id-ID');

    if (myTryouts.length === 0) {
        return (
            <div className="relative mt-4 rounded-3xl bg-white p-8 text-center shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                <p className="text-sm font-semibold text-[#727783]">Belum ada skor. Kerjakan tryout untuk masuk leaderboard.</p>
            </div>
        );
    }

    // Data podium/tabel untuk try out yang dipilih: ambil dari topByPackage (semua member),
    // fallback ke attempt member ini sendiri bila datanya belum ada.
    const activeRows: TopRow[] = activeSlug
        ? (topByPackage[activeSlug] && topByPackage[activeSlug].length > 0
            ? topByPackage[activeSlug]
            : orderedTryouts
                .filter((t) => t.package_slug === activeSlug)
                .map((t, i): TopRow => ({ rank: i + 1, name: 'Kamu', score: t.score })))
        : [];

    return (
        <div className="relative mt-4 rounded-3xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
            {/* Chips filter per try out */}
            <div className="flex flex-wrap justify-center gap-2">
                {orderedTryouts.map((t) => {
                    const price = packagePriceMap.get(t.package_slug) ?? 0;
                    const locked = price > 0;
                    return (
                        <button
                            key={t.package_slug}
                            type="button"
                            onClick={() => setSelectedSlug(t.package_slug)}
                            className={
                                'inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold transition ' +
                                (activeSlug === t.package_slug
                                    ? 'bg-[#d40f22] text-white'
                                    : 'bg-[#f8f7f7] text-[#727783] hover:bg-[#f0eded]')
                            }
                        >
                            <span>{t.package_name}</span>
                            {locked ? <LockBadge /> : null}
                        </button>
                    );
                })}
            </div>

            {activeAttempt ? (
                <p className="mt-3 text-center text-xs font-semibold text-[#727783]">
                    Skor kamu: <span className="font-extrabold text-[#d40f22]">{activeAttempt.score}</span>
                    {activePrice > 0 ? <span className="ml-2">· Buka leaderboard {formattedPrice}</span> : null}
                </p>
            ) : null}

            <div className={isLocked ? 'pointer-events-none select-none blur-[8px] opacity-60 transition duration-300' : ''}>
                <div className="mt-4 grid items-end gap-4 md:grid-cols-3">
                    {activeRows.slice(0, 3).map((person) => (
                        <div
                            key={person.rank}
                            className={
                                'rounded-3xl p-5 text-center ' +
                                (person.rank === 1
                                    ? 'order-first bg-[#d40f22] text-white md:order-none md:min-h-[180px]'
                                    : 'bg-[#f4f6f8]')
                            }
                        >
                            <div className="mx-auto size-14 rounded-full bg-[#ffd12e]"></div>
                            <p className="mt-3 text-sm font-bold">{person.name}</p>
                            <p className="mt-2 text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>{rankLabel(person.rank)}</p>
                            <p className={'mt-1 text-xs font-semibold ' + (person.rank === 1 ? 'text-white/80' : 'text-[#727783]')}>
                                {person.score} point
                            </p>
                        </div>
                    ))}
                </div>
                {activeRows.length > 3 && (
                    <div className="mt-6 overflow-hidden rounded-2xl border border-[#f0eded]">
                        <table className="w-full text-left text-sm">
                            <thead className="bg-[#f8f7f7] text-xs font-bold uppercase tracking-[1px] text-[#727783]">
                                <tr>
                                    <th className="px-5 py-3">Ranking</th>
                                    <th className="px-5 py-3">Nama</th>
                                    <th className="px-5 py-3 text-right">Skor</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-[#f0eded]">
                                {activeRows.slice(3).map((row) => (
                                    <tr key={row.rank}>
                                        <td className="px-5 py-3 font-bold">{row.rank}</td>
                                        <td className="px-5 py-3 font-semibold">{row.name}</td>
                                        <td className="px-5 py-3 text-right font-bold text-[#d40f22]">{row.score}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                )}
            </div>
            {isLocked && (
                <div className="absolute inset-0 z-10 flex items-center justify-center rounded-3xl bg-white/10">
                    <div className="mx-4 w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-[0_24px_80px_rgba(0,0,0,0.2)]">
                        <div className="mx-auto flex size-12 items-center justify-center rounded-full bg-[#fff0f0] text-[#d40f22]">
                            <LockBadge />
                        </div>
                        <h3 className="mt-3 text-lg font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Buka Leaderboard</h3>
                        <p className="mt-2 text-sm leading-6 text-[#727783]">
                            Lihat peringkat lengkap dengan <span className="font-bold text-[#d40f22]">Core Plasma Pro</span> mulai {formattedPrice}.
                        </p>
                        <Link href={route('payment')} className="mt-5 flex w-full justify-center rounded-xl bg-[#d40f22] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#b90d1c]">
                            Buka Leaderboard
                        </Link>
                    </div>
                </div>
            )}
        </div>
    );
}

export default function Tryouts({ myTryouts, myCategories, packages, topByPackage }: Props) {
    const [category, setCategory] = useState('');

    const sortedCategories = useMemo(
        () => [...myCategories].sort((a, b) => a.localeCompare(b)),
        [myCategories],
    );

    const filteredMyTryouts = useMemo(
        () => (category ? myTryouts.filter((t) => t.category === category) : myTryouts),
        [myTryouts, category],
    );

    return (
        <PortalLayout>
            <Head title="Paket Try Out" />
            <section className="max-w-5xl">
                <div className="flex items-end justify-between gap-6">
                    <div>
                        <h1 className="text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Try Out</h1>
                        <p className="mt-2 text-sm font-medium text-[#727783]">Latihan penalaran dengan bank soal yang sudah disiapkan.</p>
                    </div>
                </div>

                {/* Tryout Saya */}
                <section className="mt-8">
                    <div className="flex flex-wrap items-center justify-between gap-3">
                        <h2 className="text-xl font-bold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Tryout Saya</h2>
                        <select
                            value={category}
                            onChange={(e) => setCategory(e.target.value)}
                            className="h-10 rounded-xl border border-[#e5e0df] bg-white px-3 text-sm font-semibold uppercase outline-none focus:border-[#a80606]"
                        >
                            <option value="">Semua Kategori</option>
                            {sortedCategories.map((c) => (
                                <option key={c} value={c}>{c}</option>
                            ))}
                        </select>
                    </div>
                    {filteredMyTryouts.length === 0 ? (
                        <div className="mt-4 rounded-2xl bg-white p-8 text-center shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                            <p className="text-sm font-semibold text-[#727783]">
                                {myTryouts.length === 0 ? 'Kamu belum mengerjakan tryout apapun. Yuk mulai!' : 'Tidak ada tryout pada kategori ini.'}
                            </p>
                        </div>
                    ) : (
                        <div className="mt-4 space-y-4">
                            {filteredMyTryouts.map((tryout, i) => (
                                <div key={i} className="rounded-2xl bg-white p-5 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                                    <div className="flex items-start justify-between gap-4">
                                        <div className="flex-1">
                                            <div className="flex items-center gap-3">
                                                <h3 className="text-base font-bold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>{tryout.package_name}</h3>
                                                <span className="rounded-full bg-[#eef2f7] px-2 py-0.5 text-[10px] font-bold uppercase text-[#00407f]">{tryout.category}</span>
                                                <span className="rounded-full bg-[#fff1d9] px-2 py-0.5 text-[10px] font-bold text-[#984800]">{tryout.status}</span>
                                            </div>
                                            <p className="mt-1 text-xs text-[#727783]">{tryout.date} � {tryout.duration}</p>
                                            <div className="mt-4 grid grid-cols-4 gap-2">
                                                {[
                                                    { label: 'Score', value: tryout.score, highlight: true },
                                                    { label: 'TWK', value: tryout.twk },
                                                    { label: 'TIU', value: tryout.tiu },
                                                    { label: 'TKP', value: tryout.tkp },
                                                ].map((stat) => (
                                                    <div key={stat.label} className="rounded-lg bg-[#f8f7f7] p-2 text-center">
                                                        <p className="text-[10px] font-semibold text-[#727783]">{stat.label}</p>
                                                        <p className={`mt-0.5 text-sm font-extrabold ${stat.highlight ? 'text-[#d40f22]' : ''}`}>{stat.value}</p>
                                                    </div>
                                                ))}
                                            </div>
                                        </div>
                                        {tryout.certificate_printed_at ? (
                                            <span
                                                title="Sertifikat sudah dicetak, ulangi dinonaktifkan."
                                                className="shrink-0 cursor-not-allowed rounded-xl bg-[#e5e7eb] px-4 py-2 text-xs font-bold text-[#9ca3af]"
                                            >
                                                Ulangi (Terkunci)
                                            </span>
                                        ) : (
                                            <Link href={route('tryouts.play', { package: tryout.package_slug })} className="shrink-0 rounded-xl bg-[#a80606] px-4 py-2 text-xs font-bold text-white">
                                                Mulai Ulang
                                            </Link>
                                        )}
                                        {tryout.status === 'Certified' && tryout.attempt_id && (
                                            <Link
                                                href={route('tryouts.result', { package: tryout.package_slug, attempt: tryout.attempt_id })}
                                                className="shrink-0 rounded-xl bg-[#004b19] px-4 py-2 text-xs font-bold text-white"
                                            >
                                                Cetak Sertifikat
                                            </Link>
                                        )}
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </section>

                {/* Paket Tersedia */}
                <section className="mt-10">
                    <h2 className="text-xl font-bold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Paket Tryout Tersedia</h2>
                    <div className="mt-4 grid gap-5 md:grid-cols-3">
                        {packages.length === 0 ? (
                            <div className="col-span-full rounded-2xl bg-white p-8 text-center shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                                <p className="text-sm font-semibold text-[#727783]">Belum ada paket tryout tersedia.</p>
                            </div>
                        ) : (
                            packages.map((pkg, i) => (
                                <article key={i} className="rounded-2xl bg-white p-5 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                                    <div className="flex items-center justify-between">
                                        <span className="rounded-full bg-[#fff1d9] px-3 py-1 text-[10px] font-bold text-[#984800]">{pkg.category}</span>
                                        <span className="text-[10px] font-bold text-[#727783]">{pkg.duration}</span>
                                    </div>
                                    <h3 className="mt-5 min-h-[56px] text-lg font-bold leading-7" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>{pkg.name}</h3>
                                    <p className="mt-3 text-xs font-semibold text-[#727783]">{pkg.question_count} soal tryout premium</p>
                                    <div className="mt-4 h-2 overflow-hidden rounded-full bg-[#eae7e7]">
                                        <div className="h-full rounded-full bg-[#d40f22]" style={{ width: `${pkg.progress}%` }} />
                                    </div>
                                    <div className="mt-5 flex items-center justify-between">
                                        <span className="text-sm font-extrabold text-[#00407f]">{pkg.price}</span>
                                        <Link href={route('tryouts.play', { package: pkg.slug })} className="rounded-xl bg-[#a80606] px-4 py-2 text-xs font-bold text-white">
                                            Mulai Latihan
                                        </Link>
                                    </div>
                                </article>
                            ))
                        )}
                    </div>

                </section>
                {/* Leaderboard ringkas + sistem lock */}
                <section className="mt-10">
                    <div className="flex flex-wrap items-end justify-between gap-4">
                        <div>
                            <p className="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">Leaderboard</p>
                            <h2 className="mt-1 text-xl font-bold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Puncak Peringkat</h2>
                            <p className="mt-1 text-sm font-medium text-[#727783]">Skor tertinggi dari tryout yang sudah kamu kerjakan.</p>
                        </div>
                        <Link href={route('leaderboard')} className="rounded-xl border border-[#e5e0df] bg-white px-4 py-2 text-xs font-bold text-[#1b1c1c] hover:bg-[#f6f3f2]">
                            Lihat Lengkap
                        </Link>
                    </div>
                    <LeaderboardCard myTryouts={myTryouts} packages={packages} topByPackage={topByPackage} />
                </section>
            </section>
        </PortalLayout>
    );
}
