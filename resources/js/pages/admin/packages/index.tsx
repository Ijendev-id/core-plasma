import { Head, Link, router } from '@inertiajs/react';
import AdminLayout from '../../../layouts/AdminLayout';

interface Stat {
    label: string;
    value: string;
    accent: string;
    meta?: string | number;
    meta_type?: string;
}

interface Package {
    name: string;
    slug: string;
    icon: string;
    tone: string;
    category: string;
    questions: string;
    participants: string;
    has_participant_preview: boolean;
    price: string;
    status: string;
    status_label: string;
}

interface Pagination {
    from: number;
    to: number;
    total: number;
    current: number;
    last_page: number;
}

interface Helpers {
    bulk_upload: { title: string; description: string; button: string; image: string };
    tip: { title: string; description: string };
}

interface Props {
    stats: Stat[];
    packages: Package[];
    paginator: { previousPageUrl?: string; nextPageUrl?: string; url: (page: number) => string };
    pagination: Pagination;
    helpers: Helpers;
    flash?: { status?: string };
}

const TONE_CLASSES: Record<string, { overlay: string; avatar: string }> = {
    blue: { overlay: 'bg-[#00407f]/5 text-[#00407f]', avatar: 'bg-[#00407f]' },
    amber: { overlay: 'bg-[#984800]/5 text-[#984800]', avatar: 'bg-[#984800]' },
    muted: { overlay: 'bg-[#727783]/5 text-[#727783]', avatar: 'bg-[#727783]' },
};

const ACCENT_CLASSES: Record<string, string> = {
    blue: 'border-l-[#00407f]',
    amber: 'border-l-[#984800]',
    green: 'border-l-[#004b19]',
};

function PackageIcon({ icon, className }: { icon: string; className?: string }) {
    if (icon === 'rocket') {
        return (
            <svg className={className} viewBox="0 0 24 24" fill="none">
                <path d="M5 16c-1.2 1-2 2.7-2 5c2.3 0 4-0.8 5-2M9 15l-2-2c0-4.5 3.5-8.5 10.5-10.5C19.5 9.5 15.5 13 11 13l-2 2ZM14 6l4 4" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
        );
    }
    if (icon === 'briefcase') {
        return (
            <svg className={className} viewBox="0 0 24 24" fill="none">
                <path d="M9 7V5.8A1.8 1.8 0 0 1 10.8 4h2.4A1.8 1.8 0 0 1 15 5.8V7M5 8h14a1 1 0 0 1 1 1v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9a1 1 0 0 1 1-1Z" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
        );
    }
    if (icon === 'school') {
        return (
            <svg className={className} viewBox="0 0 24 24" fill="none">
                <path d="M12 3l8 4.5l-8 4.5l-8-4.5L12 3ZM6.5 10.5V16c0 1.7 2.5 3 5.5 3s5.5-1.3 5.5-3v-5.5" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
        );
    }
    return (
        <svg className={className} viewBox="0 0 24 24" fill="none">
            <path d="M12 4L3.5 8.5L12 13L20.5 8.5L12 4ZM6 11v4.5c0 1.4 2.7 3.5 6 3.5s6-2.1 6-3.5V11" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" />
        </svg>
    );
}

