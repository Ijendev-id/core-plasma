import { Head } from '@inertiajs/react';
import AdminLayout from '../../../layouts/AdminLayout';

interface SummaryCard {
    label: string;
    value: string;
}

interface LeaderboardRow {
    name: string;
    score: number;
    time: string;
    status: string;
}

interface Props {
    summary: SummaryCard[];
    rows: LeaderboardRow[];
}

export default function AdminLeaderboard({ summary, rows }: Props) {
    return (
        <AdminLayout>
            <Head title="Leaderboard Management" />
            <main className="min-h-screen px-5 pb-10 pt-[104px] lg:ml-[288px] lg:px-12">
                <section>
                    <h1 className="text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Leaderboard Management</h1>
                    <p className="mt-2 text-sm font-medium text-[#727783]">Pantau hasil tryout, hall of fame, dan score siswa.</p>

                    <div className="mt-8 grid gap-5 md:grid-cols-3">
                        {summary.map((card, i) => (
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
                                    <th className="px-6 py-4">Score</th>
                                    <th className="px-6 py-4">Time</th>
                                    <th className="px-6 py-4">Status</th>
                                    <th className="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-[#f0eded]">
                                {rows.map((row, i) => (
                                    <tr key={i}>
                                        <td className="px-6 py-5 font-bold">{row.name}</td>
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
                                ))}
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>
        </AdminLayout>
    );
}
