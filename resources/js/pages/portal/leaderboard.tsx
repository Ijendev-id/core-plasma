import { Head, Link } from '@inertiajs/react';
import PortalLayout from '../../layouts/PortalLayout';

interface PodiumPerson {
    rank: number;
    name: string;
    score: number;
}

interface LeaderboardRow {
    rank: number;
    name: string;
    twk: number;
    tiu: number;
    tkp: number;
    total: number;
}

interface Package {
    name: string;
    slug: string;
    price: number;
}

interface Entry {
    package: Package;
    isLocked: boolean;
    podium: PodiumPerson[];
    rows: LeaderboardRow[];
}

interface Props {
    packages: Package[];
    selectedPackage: Package | null;
    isLocked: boolean;
    podium: PodiumPerson[];
    rows: LeaderboardRow[];
    entries: Entry[];
}

function rankLabel(rank: number): string {
    if (rank === 1) return '1ST';
    if (rank === 2) return '2ND';
    if (rank === 3) return '3RD';
    return `${rank}TH`;
}

// Menambahkan komponen LockIcon secara langsung agar tidak error
const LockIcon = () => (
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="text-[#d40f22]">
        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
    </svg>
);

export default function Leaderboard({ packages, selectedPackage, isLocked, podium, rows, entries }: Props) {


    return (
        <PortalLayout>
            <Head title="Leaderboard" />
            <section className="relative max-w-5xl mx-auto">
                <div className="text-center">
                    <p className="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">Leaderboard</p>
                    <h1 className="mt-2 text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Puncak Pretul</h1>
                    <p className="mt-2 text-sm font-medium text-[#727783]">Peringkat per try out yang kamu ikuti. Buka masing-masing untuk lihat detail.</p>

                    {packages.length > 0 ? (
                        <div className="mt-4 flex flex-wrap justify-center gap-2">
                            {packages.map((pkg) => (
                                <Link
                                    key={pkg.slug}
                                    href={route('leaderboard', { package: pkg.slug })}
                                    className={
                                        'rounded-full px-3 py-1 text-xs font-bold transition ' +
                                        (selectedPackage?.slug === pkg.slug
                                            ? 'bg-[#d40f22] text-white'
                                            : 'bg-[#f8f7f7] text-[#727783] hover:bg-[#f0eded]')
                                    }
                                >
                                    {pkg.name}
                                </Link>
                            ))}
                        </div>
                    ) : null}
                </div>

                {entries.length === 0 ? (
                    <div className="mt-8 rounded-2xl bg-[#f8f7f7] p-8 text-center">
                        <p className="text-sm font-semibold text-[#727783]">
                            Kamu belum mengikuti tryout apapun. Pilih paket di halaman Try Out untuk mulai.
                        </p>
                        <Link
                            href={route('tryouts.index')}
                            className="mt-4 inline-flex rounded-xl bg-[#d40f22] px-5 py-2 text-xs font-bold text-white transition hover:bg-[#b90d1c]"
                        >
                            Lihat Paket Try Out
                        </Link>
                    </div>
                ) : (
                    <div className="mt-8 space-y-6">
                        {entries.map((entry) => {
                            const displayPrice = entry.package.price > 0 ? entry.package.price : 29000;
                            return (
                                <div
                                    key={entry.package.slug}
                                    className="relative rounded-3xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]"
                                >
                                    <div className="flex flex-wrap items-center justify-between gap-3">
                                        <h2 className="text-xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                                            {entry.package.name}
                                        </h2>
                                        <span className="text-[10px] font-bold uppercase tracking-[1px] text-[#727783]">
                                            {entry.package.price > 0 ? 'Terkunci � Rp ' + displayPrice.toLocaleString('id-ID') : 'Terbuka'}
                                        </span>
                                    </div>

                                    <div
                                        className={
                                            entry.isLocked
                                                ? 'pointer-events-none select-none blur-[8px] opacity-60 transition duration-300'
                                                : ''
                                        }
                                    >
                                        <div className="mt-5 grid items-end gap-4 md:grid-cols-3">
                                            {entry.podium.length === 0 ? (
                                                <div className="col-span-3 rounded-2xl bg-[#f8f7f7] p-6 text-center">
                                                    <p className="text-sm font-semibold text-[#727783]">Belum ada peserta untuk tryout ini.</p>
                                                </div>
                                            ) : (
                                                entry.podium.map((person) => (
                                                    <div
                                                        key={person.rank}
                                                        className={
                                                            'rounded-3xl p-5 text-center ' +
                                                            (person.rank === 1
                                                                ? 'order-first bg-[#d40f22] text-white md:order-none md:min-h-[170px]'
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
                                                ))
                                            )}
                                        </div>

                                        {entry.rows.length > 0 ? (
                                            <div className="mt-5 overflow-hidden rounded-2xl border border-[#f0eded]">
                                                <table className="w-full text-left text-sm">
                                                    <thead className="bg-[#f8f7f7] text-xs font-bold uppercase tracking-[1px] text-[#727783]">
                                                        <tr>
                                                            <th className="px-5 py-3">Ranking</th>
                                                            <th className="px-5 py-3">Nama</th>
                                                            <th className="px-5 py-3">TWK</th>
                                                            <th className="px-5 py-3">TIU</th>
                                                            <th className="px-5 py-3">TKP</th>
                                                            <th className="px-5 py-3 text-right">Total Score</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody className="divide-y divide-[#f0eded]">
                                                        {entry.rows.map((row) => (
                                                            <tr key={row.rank}>
                                                                <td className="px-5 py-3 font-bold">{row.rank}</td>
                                                                <td className="px-5 py-3 font-semibold">{row.name}</td>
                                                                <td className="px-5 py-3">{row.twk}</td>
                                                                <td className="px-5 py-3">{row.tiu}</td>
                                                                <td className="px-5 py-3">{row.tkp}</td>
                                                                <td className="px-5 py-3 text-right font-bold text-[#d40f22]">{row.total}</td>
                                                            </tr>
                                                        ))}
                                                    </tbody>
                                                </table>
                                            </div>
                                        ) : null}
                                    </div>

                                                                        {entry.isLocked ? (
                                        <div className="absolute inset-0 z-10 flex items-center justify-center rounded-3xl bg-white/60 backdrop-blur-[2px]">
                                            <div className="mx-4 w-full max-w-sm rounded-2xl bg-white p-8 text-center shadow-[0_24px_80px_rgba(0,0,0,0.2)]">
                                                <div className="mx-auto flex size-14 items-center justify-center rounded-full bg-[#fff0f0]">
                                                    <LockIcon />
                                                </div>
                                                <h3 className="mt-4 text-xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Buka Leaderboard</h3>
                                                <p className="mt-3 text-sm leading-6 text-[#727783]">
                                                    Lihat peringkat lengkap untuk <span className="font-bold text-[#d40f22]">{entry.package.name}</span> dengan Core Plasma Pro mulai Rp {displayPrice.toLocaleString('id-ID')}.
                                                </p>
                                                <Link
                                                    href={route('payment')}
                                                    className="mt-6 flex w-full justify-center rounded-xl bg-[#d40f22] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#b90d1c]"
                                                >
                                                    Buka Leaderboard
                                                </Link>
                                            </div>
                                        </div>
                                    ) : null}

                                </div>
                            );
                        })}
                    </div>
                )}
            </section>
        </PortalLayout>
    );
}