export default function PackagesIndex({ stats, packages, pagination, helpers, flash }: Props) {
    function handleDelete(slug: string, name: string) {
        if (confirm(`Hapus package "${name}"?`)) {
            router.delete(route('admin.packages.destroy', slug));
        }
    }

    const pages = Array.from({ length: Math.min(3, pagination.last_page) }, (_, i) => i + 1);

    return (
        <AdminLayout>
            <Head title="Package Inventory" />
            <main className="pb-[56px] pt-[112px] lg:ml-[288px] lg:w-[calc(100%-288px)] lg:px-12">
                <div className="flex w-full flex-col gap-8 p-8">
                    {/* Header */}
                    <section className="flex flex-col gap-6">
                        <div className="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                            <div>
                                <h1 className="text-4xl font-extrabold leading-10 text-[#1b1c1c]" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>
                                    Package Inventory
                                </h1>
                                <p className="mt-1 text-base font-medium leading-6 text-[#727783]">Manage and curate your elite academic tryout offerings.</p>
                            </div>
                            <Link
                                href={route('admin.packages.create')}
                                className="inline-flex h-[52px] items-center justify-center gap-2 rounded-xl bg-gradient-to-br from-[#7f1c00] to-[#a80606] px-6 text-base font-semibold text-white shadow-[0_10px_15px_-3px_rgba(0,64,127,0.2)] transition hover:-translate-y-px"
                            >
                                <svg className="size-5" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 5v14M5 12h14" stroke="currentColor" strokeWidth="2.2" strokeLinecap="round" />
                                    <circle cx="12" cy="12" r="9" stroke="currentColor" strokeWidth="2" />
                                </svg>
                                <span>Create New Package</span>
                            </Link>
                        </div>

                        {/* Stats */}
                        <div className="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                            {stats.map((stat, i) => (
                                stat.accent === 'premium' ? (
                                    <article key={i} className="relative min-h-[108px] overflow-hidden rounded-xl bg-[#7f2000] p-6 text-white shadow-[0_20px_25px_-5px_rgba(0,64,127,0.1)]">
                                        <p className="text-xs font-semibold uppercase leading-4 tracking-[0.6px] text-white/80">{stat.label}</p>
                                        <p className="mt-2 text-3xl font-extrabold leading-9" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>{stat.value}</p>
                                    </article>
                                ) : (
                                    <article key={i} className={`${ACCENT_CLASSES[stat.accent] ?? 'border-l-[#00407f]'} min-h-[108px] rounded-xl border-l-4 bg-white px-6 py-6 shadow-[0_8px_30px_rgba(0,0,0,0.04)]`}>
                                        <p className="text-xs font-semibold uppercase leading-4 tracking-[0.6px] text-[#727783]">{stat.label}</p>
                                        <div className="mt-2 flex items-end justify-between gap-4">
                                            <p className="text-3xl font-extrabold leading-9" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>{stat.value}</p>
                                            {stat.meta_type === 'trend' && (
                                                <span className="inline-flex items-center gap-1 rounded-lg bg-[#8cfa96] px-2 py-1 text-xs font-semibold text-[#004b19]">{stat.meta}</span>
                                            )}
                                            {stat.meta_type === 'live' && (
                                                <span className="rounded-lg bg-[#ffdbc8] px-2 py-1 text-xs font-semibold text-[#984800]">{stat.meta}</span>
                                            )}
                                            {stat.meta_type === 'progress' && (
                                                <span className="mb-2 block h-2 w-16 overflow-hidden rounded-full bg-[#eae7e7]">
                                                    <span className="block h-full rounded-full bg-[#004b19]" style={{ width: `${stat.meta}%` }} />
                                                </span>
                                            )}
                                        </div>
                                    </article>
                                )
                            ))}
                        </div>
                    </section>

                    {/* Table */}
                    <section className="overflow-hidden rounded-2xl bg-[#f6f3f2] shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
                        {flash?.status && (
                            <div className="mx-4 mt-4 rounded-xl border border-[#8cfa96] bg-[#8cfa96]/25 px-4 py-3 text-sm font-semibold text-[#004b19]">
                                {flash.status}
                            </div>
                        )}

                        <div className="overflow-x-auto px-4 py-2">
                            <table className="w-full min-w-[800px] border-separate border-spacing-y-2 text-left">
                                <thead>
                                    <tr>
                                        {['Package Name', 'Category', 'Questions', 'Participants', 'Price', 'Aksi', 'Actions'].map((h) => (
                                            <th key={h} className="px-6 py-4 text-xs font-semibold uppercase leading-4 tracking-[1.2px] text-[#727783]">{h}</th>
                                        ))}
                                    </tr>
                                </thead>
                                <tbody>
                                    {packages.length === 0 ? (
                                        <tr>
                                            <td colSpan={7} className="rounded-sm bg-white px-6 py-10 text-center text-sm font-medium text-[#727783]">
                                                Package tidak ditemukan.
                                            </td>
                                        </tr>
                                    ) : (
                                        packages.map((pkg) => {
                                            const tone = TONE_CLASSES[pkg.tone] ?? TONE_CLASSES.blue;
                                            return (
                                                <tr key={pkg.slug} className="group bg-white">
                                                    <td className="rounded-l-sm px-6 py-4">
                                                        <div className="flex items-center gap-3">
                                                            <span className={`${tone.overlay} inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg`}>
                                                                <PackageIcon icon={pkg.icon} className="size-5" />
                                                            </span>
                                                            <span className="max-w-[11rem] text-base font-semibold leading-tight text-[#1b1c1c]">{pkg.name}</span>
                                                        </div>
                                                    </td>
                                                    <td className="px-6 py-4">
                                                        <span className="inline-flex rounded-lg bg-[#eae7e7] px-3 py-1 text-[11px] font-semibold uppercase text-[#1b1c1c]">{pkg.category}</span>
                                                    </td>
                                                    <td className="px-6 py-4 text-base font-medium text-[#727783]">{pkg.questions}</td>
                                                    <td className="px-6 py-4">
                                                        {pkg.has_participant_preview ? (
                                                            <div className="flex items-center">
                                                                <span className="-mr-2 size-7 rounded-full border-2 border-white bg-[#e2e8f0]"></span>
                                                                <span className="-mr-2 size-7 rounded-full border-2 border-white bg-[#cbd5e1]"></span>
                                                                <span className={`${tone.avatar} inline-flex h-7 min-w-8 items-center justify-center rounded-full border-2 border-white px-1 text-[10px] font-semibold text-white`}>
                                                                    {pkg.participants}
                                                                </span>
                                                            </div>
                                                        ) : (
                                                            <span className="text-base font-medium text-[#1b1c1c]">{pkg.participants}</span>
                                                        )}
                                                    </td>
                                                    <td className="px-6 py-4">
                                                        <span className="block max-w-[86px] text-base font-semibold leading-tight text-[#00407f]">
                                                            {pkg.price.replace(' ', '\n')}
                                                        </span>
                                                    </td>
                                                    <td className="px-6 py-4">
                                                        <div className="flex items-center gap-2">
                                                            <span className={`${pkg.status === 'published' ? 'bg-[#004b19]' : 'bg-[#727783]'} size-2 rounded-full`}></span>
                                                            <div className={`flex flex-col text-xs font-semibold leading-4 ${pkg.status === 'published' ? 'text-[#004b19]' : 'text-[#727783]'}`}>
                                                                <span>{pkg.status_label}</span>
                                                                <Link href={route('admin.packages.tryout', pkg.slug)} className="hover:underline">edit soal</Link>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td className="rounded-r-sm px-6 py-4">
                                                        <div className="flex items-center justify-end gap-1 opacity-0 transition group-hover:opacity-100">
                                                            <Link
                                                                href={route('admin.packages.edit', pkg.slug)}
                                                                className="inline-flex size-8 items-center justify-center rounded-lg text-[#00407f] transition hover:bg-[#00407f]/10"
                                                                aria-label={`Edit ${pkg.name}`}
                                                            >
                                                                <svg className="size-4" viewBox="0 0 24 24" fill="none">
                                                                    <path d="M4 20h4L18.5 9.5a2.12 2.12 0 0 0-3-3L5 17v3ZM13.5 8.5l3 3" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" />
                                                                </svg>
                                                            </Link>
                                                            <button
                                                                type="button"
                                                                onClick={() => handleDelete(pkg.slug, pkg.name)}
                                                                className="inline-flex size-8 items-center justify-center rounded-lg text-[#a80606] transition hover:bg-[#a80606]/10"
                                                                aria-label={`Delete ${pkg.name}`}
                                                            >
                                                                <svg className="size-4" viewBox="0 0 24 24" fill="none">
                                                                    <path d="M5 7h14M10 11v6M14 11v6M9 7l1-2h4l1 2M7 7l1 13h8l1-13" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            );
                                        })
                                    )}
                                </tbody>
                            </table>
                        </div>

                        {/* Pagination */}
                        <div className="flex flex-col gap-4 bg-[#f0eded] px-6 py-4 sm:flex-row sm:items-center sm:justify-between lg:px-8">
                            <p className="text-xs font-medium leading-4 text-[#727783]">
                                Showing {pagination.from} to {pagination.to} of {pagination.total} packages
                            </p>
                            <nav className="flex items-center gap-1" aria-label="Pagination">
                                <Link
                                    href={pagination.current > 1 ? route('admin.packages.index', { page: pagination.current - 1 }) : '#'}
                                    className={`inline-flex size-8 items-center justify-center rounded-lg text-[#727783] transition ${pagination.current <= 1 ? 'pointer-events-none opacity-40' : 'hover:bg-white'}`}
                                >
                                    <svg className="h-3 w-2" viewBox="0 0 8 12" fill="none"><path d="M6.5 1L1.5 6L6.5 11" stroke="currentColor" strokeWidth="1.7" strokeLinecap="round" strokeLinejoin="round" /></svg>
                                </Link>
                                {pages.map((page) => (
                                    <Link
                                        key={page}
                                        href={route('admin.packages.index', { page })}
                                        className={`inline-flex size-8 items-center justify-center rounded-lg text-xs font-semibold transition ${page === pagination.current ? 'bg-[#00407f] text-white' : 'text-[#727783] hover:bg-white'}`}
                                    >
                                        {page}
                                    </Link>
                                ))}
                                {pagination.last_page > 4 && <span className="px-2 text-base leading-6 text-[#727783]">...</span>}
                                {pagination.last_page > 3 && (
                                    <Link
                                        href={route('admin.packages.index', { page: pagination.last_page })}
                                        className={`inline-flex size-8 items-center justify-center rounded-lg text-xs font-semibold transition ${pagination.last_page === pagination.current ? 'bg-[#00407f] text-white' : 'text-[#727783] hover:bg-white'}`}
                                    >
                                        {pagination.last_page}
                                    </Link>
                                )}
                                <Link
                                    href={pagination.current < pagination.last_page ? route('admin.packages.index', { page: pagination.current + 1 }) : '#'}
                                    className={`inline-flex size-8 items-center justify-center rounded-lg text-[#727783] transition ${pagination.current >= pagination.last_page ? 'pointer-events-none opacity-40' : 'hover:bg-white'}`}
                                >
                                    <svg className="h-3 w-2" viewBox="0 0 8 12" fill="none"><path d="M1.5 1L6.5 6L1.5 11" stroke="currentColor" strokeWidth="1.7" strokeLinecap="round" strokeLinejoin="round" /></svg>
                                </Link>
                            </nav>
                        </div>
                    </section>

                    {/* Helper Cards */}
                    <section className="grid gap-8 lg:grid-cols-2">
                        <article className="relative min-h-[204px] overflow-hidden rounded-2xl p-8 text-white">
                            <img src={`/${helpers.bulk_upload.image}`} alt="" className="absolute inset-0 h-full w-full object-cover" />
                            <div className="absolute inset-0 bg-gradient-to-r from-[#7f0f00]/90 to-[#00407f]/0"></div>
                            <div className="relative flex max-w-md flex-col items-start gap-3">
                                <h2 className="text-xl font-bold leading-7" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>{helpers.bulk_upload.title}</h2>
                                <p className="text-sm font-normal leading-5 text-white/90">{helpers.bulk_upload.description}</p>
                                <a href="#" className="mt-1 inline-flex rounded-lg bg-white px-4 py-2 text-xs font-semibold text-[#7f0800] transition hover:bg-[#fff7f5]">
                                    {helpers.bulk_upload.button}
                                </a>
                            </div>
                        </article>

                        <article className="flex min-h-[204px] flex-col justify-center rounded-2xl bg-[#ffdbc8] p-8 text-[#311300]">
                            <span className="inline-flex size-10 items-center justify-center rounded-full bg-[#fd811d] text-white">
                                <svg className="h-5 w-[15px]" viewBox="0 0 18 24" fill="none">
                                    <path d="M9 2a7 7 0 0 0-4 12.75V18h8v-3.25A7 7 0 0 0 9 2Z" fill="currentColor" />
                                    <path d="M6.5 21h5" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />
                                </svg>
                            </span>
                            <h2 className="mt-5 text-xl font-bold leading-7" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>{helpers.tip.title}</h2>
                            <p className="mt-3 max-w-md text-sm font-normal leading-5 text-[#311300]/80">{helpers.tip.description}</p>
                        </article>
                    </section>
                </div>
            </main>
        </AdminLayout>
    );
}
