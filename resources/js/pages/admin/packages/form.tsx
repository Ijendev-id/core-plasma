import { Head, Link, useForm } from '@inertiajs/react';
import { type FormEvent } from 'react';

interface PackageFormData {
    name: string;
    category: string;
    question_count: number;
    duration_minutes: number;
    participants_count: number;
    price: number;
    status: string;
    icon: string;
    tone: string;
}

interface Props {
    title: string;
    action: string;
    method: 'POST' | 'PUT';
    package: PackageFormData;
    categories: string[];
    statuses: Record<string, string>;
    icons: Record<string, string>;
    tones: Record<string, string>;
    flash?: { status?: string };
}

export default function PackageForm({ title, action, method, package: pkg, categories, statuses, icons, tones, flash }: Props) {
    const { data, setData, post, put, processing, errors } = useForm<PackageFormData>({
        name: pkg.name,
        category: pkg.category,
        question_count: pkg.question_count,
        duration_minutes: pkg.duration_minutes,
        participants_count: pkg.participants_count,
        price: pkg.price,
        status: pkg.status,
        icon: pkg.icon,
        tone: pkg.tone,
    });

    function handleSubmit(e: FormEvent) {
        e.preventDefault();
        if (method === 'PUT') {
            put(action);
        } else {
            post(action);
        }
    }

    return (
        <>
            <Head title={title} />
            <div className="min-h-screen bg-[#f5f6f6] text-[#1b1c1c] antialiased" style={{ fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif' }}>
                <main className="mx-auto flex w-full max-w-[980px] flex-col gap-8 px-5 py-10 sm:px-8 lg:py-14">
                    <section className="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                        <div>
                            <Link href={route('admin.packages.index')} className="text-sm font-semibold text-[#00407f] hover:underline">
                                Back to inventory
                            </Link>
                            <h1 className="mt-3 text-4xl font-extrabold leading-10 text-[#1b1c1c]" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                                {title}
                            </h1>
                            <p className="mt-1 text-base font-medium leading-6 text-[#727783]">
                                Kelola metadata tryout, harga, status publish, dan tampilan row inventory.
                            </p>
                        </div>
                    </section>

                    {flash?.status && (
                        <div className="rounded-xl border border-[#8cfa96] bg-[#8cfa96]/25 px-4 py-3 text-sm font-semibold text-[#004b19]">
                            {flash.status}
                        </div>
                    )}

                    {Object.keys(errors).length > 0 && (
                        <div className="rounded-xl border border-[#a80606]/20 bg-[#a80606]/10 px-4 py-3 text-sm font-semibold text-[#7f1c00]">
                            Ada input yang belum valid. Cek field yang ditandai.
                        </div>
                    )}

                    <form onSubmit={handleSubmit} className="overflow-hidden rounded-2xl bg-white shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                        <div className="grid gap-6 p-6 md:grid-cols-2 lg:p-8">
                            {/* Package Name */}
                            <div className="md:col-span-2">
                                <label htmlFor="name" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Tryout Name</label>
                                <input
                                    id="name"
                                    type="text"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                                />
                                {errors.name && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.name}</p>}
                            </div>

                            {/* Category */}
                            <div>
                                <label htmlFor="category" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Category</label>
                                <select
                                    id="category"
                                    value={data.category}
                                    onChange={(e) => setData('category', e.target.value)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold uppercase text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                                >
                                    {categories.map((cat) => <option key={cat} value={cat}>{cat}</option>)}
                                </select>
                                {errors.category && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.category}</p>}
                            </div>

                            {/* Status */}
                            <div>
                                <label htmlFor="status" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Status</label>
                                <select
                                    id="status"
                                    value={data.status}
                                    onChange={(e) => setData('status', e.target.value)}
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                                >
                                    {Object.entries(statuses).map(([val, label]) => (
                                        <option key={val} value={val}>{label}</option>
                                    ))}
                                </select>
                                {errors.status && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.status}</p>}
                            </div>

                            {/* Questions */}
                            <div>
                                <label htmlFor="question_count" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Questions</label>
                                <input
                                    id="question_count"
                                    type="text"
                                    inputMode="numeric"
                                    value={data.question_count}
                                    onChange={(e) => setData('question_count', Number(e.target.value.replace(/\D/g, '')) || 0)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                                />
                                {errors.question_count && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.question_count}</p>}
                            </div>

                            {/* Duration */}
                            <div>
                                <label htmlFor="duration_minutes" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Durasi (menit)</label>
                                <input
                                    id="duration_minutes"
                                    type="text"
                                    inputMode="numeric"
                                    value={data.duration_minutes}
                                    onChange={(e) => setData('duration_minutes', Number(e.target.value.replace(/\D/g, '')) || 0)}
                                    required
                                    placeholder="mis. 90"
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                                />
                                {errors.duration_minutes && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.duration_minutes}</p>}
                            </div>

                            {/* Participants */}
                            <div>
                                <label htmlFor="participants_count" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Participants</label>
                                <input
                                    id="participants_count"
                                    type="text"
                                    inputMode="numeric"
                                    value={data.participants_count}
                                    onChange={(e) => setData('participants_count', Number(e.target.value.replace(/\D/g, '')) || 0)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                                />
                                {errors.participants_count && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.participants_count}</p>}
                            </div>

                            {/* Price */}
                            <div>
                                <label htmlFor="price" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Price</label>
                                <input
                                    id="price"
                                    type="text"
                                    inputMode="numeric"
                                    value={data.price}
                                    onChange={(e) => setData('price', Number(e.target.value.replace(/\D/g, '')) || 0)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                                />
                                {errors.price && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.price}</p>}
                            </div>

                            {/* Icon */}
                            <div>
                                <label htmlFor="icon" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Icon</label>
                                <select
                                    id="icon"
                                    value={data.icon}
                                    onChange={(e) => setData('icon', e.target.value)}
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                                >
                                    {Object.entries(icons).map(([val, label]) => (
                                        <option key={val} value={val}>{label}</option>
                                    ))}
                                </select>
                                {errors.icon && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.icon}</p>}
                            </div>

                            {/* Tone */}
                            <div>
                                <label htmlFor="tone" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Tone</label>
                                <select
                                    id="tone"
                                    value={data.tone}
                                    onChange={(e) => setData('tone', e.target.value)}
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white focus:ring-2 focus:ring-[#00407f]/10"
                                >
                                    {Object.entries(tones).map(([val, label]) => (
                                        <option key={val} value={val}>{label}</option>
                                    ))}
                                </select>
                                {errors.tone && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.tone}</p>}
                            </div>
                        </div>

                        <div className="flex flex-col-reverse gap-3 bg-[#f0eded] px-6 py-4 sm:flex-row sm:justify-end lg:px-8">
                            <Link href={route('admin.packages.index')} className="inline-flex h-11 items-center justify-center rounded-xl px-5 text-sm font-semibold text-[#727783] transition hover:bg-white">
                                Cancel
                            </Link>
                            <button
                                type="submit"
                                disabled={processing}
                                className="inline-flex h-11 items-center justify-center rounded-xl bg-gradient-to-br from-[#7f1c00] to-[#a80606] px-5 text-sm font-semibold text-white shadow-[0_10px_15px_-3px_rgba(0,64,127,0.18)] transition hover:-translate-y-px disabled:opacity-70"
                            >
                                {processing ? 'Menyimpan...' : 'Save Tryout'}
                            </button>
                        </div>
                    </form>
                </main>
            </div>
        </>
    );
}
