import { Head, Link } from '@inertiajs/react';
import PortalLayout from '../../layouts/PortalLayout';
import { type Member } from '../../types';

interface ProgressItem {
    title: string;
    percent: number;
    tag: string;
}

interface RecentResult {
    title: string;
    score: number;
    status: string;
}

interface RankingRow {
    name: string;
    score: number;
}

interface Props {
    member?: Member;
    progress: ProgressItem[];
    recentResults: RecentResult[];
    ranking: RankingRow[];
}

export default function PortalDashboard({ member, progress, recentResults, ranking }: Props) {
    return (
        <PortalLayout>
            <Head title="Dashboard" />
            <section className="grid gap-6">
                <div className="space-y-6">
                    {/* Hero Banner */}
                    <div className="overflow-hidden rounded-3xl bg-gradient-to-br from-[#d31325] to-[#8c0013] p-8 text-white shadow-[0_20px_50px_rgba(168,6,6,0.18)]">
                        <div className="flex max-w-xl flex-col items-start">
                            <p className="text-xs font-bold uppercase tracking-[1.2px] text-white/70">Next Tryout</p>
                            <h1 className="mt-3 text-4xl font-extrabold leading-tight" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                            Selamat Try Out,<br />{member?.name ?? 'Peserta'}!
                            </h1>
                            <p className="mt-4 text-sm leading-6 text-white/80">
                                Pilih Try Out gratis sekarang dan lanjutkan simulasi tryout yang tertunda.
                            </p>
                            <Link href={route('tryouts.index')} className="mt-6 inline-flex rounded-xl bg-white px-5 py-3 text-sm font-bold text-[#a80606]">
                                Lanjut Try Out
                            </Link>
                        </div>
                    </div>

                    <div className="grid gap-5 md:grid-cols-2">
                        {/* Progres Belajar */}
                        <section className="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                            <div className="mb-5 flex items-center justify-between">
                                <h2 className="text-lg font-bold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Progres Try Out</h2>
                                <Link href={route('tryouts.index')} className="text-xs font-bold text-[#d40f22]">Lihat Paket</Link>
                            </div>
                            {progress.length === 0 ? (
                                <div className="rounded-xl border border-dashed border-[#e5e1e1] bg-[#fafafa] p-5 text-sm text-[#727783]">
                                    Belum ada try out yang dipilih.
                                </div>
                            ) : (
                                <div className="space-y-4">
                                    {progress.map((item, i) => (
                                        <div key={i} className="rounded-xl border border-[#f0eded] p-4">
                                            <div className="flex items-center justify-between gap-3">
                                                <p className="text-sm font-bold">{item.title}</p>
                                                <span className="rounded-full bg-[#fff1d9] px-2 py-1 text-[10px] font-bold text-[#984800]">{item.tag}</span>
                                            </div>
                                            <div className="mt-4 h-2 overflow-hidden rounded-full bg-[#eae7e7]">
                                                <div className="h-full rounded-full bg-[#d40f22]" style={{ width: `${item.percent}%` }} />
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            )}
                        </section>

                        {/* Hasil Try Out Terakhir */}
                        <section className="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                            <h2 className="text-lg font-bold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Hasil Try Out Terakhir</h2>
                            {recentResults.length === 0 ? (
                                <div className="mt-5 rounded-xl border border-dashed border-[#e5e1e1] bg-[#fafafa] p-5 text-sm text-[#727783]">
                                    Belum ada hasil try out.
                                </div>
                            ) : (
                                <div className="mt-5 space-y-3">
                                    {recentResults.map((result, i) => (
                                        <div key={i} className="flex items-center justify-between rounded-xl bg-[#f8f7f7] p-4">
                                            <div>
                                                <p className="text-sm font-bold">{result.title}</p>
                                                <p className="mt-1 text-xs font-semibold text-[#727783]">Score {result.score}</p>
                                            </div>
                                            <span className="rounded-full bg-[#fff1f1] px-3 py-1 text-[10px] font-bold text-[#d40f22]">{result.status}</span>
                                        </div>
                                    ))}
                                </div>
                            )}
                        </section>
                    </div>
                </div>
            </section>
        </PortalLayout>
    );
}
