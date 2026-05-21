import { Head, Link, router, useForm } from '@inertiajs/react';
import { type FormEvent } from 'react';
import AdminLayout from '../../../layouts/AdminLayout';

interface Question {
    id: number;
    type: string;
    text: string;
    status: string;
    points: number;
    answers_count: number;
}

interface PackageInfo {
    id: number;
    name: string;
    slug: string;
    category: string;
    status: string;
    price: number;
    participants_count: number;
}

interface Props {
    package: PackageInfo;
    questions: Question[];
    flash?: { status?: string };
}

const SECTIONS = ['TWK', 'TIU', 'TKP'];
const LABELS = ['A', 'B', 'C', 'D', 'E'];

export default function PackageDetail({ package: pkg, questions, flash }: Props) {
    const { data, setData, post, processing, errors, reset } = useForm({
        section: 'TWK',
        correct_label: 'A',
        prompt: '',
        attachment_path: '',
        points: 5,
        is_active: true,
        answers: { A: '', B: '', C: '', D: '', E: '' } as Record<string, string>,
    });

    function handleSubmit(e: FormEvent) {
        e.preventDefault();
        post(route('admin.packages.questions.store', pkg.slug), {
            onSuccess: () => reset(),
        });
    }

    function handleDeleteQuestion(questionId: number) {
        router.delete(route('admin.packages.questions.destroy', [pkg.slug, questionId]));
    }

    return (
        <AdminLayout>
            <Head title={pkg.name} />
            <main className="min-h-screen px-5 pb-10 pt-[104px] lg:ml-[288px] lg:px-12">
                <section className="grid gap-6 xl:grid-cols-[1fr_280px]">
                    <div className="space-y-6">
                        {/* Package Header */}
                        <div className="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                            <div className="flex items-start justify-between gap-5">
                                <div>
                                    <p className="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">{pkg.category}</p>
                                    <h1 className="mt-2 text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>{pkg.name} Details</h1>
                                    <p className="mt-2 text-sm font-medium text-[#727783]">
                                        {questions.length} questions, {pkg.participants_count.toLocaleString()} participants.
                                    </p>
                                </div>
                                <Link href={route('admin.packages.edit', pkg.slug)} className="rounded-xl bg-[#a80606] px-5 py-3 text-sm font-bold text-white">
                                    Edit Package
                                </Link>
                            </div>
                        </div>

                        {/* Question Bank */}
                        <section className="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                            <div className="flex items-center justify-between">
                                <h2 className="text-xl font-bold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Question Bank</h2>
                                <span className="rounded-xl bg-[#a80606] px-4 py-2 text-xs font-bold text-white">{questions.length} Questions</span>
                            </div>

                            {flash?.status && (
                                <div className="mt-5 rounded-xl bg-[#8cfa96]/30 px-4 py-3 text-sm font-bold text-[#004b19]">{flash.status}</div>
                            )}

                            <div className="mt-5 space-y-3">
                                {questions.length === 0 ? (
                                    <div className="rounded-xl border border-dashed border-[#d8d1cf] p-5 text-sm font-semibold text-[#727783]">
                                        Belum ada soal untuk paket ini.
                                    </div>
                                ) : (
                                    questions.map((question) => (
                                        <article key={question.id} className="rounded-xl border border-[#f0eded] p-4">
                                            <div className="flex items-center justify-between gap-4">
                                                <span className="rounded-lg bg-[#f6f3f2] px-3 py-1 text-xs font-bold text-[#727783]">{question.type}</span>
                                                <div className="flex items-center gap-3">
                                                    <span className={`text-xs font-bold ${question.status === 'Active' ? 'text-[#004b19]' : 'text-[#984800]'}`}>
                                                        {question.status}
                                                    </span>
                                                    <button
                                                        type="button"
                                                        onClick={() => handleDeleteQuestion(question.id)}
                                                        className="text-xs font-bold text-[#d40f22]"
                                                    >
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                            <p className="mt-3 text-sm font-semibold">{question.text}</p>
                                            <p className="mt-2 text-xs font-semibold text-[#727783]">{question.answers_count} jawaban, {question.points} poin</p>
                                        </article>
                                    ))
                                )}
                            </div>
                        </section>
                    </div>

                    {/* Sidebar */}
                    <aside className="space-y-5">
                        {/* Package Status */}
                        <section className="rounded-2xl bg-[#ffdbc8] p-6 text-[#311300]">
                            <h2 className="text-xl font-bold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Package Status</h2>
                            <p className="mt-3 text-sm font-semibold capitalize">{pkg.status}</p>
                            <div className="mt-5 rounded-xl bg-white/55 p-4">
                                <p className="text-xs font-bold uppercase">Price</p>
                                <p className="mt-2 text-2xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                                    Rp {pkg.price.toLocaleString('id-ID')}
                                </p>
                            </div>
                        </section>

                        {/* Add Question Form */}
                        <section className="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                            <h2 className="text-xl font-bold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Add Question</h2>
                            <form onSubmit={handleSubmit} className="mt-5 space-y-4">
                                <div className="grid gap-3 sm:grid-cols-2">
                                    <label className="block">
                                        <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Section</span>
                                        <select
                                            value={data.section}
                                            onChange={(e) => setData('section', e.target.value)}
                                            className="mt-2 h-11 w-full rounded-xl border border-[#e5e0df] px-3 text-sm font-semibold outline-none"
                                        >
                                            {SECTIONS.map((s) => <option key={s} value={s}>{s}</option>)}
                                        </select>
                                    </label>

                                    <label className="block">
                                        <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Correct</span>
                                        <select
                                            value={data.correct_label}
                                            onChange={(e) => setData('correct_label', e.target.value)}
                                            className="mt-2 h-11 w-full rounded-xl border border-[#e5e0df] px-3 text-sm font-semibold outline-none"
                                        >
                                            {LABELS.map((l) => <option key={l} value={l}>{l}</option>)}
                                        </select>
                                    </label>
                                </div>

                                <label className="block">
                                    <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Prompt</span>
                                    <textarea
                                        rows={4}
                                        value={data.prompt}
                                        onChange={(e) => setData('prompt', e.target.value)}
                                        className="mt-2 w-full rounded-xl border border-[#e5e0df] px-3 py-3 text-sm font-semibold outline-none"
                                    />
                                    {errors.prompt && <span className="mt-2 block text-xs font-semibold text-[#d40f22]">{errors.prompt}</span>}
                                </label>

                                <label className="block">
                                    <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Attachment Path</span>
                                    <input
                                        type="text"
                                        value={data.attachment_path}
                                        onChange={(e) => setData('attachment_path', e.target.value)}
                                        placeholder="image/package-bulk-upload.png"
                                        className="mt-2 h-11 w-full rounded-xl border border-[#e5e0df] px-3 text-sm font-semibold outline-none"
                                    />
                                </label>

                                {LABELS.map((label) => (
                                    <label key={label} className="block">
                                        <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Answer {label}</span>
                                        <input
                                            type="text"
                                            value={data.answers[label]}
                                            onChange={(e) => setData('answers', { ...data.answers, [label]: e.target.value })}
                                            className="mt-2 h-11 w-full rounded-xl border border-[#e5e0df] px-3 text-sm font-semibold outline-none"
                                        />
                                    </label>
                                ))}

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full rounded-xl bg-[#a80606] px-5 py-3 text-sm font-bold text-white disabled:opacity-70"
                                >
                                    {processing ? 'Menyimpan...' : 'Add New Question'}
                                </button>
                            </form>
                        </section>
                    </aside>
                </section>
            </main>
        </AdminLayout>
    );
}
