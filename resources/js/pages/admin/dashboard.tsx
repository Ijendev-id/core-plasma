import { Head, Link } from '@inertiajs/react';
import AdminLayout from '../../layouts/AdminLayout';

interface Card {
    label: string;
    value: string;
    tone: string;
}

interface RecentUser {
    name: string;
    role: string;
    status: string;
}

interface Props {
    cards: Card[];
    recentUsers: RecentUser[];
}

export default function AdminDashboard({ cards }: Props) {
    return (
        <AdminLayout>
            <Head title="Admin Dashboard" />
            <main className="min-h-screen px-5 pb-10 pt-[104px] lg:ml-[288px] lg:px-12">
                <section>
                    <h1 className="text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Dashboard</h1>
                    <p className="mt-2 text-sm font-medium text-[#727783]">Monitor performa tryout dan aktivitas siswa.</p>

                    {/* Stats Cards */}
                    <div className="mt-8 grid gap-5 md:grid-cols-4">
                        {cards.map((card, i) => (
                            <article key={i} className="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                                <p className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">{card.label}</p>
                                <p className="mt-4 text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>{card.value}</p>
                            </article>
                        ))}
                    </div>

                    <div className="mt-8">
                        {/* Quick Action */}
                        <section className="rounded-2xl bg-[#ffd12e] p-6 text-[#311300]">
                            <p className="text-xs font-bold uppercase tracking-[1px]">Quick Action</p>
                            <h2 className="mt-3 text-xl font-bold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Buat atau update tryout</h2>
                            <p className="mt-3 text-sm leading-6 text-[#311300]/75">Kelola inventory, soal, dan leaderboard langsung dari area admin.</p>
                            <Link href={route('admin.packages.index')} className="mt-5 inline-flex rounded-xl bg-[#a80606] px-5 py-3 text-sm font-bold text-white">
                                Tryout Inventory
                            </Link>
                        </section>
                    </div>
                </section>
            </main>
        </AdminLayout>
    );
}
