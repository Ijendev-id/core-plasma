import { Head, Link } from '@inertiajs/react';
import PortalLayout from '../../layouts/PortalLayout';

export default function Payment() {
    return (
        <PortalLayout>
            <Head title="Payment" />
            <section className="max-w-5xl">
                <div className="overflow-hidden rounded-3xl bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <div className="text-center">
                        <p className="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">Payment</p>
                        <h1 className="mt-2 text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                            Pembayaran QRIS
                        </h1>
                        <p className="mt-2 text-sm font-medium text-[#727783]">
                            Scan QR di bawah untuk melanjutkan pembayaran.
                        </p>
                    </div>

                    <div className="mx-auto mt-8 grid max-w-4xl gap-6 lg:grid-cols-[1fr_320px] lg:items-center">
                        <div className="rounded-3xl bg-[#f8f7f7] p-5">
                            <div className="overflow-hidden rounded-2xl bg-white p-4 shadow-sm">
                                <img
                                    src="/image/qris.svg"
                                    alt="QRIS payment code"
                                    className="mx-auto w-full max-w-[420px]"
                                />
                            </div>
                        </div>

                        <div className="space-y-4">
                            <div className="rounded-2xl border border-[#f0eded] p-5">
                                <p className="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">Instruksi</p>
                                <ol className="mt-3 space-y-3 text-sm leading-6 text-[#727783]">
                                    <li>1. Buka aplikasi e-wallet atau mobile banking yang mendukung QRIS.</li>
                                    <li>2. Scan QR code di sebelah kiri.</li>
                                    <li>3. Masukkan nominal pembayaran sesuai kebutuhan.</li>
                                    <li>4. Selesaikan transaksi dan simpan bukti bayar.</li>
                                </ol>
                            </div>

                            <div className="rounded-2xl bg-[#d40f22] p-5 text-white shadow-[0_20px_50px_rgba(168,6,6,0.18)]">
                                <p className="text-xs font-bold uppercase tracking-[1px] text-white/70">Status</p>
                                <p className="mt-2 text-lg font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                                    QRIS siap digunakan
                                </p>
                                <p className="mt-2 text-sm leading-6 text-white/80">
                                    Setelah pembayaran berhasil, kembali ke leaderboard untuk melihat hasil lengkap.
                                </p>
                                <Link href={route('leaderboard')} className="mt-5 inline-flex rounded-xl bg-white px-4 py-3 text-sm font-bold text-[#a80606]">
                                    Kembali ke leaderboard
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </PortalLayout>
    );
}
