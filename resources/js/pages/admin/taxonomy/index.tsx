import { Head, router } from '@inertiajs/react';
import { useState, type FormEvent } from 'react';
import AdminLayout from '../../../layouts/AdminLayout';

interface Section {
    id: number;
    code: string;
    name: string | null;
}

interface Category {
    id: number;
    name: string;
    sections: Section[];
}

interface Props {
    categories: Category[];
    flash?: { status?: string };
}

export default function Taxonomy({ categories, flash }: Props) {
    const [newCategory, setNewCategory] = useState('');
    // form tambah section per kategori: { [categoryId]: { code, name } }
    const [sectionForm, setSectionForm] = useState<Record<number, { code: string; name: string }>>({});

    function setSection(catId: number, field: 'code' | 'name', value: string) {
        setSectionForm((prev) => ({
            ...prev,
            [catId]: { code: '', name: '', ...prev[catId], [field]: value },
        }));
    }

    function addCategory(e: FormEvent) {
        e.preventDefault();
        const name = newCategory.trim();
        if (!name) return;
        router.post(route('admin.taxonomy.categories.store'), { name }, {
            preserveScroll: true,
            onSuccess: () => setNewCategory(''),
        });
    }

    function deleteCategory(id: number) {
        if (!confirm('Hapus kategori ini? Semua section di dalamnya ikut terhapus.')) return;
        router.delete(route('admin.taxonomy.categories.destroy', id), { preserveScroll: true });
    }

    function addSection(catId: number, e: FormEvent) {
        e.preventDefault();
        const form = sectionForm[catId] ?? { code: '', name: '' };
        const code = form.code.trim();
        if (!code) return;
        router.post(route('admin.tryout-sections.store'), {
            tryout_category_id: catId,
            code,
            name: form.name.trim() || null,
        }, {
            preserveScroll: true,
            onSuccess: () => setSectionForm((prev) => ({ ...prev, [catId]: { code: '', name: '' } })),
        });
    }

    function deleteSection(id: number) {
        if (!confirm('Hapus section ini?')) return;
        router.delete(route('admin.tryout-sections.destroy', id), { preserveScroll: true });
    }

    return (
        <AdminLayout>
            <Head title="Kategori & Section" />
            <main className="min-h-screen px-5 pb-10 pt-[104px] lg:ml-[288px] lg:px-12">
                <section>
                    <h1 className="text-3xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Kategori &amp; Section Tryout</h1>
                    <p className="mt-2 text-sm font-medium text-[#727783]">Tiap kategori tryout punya section-nya sendiri. Label section opsional (boleh kosong).</p>

                    {flash?.status && (
                        <div className="mt-5 rounded-xl bg-[#8cfa96]/30 px-4 py-3 text-sm font-bold text-[#004b19]">{flash.status}</div>
                    )}

                    {/* Tambah kategori */}
                    <form onSubmit={addCategory} className="mt-6 flex max-w-xl items-center gap-2">
                        <input
                            type="text"
                            value={newCategory}
                            onChange={(e) => setNewCategory(e.target.value)}
                            placeholder="Nama kategori baru, mis. KEDINASAN"
                            className="h-11 flex-1 rounded-xl border border-[#e5e0df] px-3 text-sm font-semibold uppercase outline-none focus:border-[#00407f]"
                        />
                        <button type="submit" className="h-11 rounded-xl bg-[#a80606] px-5 text-sm font-bold text-white transition hover:-translate-y-px">
                            + Kategori
                        </button>
                    </form>

                    {/* Daftar kategori + section */}
                    <div className="mt-8 grid gap-6 lg:grid-cols-2">
                        {categories.length === 0 && (
                            <p className="text-sm font-medium text-[#727783]">Belum ada kategori. Tambahkan dulu di atas.</p>
                        )}
                        {categories.map((cat) => {
                            const form = sectionForm[cat.id] ?? { code: '', name: '' };
                            return (
                                <section key={cat.id} className="rounded-2xl bg-white p-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                                    <div className="flex items-center justify-between">
                                        <h2 className="text-xl font-bold uppercase" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>{cat.name}</h2>
                                        <button
                                            type="button"
                                            onClick={() => deleteCategory(cat.id)}
                                            className="text-xs font-bold text-[#d40f22] transition hover:underline"
                                        >
                                            Hapus Kategori
                                        </button>
                                    </div>
                                    <p className="mt-1 text-xs font-medium text-[#727783]">{cat.sections.length} section</p>

                                    <div className="mt-4 space-y-2">
                                        {cat.sections.length === 0 ? (
                                            <p className="text-sm font-medium text-[#727783]">Belum ada section untuk kategori ini.</p>
                                        ) : (
                                            cat.sections.map((sec) => (
                                                <div key={sec.id} className="flex items-center justify-between rounded-xl bg-[#f6f3f2] px-4 py-3">
                                                    <div>
                                                        <span className="text-sm font-bold uppercase text-[#1b1c1c]">{sec.code}</span>
                                                        {sec.name && <span className="ml-2 text-xs font-medium text-[#727783]">{sec.name}</span>}
                                                    </div>
                                                    <button
                                                        type="button"
                                                        onClick={() => deleteSection(sec.id)}
                                                        className="text-xs font-bold text-[#d40f22] transition hover:underline"
                                                    >
                                                        Hapus
                                                    </button>
                                                </div>
                                            ))
                                        )}
                                    </div>

                                    <form onSubmit={(e) => addSection(cat.id, e)} className="mt-4 grid gap-2 sm:grid-cols-[1fr_1fr_auto]">
                                        <input
                                            type="text"
                                            value={form.code}
                                            onChange={(e) => setSection(cat.id, 'code', e.target.value)}
                                            placeholder="Kode, mis. TWK"
                                            className="h-11 rounded-xl border border-[#e5e0df] px-3 text-sm font-semibold uppercase outline-none focus:border-[#00407f]"
                                        />
                                        <input
                                            type="text"
                                            value={form.name}
                                            onChange={(e) => setSection(cat.id, 'name', e.target.value)}
                                            placeholder="Label (opsional)"
                                            className="h-11 rounded-xl border border-[#e5e0df] px-3 text-sm font-medium outline-none focus:border-[#00407f]"
                                        />
                                        <button type="submit" className="h-11 rounded-xl bg-[#00407f] px-4 text-sm font-bold text-white transition hover:bg-[#003366]">
                                            + Section
                                        </button>
                                    </form>
                                </section>
                            );
                        })}
                    </div>
                </section>
            </main>
        </AdminLayout>
    );
}
