import { Head, router } from '@inertiajs/react';
import { useEffect, useMemo, useState } from 'react';
import PortalLayout from '../../layouts/PortalLayout';

interface AnswerOption {
    label: string;
    text: string;
}

interface Question {
    id: number;
    number: number;
    section: string;
    text: string;
    image: string | null;
    answers: AnswerOption[];
}

interface PackageInfo {
    name: string;
    slug: string;
    category: string;
    duration_minutes: number;
}

interface Props {
    package: PackageInfo | null;
    questions: Question[];
}

function formatClock(totalSeconds: number): string {
    const s = Math.max(0, totalSeconds);
    const h = Math.floor(s / 3600);
    const m = Math.floor((s % 3600) / 60);
    const sec = s % 60;
    return [h, m, sec].map((n) => String(n).padStart(2, '0')).join(':');
}

export default function Play({ package: pkg, questions }: Props) {
    const [current, setCurrent] = useState(0);
    const [answers, setAnswers] = useState<Record<number, string>>({});
    const [submitting, setSubmitting] = useState(false);

    const hasTimer = (pkg?.duration_minutes ?? 0) > 0;
    const [elapsed, setElapsed] = useState(0);

    useEffect(() => {
        const id = setInterval(() => setElapsed((e) => e + 1), 1000);
        return () => clearInterval(id);
    }, []);

    const remaining = hasTimer ? pkg!.duration_minutes * 60 - elapsed : 0;
    const answeredCount = Object.keys(answers).length;
    const totalQuestions = questions.length;
    const allAnswered = totalQuestions > 0 && answeredCount >= totalQuestions;
    const remainingToAnswer = Math.max(0, totalQuestions - answeredCount);

    const question = questions[current];

    function choose(qId: number, label: string) {
        setAnswers((prev) => ({ ...prev, [qId]: label }));
    }

    const submit = useMemo(
        () => () => {
            if (submitting || !pkg) return;
            if (!allAnswered) return;
            setSubmitting(true);
            router.post(route('tryouts.submit', pkg.slug), { answers, duration_seconds: elapsed }, {
                onFinish: () => setSubmitting(false),
            });
        },
        [submitting, pkg, answers, elapsed, allAnswered],
    );

    // Auto-submit saat waktu habis (hanya bila semua sudah terjawab, jika tidak, kunci).
    useEffect(() => {
        if (hasTimer && remaining <= 0) {
            if (allAnswered) submit();
        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [remaining, hasTimer, allAnswered]);

    if (!pkg || questions.length === 0) {
        return (
            <PortalLayout>
                <Head title="Tryout" />
                <section className="rounded-2xl bg-white p-8 text-center shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <p className="text-sm font-semibold text-[#727783]">Tryout ini belum memiliki soal.</p>
                </section>
            </PortalLayout>
        );
    }

    const submitBtnBase = 'rounded-xl px-6 py-3 text-xs font-bold transition';
    const submitBtnClass = allAnswered
        ? `${submitBtnBase} bg-[#004b19] text-white hover:bg-[#003515] shadow-[0_8px_20px_rgba(0,75,25,0.18)]`
        : `${submitBtnBase} bg-[#e5e7eb] text-[#9ca3af] cursor-not-allowed`;

    return (
        <PortalLayout>
            <Head title={`Tryout - ${pkg.name}`} />
            <section className="grid gap-6 xl:grid-cols-[1fr_260px]">
                {/* Question Area */}
                <div className="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">{pkg.name} Â· {question.section}</p>
                            <h1 className="mt-1 text-2xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                                Soal {question.number} dari {questions.length}
                            </h1>
                        </div>
                        {hasTimer && (
                            <span className={`rounded-full px-4 py-2 text-xs font-bold ${remaining <= 60 ? 'bg-[#ffdbc8] text-[#a80606]' : 'bg-[#f6f3f2] text-[#727783]'}`}>
                                {formatClock(remaining)}
                            </span>
                        )}
                    </div>

                    <p className="mt-6 whitespace-pre-line text-sm font-medium leading-7 text-[#1b1c1c]">{question.text}</p>

                    {question.image && (
                        <div className="mt-5 overflow-hidden rounded-xl bg-[#eae7e7]">
                            <img src={`/${question.image}`} alt="" className="h-48 w-full object-cover" />
                        </div>
                    )}

                    <div className="mt-5 space-y-3">
                        {question.answers.map((answer) => {
                            const selected = answers[question.id] === answer.label;
                            return (
                                <label
                                    key={answer.label}
                                    className={`flex cursor-pointer items-center gap-3 rounded-xl border px-4 py-4 transition ${
                                        selected ? 'border-[#a80606] bg-[#fff1f1]' : 'border-[#f0eded] bg-[#f8f7f7] hover:border-[#d9a1a1]'
                                    }`}
                                >
                                    <span
                                        className={`flex size-7 shrink-0 items-center justify-center rounded-full text-[11px] font-bold ${
                                            selected ? 'bg-[#a80606] text-white' : 'bg-white text-[#727783] border border-[#f0eded]'
                                        }`}
                                    >
                                        {answer.label}
                                    </span>
                                    <input
                                        type="radio"
                                        name={`q-${question.id}`}
                                        checked={selected}
                                        onChange={() => choose(question.id, answer.label)}
                                        className="sr-only"
                                    />
                                    <span className="text-sm font-semibold">{answer.text}</span>
                                </label>
                            );
                        })}
                    </div>

                    <div className="mt-6 flex items-center justify-between gap-3">
                        <button
                            type="button"
                            onClick={() => setCurrent((c) => Math.max(0, c - 1))}
                            disabled={current === 0}
                            className="rounded-xl bg-[#a80606] px-5 py-3 text-xs font-bold text-white disabled:opacity-40"
                        >
                            &lt; Sebelumnya
                        </button>
                        {current < questions.length - 1 ? (
                            <button
                                type="button"
                                onClick={() => setCurrent((c) => Math.min(questions.length - 1, c + 1))}
                                className="rounded-xl bg-[#a80606] px-5 py-3 text-xs font-bold text-white"
                            >
                                Selanjutnya &gt;
                            </button>
                        ) : (
                            <div className="flex flex-col items-end gap-1">
                                <button
                                    type="button"
                                    onClick={submit}
                                    disabled={submitting || !allAnswered}
                                    className={submitBtnClass}
                                >
                                    {submitting ? 'Mengirim...' : allAnswered ? 'Selesai & Kirim' : `Selesaikan ${remainingToAnswer} soal lagi`}
                                </button>
                                {!allAnswered && (
                                    <span className="text-[11px] font-semibold text-[#a80606]">
                                        Tombol terkunci sampai semua soal terjawab.
                                    </span>
                                )}
                            </div>
                        )}
                    </div>
                </div>

                {/* Sidebar */}
                <aside className="space-y-5">
                    <section className="rounded-2xl bg-white p-5 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                        <h2 className="text-lg font-bold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Navigasi Soal</h2>
                        <p className="mt-1 text-xs font-medium text-[#727783]">{answeredCount}/{questions.length} terjawab</p>
                        <div className="mt-4 grid grid-cols-5 gap-2">
                            {questions.map((q, i) => {
                                const answered = answers[q.id] !== undefined;
                                const isCurrent = i === current;
                                return (
                                    <button
                                        key={q.id}
                                        type="button"
                                        onClick={() => setCurrent(i)}
                                        className={`size-9 rounded-lg text-xs font-bold transition ${
                                            isCurrent
                                                ? 'bg-[#a80606] text-white'
                                                : answered
                                                    ? 'bg-[#004b19] text-white'
                                                    : 'bg-[#f0eded] text-[#727783] hover:bg-[#eae7e7]'
                                        }`}
                                    >
                                        {i + 1}
                                    </button>
                                );
                            })}
                        </div>
                        <div className="mt-4 flex flex-col gap-1 text-[11px] font-semibold text-[#727783]">
                            <span className="flex items-center gap-2"><span className="size-2.5 rounded-full bg-[#a80606]" /> Sekarang</span>
                            <span className="flex items-center gap-2"><span className="size-2.5 rounded-full bg-[#004b19]" /> Terjawab</span>
                        </div>
                        <button
                            type="button"
                            onClick={submit}
                            disabled={submitting || !allAnswered}
                            className={`mt-5 w-full rounded-xl px-4 py-3 text-sm font-bold transition ${
                                allAnswered
                                    ? 'bg-[#004b19] text-white hover:bg-[#003515] shadow-[0_8px_20px_rgba(0,75,25,0.18)]'
                                    : 'bg-[#e5e7eb] text-[#9ca3af] cursor-not-allowed'
                            }`}
                        >
                            {submitting ? 'Mengirim...' : allAnswered ? 'Selesai & Kirim' : `Terkunci · ${remainingToAnswer} soal belum dijawab`}
                        </button>
                    </section>
                </aside>
            </section>
        </PortalLayout>
    );
}