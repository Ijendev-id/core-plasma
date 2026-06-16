import { Head, Link } from '@inertiajs/react';
import { useMemo, useState } from 'react';
import PortalLayout from '../../layouts/PortalLayout';

interface MyTryout {
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
}

interface Package {
    name: string;
    slug: string;
    category: string;
    question_count: number;
    progress: number;
    price: string;
    duration: string;
}

interface Props {
    myTryouts: MyTryout[];
    myCategories: string[];
    packages: Package[];
}

export default function Tryouts({ myTryouts, myCategories, packages }: Props) {
    const [category, setCategory] = useState('');

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
                    <div className="hidden -space-x-2 md:flex">
                        <span className="size-8 rounded-full border-2 border-white bg-[#e2e8f0]"></span>
                        <span className="size-8 rounded-full border-2 border-white bg-[#ffd12e]"></span>
                        <span className="size-8 rounded-full border-2 border-white bg-[#d40f22]"></span>
                    </div>
                </div>

                {/* Tryout Saya */}
                <section className="mt-8">
                    <div className="flex flex-wrap items-center justify-between gap-3">
                        <h2 className="text-xl font-bold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Tryout Saya</h2>
                        {myCategories.length > 0 && (
                            <select
                                value={category}
                                onChange={(e) => setCategory(e.target.value)}
                                className="h-10 rounded-xl border border-[#e5e0df] bg-white px-3 text-sm font-semibold uppercase outline-none focus:border-[#a80606]"
                            >
                                <option value="">Semua Kategori</option>
                                {myCategories.map((c) => <option key={c} value={c}>{c}</option>)}
                            </select>
                        )}
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
                                            <p className="mt-1 text-xs text-[#727783]">{tryout.date} · {tryout.duration}</p>
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
                                        <Link href={route('tryouts.play', tryout.package_slug)} className="shrink-0 rounded-xl bg-[#a80606] px-4 py-2 text-xs font-bold text-white">
                                            Ulangi
                                        </Link>
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
                                        <Link href={route('tryouts.play', pkg.slug)} className="rounded-xl bg-[#a80606] px-4 py-2 text-xs font-bold text-white">
                                            Mulai Latihan
                                        </Link>
                                    </div>
                                </article>
                            ))
                        )}
                    </div>
                </section>
            </section>
        </PortalLayout>
    );
}
