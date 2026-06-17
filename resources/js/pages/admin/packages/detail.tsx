import { Head, Link, router, useForm } from '@inertiajs/react';
import { useEffect, useMemo, useState, type FormEvent } from 'react';
import AdminLayout from '../../../layouts/AdminLayout';

interface Question {
    id: number;
    order_number: number;
    section: string;
    type: string;
    text: string;
    prompt: string;
    attachment_path: string;
    status: string;
    is_active: boolean;
    points: number;
    answers_count: number;
    correct_label: string;
    answers: Record<string, string>;
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

interface Section {
    id: number;
    code: string;
    name: string | null;
}

interface Props {
    package: PackageInfo;
    questions: Question[];
    sections: Section[];
    flash?: { status?: string };
}

const LABELS = ['A', 'B', 'C', 'D', 'E'];

function emptyForm(defaultSection: string) {
    return {
        section: defaultSection,
        correct_label: 'A',
        prompt: '',
        attachment_path: '',
        points: 1,
        is_active: true,
        position: 0,
        answers: { A: '', B: '', C: '', D: '', E: '' } as Record<string, string>,
    };
}

export default function PackageDetail({ package: pkg, questions, sections, flash }: Props) {
    const defaultSection = sections[0]?.code ?? '';

    // null = mode "tambah soal baru"; number = id soal yang sedang diedit
    const [activeId, setActiveId] = useState<number | null>(questions[0]?.id ?? null);
    // posisi (1-based) tempat soal baru akan disisipkan; default = akhir
    const [newPosition, setNewPosition] = useState<number>(questions.length + 1);
    const [dragIndex, setDragIndex] = useState<number | null>(null);

    const activeQuestion = useMemo(
        () => questions.find((q) => q.id === activeId) ?? null,
        [questions, activeId],
    );

    const { data, setData, post, put, processing, errors, reset } = useForm(emptyForm(defaultSection));

    useEffect(() => {
        if (activeQuestion) {
            setData({
                section: activeQuestion.section,
                correct_label: activeQuestion.correct_label,
                prompt: activeQuestion.prompt,
                attachment_path: activeQuestion.attachment_path ?? '',
                points: activeQuestion.points,
                is_active: activeQuestion.is_active,
                position: 0,
                answers: { A: '', B: '', C: '', D: '', E: '', ...activeQuestion.answers },
            });
        } else {
            reset();
            setData(emptyForm(defaultSection));
        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [activeId]);

    const isEditing = activeQuestion !== null;
    const activeIndex = questions.findIndex((q) => q.id === activeId);

    function handleSubmit(e: FormEvent) {
        e.preventDefault();
        if (isEditing && activeQuestion) {
            put(route('admin.packages.questions.update', [pkg.slug, activeQuestion.id]), { preserveScroll: true });
        } else {
            setData('position', newPosition);
            post(route('admin.packages.questions.store', pkg.slug), {
                preserveScroll: true,
                onSuccess: () => { reset(); setData(emptyForm(defaultSection)); },
            });
        }
    }

    function handleDeleteQuestion(questionId: number) {
        if (!confirm('Hapus soal ini?')) return;
        router.delete(route('admin.packages.questions.destroy', [pkg.slug, questionId]), {
            preserveScroll: true,
            onSuccess: () => setActiveId(null),
        });
    }

    // Mulai tambah soal di posisi tertentu (1-based).
    function startAddAt(position: number) {
        setNewPosition(position);
        setActiveId(null);
    }

    // Drag-drop: jatuhkan soal yang sedang di-drag ke slot index target.
    function handleDrop(targetIndex: number) {
        if (dragIndex === null || dragIndex === targetIndex) {
            setDragIndex(null);
            return;
        }
        const ids = questions.map((q) => q.id);
        const [moved] = ids.splice(dragIndex, 1);
        ids.splice(targetIndex, 0, moved);
        setDragIndex(null);
        router.put(route('admin.packages.questions.reorder', pkg.slug), { order: ids }, {
            preserveScroll: true,
        });
    }

    return (
        <AdminLayout>
            <Head title={`Edit Soal - ${pkg.name}`} />
            <main className="min-h-screen px-5 pb-10 pt-[104px] lg:ml-[288px] lg:px-12">
                {/* Header */}
                <div className="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <div className="flex flex-wrap items-start justify-between gap-5">
                        <div>
                            <p className="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">{pkg.category}</p>
                            <h1 className="mt-2 text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Edit Soal — {pkg.name}</h1>
                            <p className="mt-2 text-sm font-medium text-[#727783]">
                                {questions.length} soal · status <span className="capitalize">{pkg.status}</span>
                            </p>
                        </div>
                        <Link href={route('admin.packages.edit', pkg.slug)} className="rounded-xl bg-[#a80606] px-5 py-3 text-sm font-bold text-white">
                            Edit Tryout
                        </Link>
                    </div>
                </div>

                {flash?.status && (
                    <div className="mt-5 rounded-xl bg-[#8cfa96]/30 px-4 py-3 text-sm font-bold text-[#004b19]">{flash.status}</div>
                )}

                <section className="mt-6 grid gap-6 xl:grid-cols-[260px_1fr]">
                    {/* Palette nomor soal */}
                    <aside className="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                        <h2 className="text-sm font-bold uppercase tracking-[1px] text-[#727783]">Nomor Soal</h2>
                        <p className="mt-1 text-[11px] font-medium text-[#727783]">Klik untuk edit · seret untuk ubah urutan.</p>
                        <div className="mt-4 grid grid-cols-5 gap-2">
                            {questions.map((q, i) => {
                                const active = activeId === q.id;
                                const dragging = dragIndex === i;
                                return (
                                    <button
                                        key={q.id}
                                        type="button"
                                        draggable
                                        onDragStart={() => setDragIndex(i)}
                                        onDragOver={(e) => e.preventDefault()}
                                        onDrop={() => handleDrop(i)}
                                        onDragEnd={() => setDragIndex(null)}
                                        onClick={() => setActiveId(q.id)}
                                        title={`${q.section} — seret untuk pindah`}
                                        className={`relative flex h-11 cursor-grab items-center justify-center rounded-lg text-sm font-bold transition active:cursor-grabbing ${
                                            dragging
                                                ? 'opacity-40'
                                                : active
                                                    ? 'bg-[#00407f] text-white'
                                                    : 'bg-[#f6f3f2] text-[#1b1c1c] hover:bg-[#eae7e7]'
                                        }`}
                                    >
                                        {i + 1}
                                        {!q.is_active && (
                                            <span className="absolute -right-1 -top-1 size-2.5 rounded-full border-2 border-white bg-[#984800]" />
                                        )}
                                    </button>
                                );
                            })}
                            <button
                                type="button"
                                onClick={() => startAddAt(questions.length + 1)}
                                onDragOver={(e) => e.preventDefault()}
                                onDrop={() => handleDrop(questions.length)}
                                className={`flex h-11 items-center justify-center rounded-lg text-lg font-bold transition ${
                                    activeId === null ? 'bg-[#004b19] text-white' : 'border-2 border-dashed border-[#d8d1cf] text-[#727783] hover:bg-[#f6f3f2]'
                                }`}
                                title="Tambah soal baru di akhir"
                            >
                                +
                            </button>
                        </div>
                        <div className="mt-4 flex flex-col gap-1 text-[11px] font-semibold text-[#727783]">
                            <span className="flex items-center gap-2"><span className="size-2.5 rounded-full bg-[#00407f]" /> Dipilih</span>
                            <span className="flex items-center gap-2"><span className="size-2.5 rounded-full bg-[#984800]" /> Draft (nonaktif)</span>
                        </div>
                    </aside>

                    {/* Panel edit / tambah soal */}
                    <div className="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                        <div className="flex items-center justify-between gap-4">
                            <h2 className="text-xl font-bold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                                {isEditing ? `Soal #${activeIndex + 1}` : 'Tambah Soal Baru'}
                            </h2>
                            {isEditing && activeQuestion && (
                                <button
                                    type="button"
                                    onClick={() => handleDeleteQuestion(activeQuestion.id)}
                                    className="rounded-lg px-3 py-2 text-xs font-bold text-[#d40f22] transition hover:bg-[#d40f22]/10"
                                >
                                    Hapus Soal
                                </button>
                            )}
                        </div>

                        <form onSubmit={handleSubmit} className="mt-5 space-y-5">
                            <div className="grid gap-3 sm:grid-cols-3">
                                <label className="block">
                                    <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Section</span>
                                    <select
                                        value={data.section}
                                        onChange={(e) => setData('section', e.target.value)}
                                        className="mt-2 h-11 w-full rounded-xl border border-[#e5e0df] px-3 text-sm font-semibold outline-none focus:border-[#00407f]"
                                    >
                                        {sections.length === 0 && <option value="">— belum ada —</option>}
                                        {sections.map((s) => <option key={s.id} value={s.code}>{s.code}</option>)}
                                    </select>
                                    {errors.section && <span className="mt-2 block text-xs font-semibold text-[#d40f22]">{errors.section}</span>}
                                </label>

                                <label className="block">
                                    <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Poin</span>
                                    <input
                                        type="number"
                                        min={1}
                                        max={100}
                                        value={data.points}
                                        onChange={(e) => setData('points', Number(e.target.value))}
                                        className="mt-2 h-11 w-full rounded-xl border border-[#e5e0df] px-3 text-sm font-semibold outline-none focus:border-[#00407f]"
                                    />
                                </label>

                                <label className="flex items-end gap-2 pb-2">
                                    <input
                                        type="checkbox"
                                        checked={data.is_active}
                                        onChange={(e) => setData('is_active', e.target.checked)}
                                        className="size-4 rounded border-[#cfcaca] text-[#00407f] focus:ring-[#00407f]/20"
                                    />
                                    <span className="text-sm font-semibold text-[#1b1c1c]">Aktif</span>
                                </label>
                            </div>

                            <label className="block">
                                <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Pertanyaan</span>
                                <textarea
                                    rows={4}
                                    value={data.prompt}
                                    onChange={(e) => setData('prompt', e.target.value)}
                                    placeholder="Tulis pertanyaan soal di sini..."
                                    className="mt-2 w-full rounded-xl border border-[#e5e0df] px-3 py-3 text-sm font-semibold outline-none focus:border-[#00407f]"
                                />
                                {errors.prompt && <span className="mt-2 block text-xs font-semibold text-[#d40f22]">{errors.prompt}</span>}
                            </label>

                            <label className="block">
                                <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Attachment Path (opsional)</span>
                                <input
                                    type="text"
                                    value={data.attachment_path}
                                    onChange={(e) => setData('attachment_path', e.target.value)}
                                    placeholder="image/contoh.png"
                                    className="mt-2 h-11 w-full rounded-xl border border-[#e5e0df] px-3 text-sm font-semibold outline-none focus:border-[#00407f]"
                                />
                            </label>

                            <div>
                                <span className="text-xs font-bold uppercase tracking-[1px] text-[#727783]">Pilihan Jawaban</span>
                                <p className="mt-1 text-xs font-medium text-[#727783]">Klik radio untuk menandai jawaban yang benar.</p>
                                <div className="mt-3 space-y-2">
                                    {LABELS.map((label) => {
                                        const correct = data.correct_label === label;
                                        return (
                                            <div
                                                key={label}
                                                className={`flex items-center gap-3 rounded-xl border px-3 py-2 transition ${
                                                    correct ? 'border-[#004b19] bg-[#8cfa96]/15' : 'border-[#e5e0df]'
                                                }`}
                                            >
                                                <label className="flex cursor-pointer items-center gap-2">
                                                    <input
                                                        type="radio"
                                                        name="correct_label"
                                                        checked={correct}
                                                        onChange={() => setData('correct_label', label)}
                                                        className="size-4 text-[#004b19] focus:ring-[#004b19]/30"
                                                    />
                                                    <span className={`flex size-7 items-center justify-center rounded-lg text-sm font-bold ${correct ? 'bg-[#004b19] text-white' : 'bg-[#f6f3f2] text-[#1b1c1c]'}`}>
                                                        {label}
                                                    </span>
                                                </label>
                                                <input
                                                    type="text"
                                                    value={data.answers[label]}
                                                    onChange={(e) => setData('answers', { ...data.answers, [label]: e.target.value })}
                                                    placeholder={`Jawaban ${label}`}
                                                    className="h-10 flex-1 rounded-lg border border-[#e5e0df] px-3 text-sm font-medium outline-none focus:border-[#00407f]"
                                                />
                                                {correct && <span className="shrink-0 text-xs font-bold text-[#004b19]">Benar</span>}
                                            </div>
                                        );
                                    })}
                                </div>
                            </div>

                            <div className="flex items-center gap-3 pt-1">
                                <button
                                    type="submit"
                                    disabled={processing || sections.length === 0}
                                    className="rounded-xl bg-[#a80606] px-6 py-3 text-sm font-bold text-white transition hover:-translate-y-px disabled:opacity-70"
                                >
                                    {processing ? 'Menyimpan...' : isEditing ? 'Simpan Perubahan' : 'Tambah Soal'}
                                </button>
                                {isEditing && (
                                    <button
                                        type="button"
                                        onClick={() => setActiveId(null)}
                                        className="rounded-xl px-5 py-3 text-sm font-semibold text-[#727783] transition hover:bg-[#f6f3f2]"
                                    >
                                        + Soal Baru
                                    </button>
                                )}
                            </div>
                        </form>
                    </div>
                </section>
            </main>
        </AdminLayout>
    );
}
