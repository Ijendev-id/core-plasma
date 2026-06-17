import { Head, useForm } from '@inertiajs/react';
import { useState, type FormEvent } from 'react';
import PortalLayout from '../../layouts/PortalLayout';

interface ProfileData {
    name: string;
    email: string;
    pendidikan_terakhir: string | null;
    photo_url: string | null;
}

interface Props {
    profile: ProfileData;
    flash?: { status?: string };
}

export default function Profile({ profile, flash }: Props) {
    const [preview, setPreview] = useState<string | null>(profile.photo_url);

    const { data, setData, post, processing, errors } = useForm<{
        name: string;
        email: string;
        pendidikan_terakhir: string;
        photo: File | null;
    }>({
        name: profile.name,
        email: profile.email,
        pendidikan_terakhir: profile.pendidikan_terakhir ?? '',
        photo: null,
    });

    function handlePhoto(e: React.ChangeEvent<HTMLInputElement>) {
        const file = e.target.files?.[0] ?? null;
        setData('photo', file);
        setPreview(file ? URL.createObjectURL(file) : profile.photo_url);
    }

    function handleSubmit(e: FormEvent) {
        e.preventDefault();
        post(route('member.profile.update'), { forceFormData: true });
    }

    return (
        <PortalLayout>
            <Head title="Profil Saya" />
            <section className="mx-auto max-w-2xl">
                <h1 className="text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Profil Saya</h1>
                <p className="mt-2 text-sm font-medium text-[#727783]">Perbarui data diri dan foto profilmu.</p>

                {flash?.status && (
                    <div className="mt-5 rounded-xl bg-[#8cfa96]/30 px-4 py-3 text-sm font-bold text-[#004b19]">{flash.status}</div>
                )}

                <form onSubmit={handleSubmit} className="mt-6 space-y-5 rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    {/* Foto */}
                    <div className="flex items-center gap-5">
                        <div className="size-20 shrink-0 overflow-hidden rounded-full bg-[#eef2f7]">
                            {preview ? (
                                <img src={preview} alt="Foto profil" className="h-full w-full object-cover" />
                            ) : (
                                <div className="flex h-full w-full items-center justify-center text-2xl font-extrabold text-[#00407f]">
                                    {data.name.charAt(0).toUpperCase() || '?'}
                                </div>
                            )}
                        </div>
                        <div>
                            <label className="inline-flex cursor-pointer rounded-xl bg-[#f6f3f2] px-4 py-2 text-sm font-bold text-[#1b1c1c] transition hover:bg-[#eae7e7]">
                                Ubah Foto
                                <input type="file" accept="image/jpeg,image/png,image/webp" onChange={handlePhoto} className="hidden" />
                            </label>
                            <p className="mt-2 text-xs font-medium text-[#727783]">JPG, PNG, atau WEBP. Maks 2MB.</p>
                            {errors.photo && <p className="mt-1 text-xs font-semibold text-[#d40f22]">{errors.photo}</p>}
                        </div>
                    </div>

                    {/* Nama */}
                    <label className="block">
                        <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Nama</span>
                        <input
                            type="text"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            className="mt-2 h-12 w-full rounded-xl border border-[#e5e0df] px-4 text-sm font-semibold outline-none focus:border-[#a80606]"
                        />
                        {errors.name && <p className="mt-1 text-xs font-semibold text-[#d40f22]">{errors.name}</p>}
                    </label>

                    {/* Email */}
                    <label className="block">
                        <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Email</span>
                        <input
                            type="email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            className="mt-2 h-12 w-full rounded-xl border border-[#e5e0df] px-4 text-sm font-semibold outline-none focus:border-[#a80606]"
                        />
                        {errors.email && <p className="mt-1 text-xs font-semibold text-[#d40f22]">{errors.email}</p>}
                    </label>

                    {/* Pendidikan */}
                    <label className="block">
                        <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Pendidikan Terakhir</span>
                        <input
                            type="text"
                            value={data.pendidikan_terakhir}
                            onChange={(e) => setData('pendidikan_terakhir', e.target.value)}
                            placeholder="mis. S1 Teknik Informatika"
                            className="mt-2 h-12 w-full rounded-xl border border-[#e5e0df] px-4 text-sm font-semibold outline-none focus:border-[#a80606]"
                        />
                        {errors.pendidikan_terakhir && <p className="mt-1 text-xs font-semibold text-[#d40f22]">{errors.pendidikan_terakhir}</p>}
                    </label>

                    <button
                        type="submit"
                        disabled={processing}
                        className="rounded-xl bg-[#a80606] px-6 py-3 text-sm font-bold text-white transition hover:-translate-y-px disabled:opacity-60"
                    >
                        {processing ? 'Menyimpan...' : 'Simpan Profil'}
                    </button>
                </form>
            </section>
        </PortalLayout>
    );
}
