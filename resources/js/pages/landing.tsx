import { Head, Link } from '@inertiajs/react';

export default function Landing() {
    return (
        <>
            <Head title="Beranda" />
            <div className="min-h-screen bg-white text-[#1b1c1c]" style={{ fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif' }}>
                {/* Header */}
                <header className="sticky top-0 z-50 border-b border-gray-100 bg-white/90 backdrop-blur">
                    <div className="mx-auto flex max-w-6xl items-center justify-between px-5 py-4">
                        <span className="text-sm font-extrabold text-[#d40f22]">Core Plasma</span>
                        <nav className="hidden items-center gap-6 text-sm font-semibold text-[#727783] md:flex">
                            <a href="#beranda" className="hover:text-[#1b1c1c]">Beranda</a>
                            <a href="#artikel" className="hover:text-[#1b1c1c]">Artikel</a>
                            <a href="#paket" className="hover:text-[#1b1c1c]">Paket Belajar</a>
                            <a href="#keunggulan" className="hover:text-[#1b1c1c]">Keunggulan</a>
                            <a href="#testimoni" className="hover:text-[#1b1c1c]">Testimoni</a>
                            <a href="#faq" className="hover:text-[#1b1c1c]">FAQ</a>
                        </nav>
                        <div className="flex items-center gap-3">
                            <Link href={route('member.login')} className="text-sm font-semibold text-[#727783] hover:text-[#1b1c1c]">Masuk</Link>
                            <Link href={route('member.register')} className="rounded-xl bg-[#a80606] px-4 py-2 text-sm font-bold text-white">Daftar</Link>
                        </div>
                    </div>
                </header>

                {/* Hero */}
                <section className="bg-white px-5 py-20" id="beranda">
                    <div className="mx-auto max-w-6xl">
                        <div className="grid items-center gap-12 lg:grid-cols-2">
                            <div>
                                <div className="inline-flex rounded-full bg-[#fff1f1] px-4 py-1.5 text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">
                                    #PLATFORM TRYOUT TERPERCAYA
                                </div>
                                <h1 className="mt-6 text-5xl font-extrabold leading-tight" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                                    Kuasai Materi,<br />
                                    <span className="text-[#d40f22]">Raih Impianmu.</span>
                                </h1>
                                <p className="mt-5 max-w-lg text-base leading-7 text-[#727783]">
                                    Metode belajar revolusioner yang dirancang untuk mempercepat pemahaman materi sulit menjadi konsep yang menyenangkan.
                                </p>
                                <Link href="#paket" className="mt-8 inline-flex rounded-xl bg-[#a80606] px-6 py-3.5 text-sm font-bold text-white shadow-[0_10px_20px_rgba(168,6,6,0.2)]">
                                    Lihat Paket Belajar
                                </Link>
                                <div className="mt-8 flex items-center gap-4">
                                    <div className="flex -space-x-2">
                                        {[1, 2, 3].map((i) => (
                                            <img key={i} src={`https://i.pravatar.cc/100?img=${i}`} alt={`Siswa ${i}`} className="size-9 rounded-full border-2 border-white" />
                                        ))}
                                    </div>
                                    <p className="text-sm font-semibold text-[#727783]">
                                        <strong className="text-[#1b1c1c]">500+</strong> Siswa Core Plasma lolos PTN, Kedinasan, CPNS dan BUMN
                                    </p>
                                </div>
                            </div>
                            <div className="flex justify-center">
                                <img src="/image/siswacoreplasma.png" alt="Siswa Core Plasma" className="max-h-[480px] w-full max-w-sm object-contain" />
                            </div>
                        </div>
                    </div>
                </section>

                {/* Artikel */}
                <section className="bg-[#f6f7f8] px-5 py-16" id="artikel">
                    <div className="mx-auto max-w-6xl">
                        <div className="flex items-end justify-between">
                            <div>
                                <p className="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">WAWASAN TERBARU</p>
                                <h2 className="mt-2 text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                                    Artikel <span className="text-[#d40f22]">Terupdate</span>
                                </h2>
                            </div>
                            <a href="#" className="text-sm font-bold text-[#00407f] hover:underline">Lihat Semua Blog →</a>
                        </div>
                        <div className="mt-8 grid gap-6 md:grid-cols-3">
                            {[
                                { tag: 'TIPS & TRIK', date: '24 Mei 2024', title: 'Strategi Menjawab Soal Literasi Bahasa Inggris di UTBK 2024', desc: 'Kuasai teknik scanning dan skimming untuk menghemat waktu pengerjaan soal bacaan...', img: 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=600&q=80' },
                                { tag: 'INFO KAMPUS', date: '20 Mei 2024', title: 'Daftar Jurusan Paling Ketat di Universitas Indonesia (UI) Tahun Ini', desc: 'Simak data keketatan prodi SAINTEK dan SOSHUM sebagai referensi pemilihan jurusan...', img: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&q=80' },
                                { tag: 'MOTIVASI', date: '18 Mei 2024', title: 'Pentingnya Mental Health Selama Menghadapi Persiapan Ujian Nasional', desc: 'Jangan sampai burnout! Inilah tips menjaga keseimbangan mental agar tetap fokus...', img: 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=600&q=80' },
                            ].map((article, i) => (
                                <article key={i} className="overflow-hidden rounded-2xl bg-white shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                                    <div className="relative">
                                        <span className="absolute left-4 top-4 rounded-full bg-[#d40f22] px-3 py-1 text-[10px] font-bold text-white">{article.tag}</span>
                                        <img src={article.img} alt={article.title} className="h-48 w-full object-cover" />
                                    </div>
                                    <div className="p-5">
                                        <span className="text-xs font-semibold text-[#727783]">{article.date}</span>
                                        <h3 className="mt-2 text-base font-bold leading-6">{article.title}</h3>
                                        <p className="mt-2 text-sm leading-6 text-[#727783]">{article.desc}</p>
                                        <a href="#" className="mt-4 block text-xs font-bold text-[#d40f22]">Baca Selengkapnya ›</a>
                                    </div>
                                </article>
                            ))}
                        </div>
                    </div>
                </section>

                {/* Paket */}
                <section className="bg-white px-5 py-16" id="paket">
                    <div className="mx-auto max-w-6xl text-center">
                        <p className="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">INVESTASI MASA DEPAN</p>
                        <h2 className="mt-2 text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                            Pilih Paket <span className="text-[#d40f22]">Juaramu</span>
                        </h2>
                        <p className="mt-3 text-sm text-[#727783]">Pilih paket yang paling sesuai dengan kebutuhan belajarmu.</p>

                        <div className="mt-10 grid gap-6 md:grid-cols-3">
                            {[
                                { name: 'Tryout', price: 'Rp 149k', period: '/bulan', desc: 'BUNDLING 3 TO SKD 2026 PART 27, 28, 29 | Berisi 3 Paket Try Out dengan soal HOTS', features: ['Akses 50 Video Materi', 'Bank Soal Harian'], disabled: ['Try Out Nasional'], featured: false },
                                { name: 'Tryout', price: 'Rp 299k', period: '/bulan', desc: 'BUNDLING 10 TO PERSUBTEST SNBT 2026 PART 2-11 | Berisi 10 Paket Try Out Persubtest', features: ['Akses Seluruh Video', '10x Try Out Nasional', 'Konsultasi Lewat WA', 'Modul Fisik Dikirim'], disabled: [], featured: true },
                                { name: 'Tryout', price: 'Rp 599k', period: '/bulan', desc: 'BUNDLING 1 Paket Try Out seleksi masuk BUMN', features: ['Semua Fitur Paket Pro', 'Live Session Private', 'Jaminan Lolos PTN*'], disabled: [], featured: false },
                            ].map((plan, i) => (
                                <div key={i} className={`relative rounded-2xl p-8 ${plan.featured ? 'bg-[#a80606] text-white shadow-[0_20px_50px_rgba(168,6,6,0.25)]' : 'bg-white shadow-[0_8px_30px_rgba(0,0,0,0.06)]'}`}>
                                    {plan.featured && <div className="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-[#ffd12e] px-4 py-1 text-[10px] font-bold text-[#311300]">TERPOPULER</div>}
                                    <h4 className={`text-sm font-bold ${plan.featured ? 'text-white/80' : 'text-[#727783]'}`}>{plan.name}</h4>
                                    <div className="mt-3 flex items-end gap-1">
                                        <span className="text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>{plan.price}</span>
                                        <span className={`mb-1 text-sm ${plan.featured ? 'text-white/70' : 'text-[#727783]'}`}>{plan.period}</span>
                                    </div>
                                    <p className={`mt-3 text-xs leading-5 ${plan.featured ? 'text-white/80' : 'text-[#727783]'}`}>{plan.desc}</p>
                                    <ul className="mt-5 space-y-2">
                                        {plan.features.map((f) => (
                                            <li key={f} className="flex items-center gap-2 text-sm font-semibold">
                                                <span className={`text-base ${plan.featured ? 'text-[#ffd12e]' : 'text-[#d40f22]'}`}>✓</span> {f}
                                            </li>
                                        ))}
                                        {plan.disabled.map((f) => (
                                            <li key={f} className="flex items-center gap-2 text-sm font-semibold opacity-40">
                                                <span className="text-base">✗</span> {f}
                                            </li>
                                        ))}
                                    </ul>
                                    {plan.featured ? (
                                        <Link href={route('member.register')} className="mt-6 block rounded-xl bg-white px-5 py-3 text-center text-sm font-bold text-[#a80606]">
                                            Daftar Sekarang
                                        </Link>
                                    ) : (
                                        <a href="#" className="mt-6 block rounded-xl border-2 border-[#e5e0df] px-5 py-3 text-center text-sm font-bold text-[#1b1c1c] hover:border-[#a80606]">
                                            Pilih Paket
                                        </a>
                                    )}
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* Testimoni */}
                <section className="bg-[#f6f7f8] px-5 py-16" id="testimoni">
                    <div className="mx-auto max-w-6xl">
                        <h2 className="text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                            Kisah Mereka yang <span className="text-[#d40f22]">Berhasil</span>
                        </h2>
                        <p className="mt-2 text-sm text-[#727783]">Dari ragu-ragu menjadi yakin, inilah testimoni nyata dari siswa Core Plasma.</p>
                        <div className="mt-8 grid gap-6 md:grid-cols-3">
                            {[
                                { name: 'Anisa Rahma', achievement: 'LOLOS KEDOKTERAN UI', review: '"Metode penghitungan cepat di Core Plasma bener-bener ngebantu aku pas UTBK kemarin."', img: 5 },
                                { name: 'Budi Santoso', achievement: 'LOLOS TEKNIK ITB', review: '"Dulu aku paling anti sama Fisika, tapi setelah ikut kelas di sini, konsepnya jadi gampang dipahami."', img: 11 },
                                { name: 'Citra Lestari', achievement: 'LOLOS MANAJEMEN UGM', review: '"Try Out Nasionalnya dapet banget feel ujian aslinya. Analisis skornya akurat."', img: 9 },
                            ].map((t, i) => (
                                <div key={i} className="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                                    <div className="text-[#ffd12e]">★★★★★</div>
                                    <p className="mt-3 text-sm leading-6 text-[#727783]">{t.review}</p>
                                    <div className="mt-5 flex items-center gap-3">
                                        <img src={`https://i.pravatar.cc/150?img=${t.img}`} alt={t.name} className="size-10 rounded-full" />
                                        <div>
                                            <p className="text-sm font-bold">{t.name}</p>
                                            <p className="text-xs font-bold text-[#d40f22]">{t.achievement}</p>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* FAQ */}
                <section className="bg-white px-5 py-16" id="faq">
                    <div className="mx-auto max-w-3xl">
                        <div className="text-center">
                            <p className="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">BANTUAN</p>
                            <h2 className="mt-2 text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                                Pertanyaan <span className="text-[#d40f22]">Umum</span>
                            </h2>
                        </div>
                        <div className="mt-8 space-y-3">
                            {[
                                { q: 'Bagaimana cara mendaftar di Core Plasma?', a: 'Cukup klik tombol "Daftar Sekarang" di paket yang kamu inginkan, lengkapi formulir pendaftaran, dan lakukan pembayaran.' },
                                { q: 'Apakah materi belajarnya bisa diakses selamanya?', a: 'Materi belajar dapat diakses selama masa aktif paket yang kamu pilih.' },
                                { q: 'Apakah ada jaminan uang kembali jika tidak puas?', a: 'Kami memberikan garansi 100% uang kembali dalam 7 hari pertama (Syarat & Ketentuan berlaku).' },
                                { q: 'Bisakah saya berkonsultasi langsung dengan tutor?', a: 'Tentu! Untuk pengguna Paket Pro dan Ultimate, disediakan grup khusus dan sesi live mentoring.' },
                            ].map((faq, i) => (
                                <details key={i} className="group rounded-xl border border-[#f0eded] bg-white">
                                    <summary className="flex cursor-pointer items-center justify-between px-5 py-4 text-sm font-bold">
                                        {faq.q}
                                        <span className="ml-4 shrink-0 text-[#d40f22] transition group-open:rotate-180">▼</span>
                                    </summary>
                                    <div className="px-5 pb-4 text-sm leading-6 text-[#727783]">{faq.a}</div>
                                </details>
                            ))}
                        </div>
                    </div>
                </section>

                {/* CTA */}
                <section className="bg-[#a80606] px-5 py-16">
                    <div className="mx-auto max-w-3xl text-center text-white">
                        <h2 className="text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                            Siap Untuk Menjadi <span className="text-[#ffd12e]">Siswa Juara</span> Selanjutnya?
                        </h2>
                        <p className="mt-4 text-sm leading-6 text-white/80">Jangan tunda kesempatanmu untuk masuk PTN impian. Mulai perjalanan suksesmu hari ini bersama Core Plasma.</p>
                        <div className="mt-8 flex flex-col items-center gap-4 sm:flex-row sm:justify-center">
                            <Link href={route('member.register')} className="rounded-xl bg-[#ffd12e] px-6 py-3.5 text-sm font-bold text-[#311300]">
                                Daftar Sekarang
                            </Link>
                            <a href="#" className="rounded-xl border-2 border-white/40 px-6 py-3.5 text-sm font-bold text-white hover:border-white">
                                Hubungi Admin
                            </a>
                        </div>
                    </div>
                </section>

                {/* Footer */}
                <footer className="bg-[#1b1c1c] px-5 py-8 text-center text-xs text-white/50">
                    © {new Date().getFullYear()} Core Plasma. All rights reserved.
                </footer>
            </div>
        </>
    );
}
