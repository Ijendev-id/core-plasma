import { Head } from '@inertiajs/react';
import { useMemo, useState } from 'react';
import AdminLayout from '../../../layouts/AdminLayout';

interface SummaryCard {
    label: string;
    value: string;
}

interface LeaderboardRow {
    name: string;
    package: string;
    package_slug: string;
    score: number;
    time: string;
    status: string;
}

interface TryoutOption {
    slug: string;
    name: string;
}

interface Props {
    summary: SummaryCard[];
    rows: LeaderboardRow[];
    packages: TryoutOption[];
}

export default function AdminLeaderboard({ summary, rows, packages }: Props) {
    const [selected, setSelected] = useState('');

    const filteredRows = useMemo(
        () => (selected ? rows.filter((row) => row.package_slug === selected) : rows),
        [rows, selected],
    );

    const displaySummary = useMemo(() => {
        if (!selected) {
            return summary;
        }

        const participants = filteredRows.length;
        const average = participants
            ? (filteredRows.reduce((sum, row) => sum + row.score, 0) / participants).toFixed(1)
            : '0.0';
        const topScore = participants
            ? Math.max(...filteredRows.map((row) => row.score))
            : 0;

        return [
            { label: 'Participants', value: String(participants) },
            { label: 'Average Score', value: average },
            { label: 'Top Score', value: String(topScore) },
        ];
    }, [selected, summary, filteredRows]);

    return (
        <AdminLayout>
            <Head title="Leaderboard Management" />
            <main className="min-h-screen px-5 pb-10 pt-[104px] lg:ml-[288px] lg:px-12">
                <section>
                    <div className="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                        <div>
                            <h1 className="text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Leaderboard Management</h1>
                            <p className="mt-2 text-sm font-medium text-[#727783]">Pantau hasil tryout, hall of fame, dan score siswa.</p>
                        </div>
                        <label className="block">
                            <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Filter Tryout</span>
                            <select
                                value={selected}
                                onChange={(e) => setSelected(e.target.value)}
                                className="mt-2 h-11 w-full min-w-[240px] rounded-xl border border-[#e5e0df] bg-white px-3 text-sm font-semibold outline-none focus:border-[#00407f]"
                            >
                                <option value="">Semua Tryout</option>
                                {packages.map((pkg) => (
                                    <option key={pkg.slug} value={pkg.slug}>{pkg.name}</option>
                                ))}
                            </select>
                        </label>
                    </div>

                    <div className="mt-8 grid gap-5 md:grid-cols-3">
                        {displaySummary.map((card, i) => (
                            <article key={i} className="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                                <p className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">{card.label}</p>
                                <p className="mt-4 text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>{card.value}</p>
                            </article>
                        ))}
                    </div>

                    <div className="mt-8 overflow-hidden rounded-2xl bg-white shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                        <table className="w-full text-left text-sm">
                            <thead className="bg-[#f6f3f2] text-xs font-bold uppercase tracking-[1px] text-[#727783]">
                                <tr>
                                    <th className="px-6 py-4">Student</th>
                                    <th className="px-6 py-4">Tryout</th>
                                    <th className="px-6 py-4">Score</th>
                                    <th className="px-6 py-4">Time</th>
                                    <th className="px-6 py-4">Status</th>
                                    <th className="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-[#f0eded]">
                                {filteredRows.length === 0 ? (
                                    <tr>
                                        <td colSpan={6} className="px-6 py-10 text-center text-sm font-medium text-[#727783]">
                                            Belum ada hasil untuk tryout ini.
                                        </td>
                                    </tr>
                                ) : (
                                    filteredRows.map((row, i) => (
                                        <tr key={i}>
                                            <td className="px-6 py-5 font-bold">{row.name}</td>
                                            <td className="px-6 py-5 text-[#727783]">{row.package}</td>
                                            <td className="px-6 py-5 font-bold text-[#00407f]">{row.score}</td>
                                            <td className="px-6 py-5 text-[#727783]">{row.time}</td>
                                            <td className="px-6 py-5">
                                                <span className={`rounded-full px-3 py-1 text-xs font-bold ${row.status === 'Certified' ? 'bg-[#8cfa96]/40 text-[#004b19]' : 'bg-[#ffdbc8] text-[#984800]'}`}>
                                                    {row.status}
                                                </span>
                                            </td>
                                            <td className="px-6 py-5 text-right">
                                                <button className="rounded-lg px-3 py-2 text-xs font-bold text-[#00407f] hover:bg-[#00407f]/10">Review</button>
                                            </td>
                                        </tr>
                                    ))
                                )}
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>
        </AdminLayout>
    );
}
