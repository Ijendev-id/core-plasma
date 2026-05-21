import { Head } from '@inertiajs/react';
import { useState } from 'react';
import PortalLayout from '../../layouts/PortalLayout';

interface Answer {
    label: string;
    text: string;
    state: 'selected' | 'normal';
}

interface Question {
    number: number;
    total: number;
    text: string;
    image: string;
    answers: Answer[];
}

interface PaletteItem {
    number: number;
    state: 'done' | 'current' | 'empty';
}

interface PackageInfo {
    name: string;
    category: string;
}

interface Props {
    package: PackageInfo | null;
    question: Question;
    palette: PaletteItem[];
}

export default function Play({ package: pkg, question, palette }: Props) {
    const [selectedAnswer, setSelectedAnswer] = useState<string | null>(
        question.answers.find((a) => a.state === 'selected')?.label ?? null
    );
    const [doubtful, setDoubtful] = useState(false);

    return (
        <PortalLayout>
            <Head title="Tryout" />
            <section className="grid gap-6 xl:grid-cols-[1fr_260px]">
                {/* Question Area */}
                <div className="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                    <div className="flex items-center justify-between">
                        <div>
                            <p className="text-xs font-bold uppercase tracking-[1px] text-[#d40f22]">{pkg?.name ?? 'Tryout'}</p>
                            <h1 className="mt-1 text-2xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                                Soal {question.number} dari {question.total}
                            </h1>
                        </div>
                        <span className="rounded-full bg-[#f6f3f2] px-4 py-2 text-xs font-bold text-[#727783]">01:42:15</span>
                    </div>

                    <p className="mt-6 text-sm font-medium leading-7 text-[#1b1c1c]">{question.text}</p>

                    {question.image && (
                        <div className="mt-5 overflow-hidden rounded-xl bg-[#eae7e7]">
                            <img src={`/${question.image}`} alt="" className="h-48 w-full object-cover" />
                        </div>
                    )}

                    <div className="mt-5 space-y-3">
                        {question.answers.map((answer) => (
                            <label
                                key={answer.label}
                                className={`flex cursor-pointer items-center gap-3 rounded-xl border px-4 py-4 ${
                                    selectedAnswer === answer.label
                                        ? 'border-[#a80606] bg-[#d9a1a1]'
                                        : 'border-[#f0eded] bg-[#f8f7f7]'
                                }`}
                            >
                                <span
                                    className={`inline-flex size-6 items-center justify-center rounded-md text-xs font-bold ${
                                        selectedAnswer === answer.label ? 'bg-[#a80606] text-white' : 'bg-white text-[#727783]'
                                    }`}
                                >
                                    {answer.label}
                                </span>
                                <input
                                    type="radio"
                                    name="answer"
                                    value={answer.label}
                                    checked={selectedAnswer === answer.label}
                                    onChange={() => setSelectedAnswer(answer.label)}
                                    className="sr-only"
                                />
                                <span className="text-sm font-semibold">{answer.text}</span>
                            </label>
                        ))}
                    </div>

                    <div className="mt-6 flex items-center justify-between">
                        <button className="rounded-xl bg-[#a80606] px-5 py-3 text-xs font-bold text-white">&lt; Sebelumnya</button>
                        <label className="flex items-center gap-2 text-xs font-semibold text-[#727783]">
                            <input
                                type="checkbox"
                                checked={doubtful}
                                onChange={(e) => setDoubtful(e.target.checked)}
                                className="size-4 rounded border-[#cfcaca]"
                            />
                            Ragu-ragu
                        </label>
                        <button className="rounded-xl bg-[#a80606] px-5 py-3 text-xs font-bold text-white">Selanjutnya &gt;</button>
                    </div>
                </div>

                {/* Sidebar */}
                <aside className="space-y-5">
                    <section className="rounded-2xl bg-white p-5 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                        <h2 className="text-lg font-bold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Navigasi Soal</h2>
                        <div className="mt-4 grid grid-cols-5 gap-2">
                            {palette.map((item) => (
                                <button
                                    key={item.number}
                                    className={`size-9 rounded-lg text-xs font-bold ${
                                        item.state === 'done'
                                            ? 'bg-[#004b19] text-white'
                                            : item.state === 'current'
                                              ? 'bg-[#a80606] text-white'
                                              : 'bg-[#f0eded] text-[#727783]'
                                    }`}
                                >
                                    {item.number}
                                </button>
                            ))}
                        </div>
                        <div className="mt-5 rounded-xl bg-[#f6f3f2] p-4">
                            <p className="text-xs font-bold uppercase text-[#984800]">Current Package</p>
                            <p className="mt-1 text-sm font-bold">{pkg?.name}</p>
                        </div>
                    </section>
                </aside>
            </section>
        </PortalLayout>
    );
}
