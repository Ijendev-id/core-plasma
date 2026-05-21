import { Head } from '@inertiajs/react';
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

interface Props {
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
    return (
        <PortalLayout>
            <Head title="Leaderboard" />
            <section className="max-w-5xl">
                <div className="rounded-3xl bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <div className="text-center">
                        <p className="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">Leaderboard</p>
                        <h1 className="mt-2 text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Puncak Pretul</h1>
                        <p className="mt-2 text-sm font-medium text-[#727783]">Result of PR Nasional by CI Batch 3</p>
                    </div>

                    {/* Podium */}
                    <div className="mt-8 grid items-end gap-4 md:grid-cols-3">
                        {podium.map((person) => (
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
                        ))}
                    </div>

                    {/* Table */}
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
                </div>
            </section>
        </PortalLayout>
    );
}
