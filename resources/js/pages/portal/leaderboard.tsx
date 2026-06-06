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

function LockIcon() {
    return (
        <svg xmlns="http://www.w3.org/2000/svg" className="mx-auto size-10 text-[#d40f22]" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
            <path strokeLinecap="round" strokeLinejoin="round" d="M16.5 10.5V7a4.5 4.5 0 10-9 0v3.5M5 10.5h14a1 1 0 011 1V20a1 1 0 01-1 1H5a1 1 0 01-1-1v-8.5a1 1 0 011-1z" />
        </svg>
    );
}

export default function Leaderboard({ packages, selectedPackage, isLocked, podium, rows }: Props) {
    function handlePackageChange(e: React.ChangeEvent<HTMLSelectElement>) {
        router.get(route('leaderboard'), { package: e.target.value }, { preserveState: false });
    }

    return (
        <PortalLayout>
            <Head title="Leaderboard" />
            <section className="max-w-5xl">
                {/* Package filter */}
                {packages.length > 0 && (
                    <div className="mb-6 flex justify-end">
                        <div>
                            <p className="mb-1 text-[10px] font-bold uppercase tracking-[1px] text-[#727783]">Pilih Tryout</p>
                            <select
                                value={selectedPackage?.slug ?? ''}
                                onChange={handlePackageChange}
                                className="rounded-xl border border-[#e8e5e5] bg-white px-4 py-2 text-sm font-semibold text-[#1a1a1a] shadow-sm focus:outline-none focus:ring-2 focus:ring-[#d40f22]/30"
                            >
                                {packages.map((pkg) => (
                                    <option key={pkg.slug} value={pkg.slug}>{pkg.name}</option>
                                ))}
                            </select>
                        </div>
                    </div>
                )}

                <div className="relative rounded-3xl bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    {/* Header */}
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
