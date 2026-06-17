import { Head, router } from '@inertiajs/react';
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

interface Props {
    packages: Package[];
    selectedPackage: Package | null;
    isLocked: boolean;
    podium: PodiumPerson[];
    rows: LeaderboardRow[];
}

function rankLabel(rank: number): string {
    if (rank === 1) return '1ST';
    if (rank === 2) return '2ND';
    if (rank === 3) return '3RD';
    return `${rank}TH`;
}

export default function Leaderboard({ podium, rows }: Props) {
    const isLocked = true;

    return (
        <PortalLayout>
            <Head title="Leaderboard" />
            <section className="relative max-w-5xl">
                {isLocked ? (
                    <div className="fixed inset-0 z-30 flex items-center justify-center bg-black/45 px-4">
                        <div className="w-full max-w-md rounded-3xl bg-white p-8 text-center shadow-[0_24px_80px_rgba(0,0,0,0.25)]">
                            <p className="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">Leaderboard Terkunci</p>
                            <h2 className="mt-3 text-2xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                                Buka leaderboard sekarang
                            </h2>
                            <p className="mt-3 text-sm leading-6 text-[#727783]">
                                Akses hasil lengkap dan ranking peserta setelah membuka tampilan leaderboard.
                            </p>
                            <div className="mt-6 flex flex-col gap-3 sm:flex-row">
                                <Link
                                    href={route('payment')}
                                    className="inline-flex flex-1 items-center justify-center rounded-xl bg-[#d40f22] px-5 py-3 text-sm font-bold text-white"
                                >
                                    Buka leaderboard sekarang
                                </Link>
                            </div>
                        </div>
                    </div>
                ) : null}

                <div className={`rounded-3xl bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.04)] transition duration-300 ${isLocked ? 'select-none blur-[6px]' : ''}`}>
                    <div className="text-center">
                        <p className="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">Leaderboard</p>
                        <h1 className="mt-2 text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Puncak Pretul</h1>
                        {selectedPackage && (
                            <p className="mt-2 text-sm font-medium text-[#727783]">Result of {selectedPackage.name}</p>
                        )}
                    </div>

                    {/* Blurred content when locked */}
                    <div className={isLocked ? 'pointer-events-none select-none blur-sm' : ''}>
                        {/* Podium */}
                        <div className="mt-8 grid items-end gap-4 md:grid-cols-3">
                            {podium.length === 0 ? (
                                <div className="col-span-3 rounded-2xl bg-[#f8f7f7] p-8 text-center">
                                    <p className="text-sm font-semibold text-[#727783]">Belum ada peserta untuk tryout ini.</p>
                                </div>
                            ) : (
                                podium.map((person) => (
                                    <div
                                        key={person.rank}
                                        className={`rounded-3xl p-6 text-center ${
                                            person.rank === 1
                                                ? 'order-first bg-[#d40f22] text-white md:order-none md:min-h-[180px]'
                                                : 'bg-[#f4f6f8]'
                                        }`}
                                    >
                                        <div className="mx-auto size-16 rounded-full bg-[#ffd12e]"></div>
                                        <p className="mt-4 text-sm font-bold">{person.name}</p>
                                        <p className="mt-2 text-4xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>{rankLabel(person.rank)}</p>
                                        <p className={`mt-2 text-xs font-semibold ${person.rank === 1 ? 'text-white/80' : 'text-[#727783]'}`}>
                                            {person.score} point
                                        </p>
                                    </div>
                                ))
                            )}
                        </div>

                        {/* Table */}
                        {rows.length > 0 && (
                            <div className="mt-8 overflow-hidden rounded-2xl border border-[#f0eded]">
                                <table className="w-full text-left text-sm">
                                    <thead className="bg-[#f8f7f7] text-xs font-bold uppercase tracking-[1px] text-[#727783]">
                                        <tr>
                                            <th className="px-5 py-4">Ranking</th>
                                            <th className="px-5 py-4">Nama</th>
                                            <th className="px-5 py-4">TWK</th>
                                            <th className="px-5 py-4">TIU</th>
                                            <th className="px-5 py-4">TKP</th>
                                            <th className="px-5 py-4 text-right">Total Score</th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-[#f0eded]">
                                        {rows.map((row) => (
                                            <tr key={row.rank}>
                                                <td className="px-5 py-4 font-bold">{row.rank}</td>
                                                <td className="px-5 py-4 font-semibold">{row.name}</td>
                                                <td className="px-5 py-4">{row.twk}</td>
                                                <td className="px-5 py-4">{row.tiu}</td>
                                                <td className="px-5 py-4">{row.tkp}</td>
                                                <td className="px-5 py-4 text-right font-bold text-[#d40f22]">{row.total}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        )}
                    </div>

                    {/* Lock overlay */}
                    {isLocked && (
                        <div className="absolute inset-0 flex items-center justify-center rounded-3xl">
                            <div className="mx-4 w-full max-w-sm rounded-2xl bg-white p-8 text-center shadow-[0_20px_60px_rgba(0,0,0,0.15)]">
                                <div className="mx-auto flex size-14 items-center justify-center rounded-full bg-[#fff0f0]">
                                    <LockIcon />
                                </div>
                                <h2 className="mt-4 text-xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Buka Akses Leaderboard</h2>
                                <p className="mt-3 text-sm leading-6 text-[#727783]">
                                    Lihat peringkat lengkap dengan{' '}
                                    <span className="font-bold text-[#d40f22]">Core Plasma Pro</span>{' '}
                                    mulai dari Rp {(selectedPackage?.price ?? 0).toLocaleString('id-ID')} per try out.
                                </p>
                                <button className="mt-6 w-full rounded-xl bg-[#d40f22] px-5 py-3 text-sm font-bold text-white">
                                    Upgrade ke Pro
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </section>
        </PortalLayout>
    );
}
