import { Link, router, usePage } from '@inertiajs/react';
import { useState, type ReactNode } from 'react';
import { type PageProps } from '../types';

interface Props {
    children: ReactNode;
}

export default function AdminLayout({ children }: Props) {
    const { auth } = usePage<PageProps>().props;
    const user = auth?.user;
    const [dropdownOpen, setDropdownOpen] = useState(false);

    function handleLogout(e: React.FormEvent) {
        e.preventDefault();
        router.post(route('admin.logout'));
    }

    return (
        <div className="min-h-screen bg-[#f5f6f6] text-[#1b1c1c] antialiased" style={{ fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif' }}>
            {/* Sidebar */}
            <aside className="fixed inset-y-0 left-0 z-20 hidden w-[288px] bg-white px-8 py-8 shadow-[12px_0_30px_rgba(0,0,0,0.04)] lg:block">
                <Link href={route('admin.dashboard')} className="text-sm font-extrabold text-[#d40f22]">Core Plasma</Link>
                <p className="mt-1 text-[10px] font-bold uppercase tracking-[1px] text-[#1b1c1c]">Academy Portal</p>
                <nav className="mt-12 flex flex-col gap-2 text-sm font-semibold text-[#727783]">
                    <Link
                        href={route('admin.dashboard')}
                        className={`rounded-lg px-3 py-3 ${route().current('admin.dashboard') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]'}`}
                    >
                        Dashboard
                    </Link>
                    <Link
                        href={route('admin.users.index')}
                        className={`rounded-lg px-3 py-3 ${route().current('admin.users.*') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]'}`}
                    >
                        User Management
                    </Link>
                    <Link
                        href={route('admin.packages.index')}
                        className={`rounded-lg px-3 py-3 ${route().current('admin.packages.*') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]'}`}
                    >
                        Tryout Inventory
                    </Link>
                    <Link
                        href={route('admin.taxonomy.index')}
                        className={`rounded-lg px-3 py-3 ${route().current('admin.taxonomy.*') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]'}`}
                    >
                        Kategori &amp; Section
                    </Link>
                    <Link
                        href={route('admin.leaderboard.index')}
                        className={`rounded-lg px-3 py-3 ${route().current('admin.leaderboard.*') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]'}`}
                    >
                        Leaderboard
                    </Link>
                </nav>
                <Link
                    href={route('admin.packages.create')}
                    className="absolute bottom-8 left-8 right-8 rounded-xl bg-[#a80606] px-4 py-4 text-center text-sm font-bold text-white shadow-[0_10px_20px_rgba(168,6,6,0.2)]"
                >
                    + New Course
                </Link>
            </aside>

            {/* Header */}
            <header className="fixed left-0 right-0 top-0 z-10 flex h-[80px] items-center justify-between bg-white/90 px-5 shadow-[0_1px_20px_rgba(0,0,0,0.03)] backdrop-blur lg:left-[288px] lg:px-8">
                <input type="search" placeholder="Search data..." className="h-8 w-72 rounded-full bg-[#f2f2f2] px-4 text-xs font-medium outline-none" />
                <div className="flex items-center gap-4">
                    <span className="size-2 rounded-full bg-[#d40f22]"></span>
                    <span className="text-xs font-semibold text-[#727783]">{user?.name ?? 'Core Admin'}</span>
                    <div className="relative">
                        <button
                            type="button"
                            onClick={() => setDropdownOpen(!dropdownOpen)}
                            className="size-8 rounded-full bg-[#00407f] focus:outline-none focus:ring-2 focus:ring-[#d40f22] focus:ring-offset-2"
                            aria-haspopup="true"
                            aria-expanded={dropdownOpen}
                            aria-label="Admin menu"
                        />
                        {dropdownOpen && (
                            <div className="absolute right-0 top-10 z-50 w-48 origin-top-right rounded-xl border border-gray-100 bg-white py-1 shadow-[0_8px_30px_rgba(0,0,0,0.12)]">
                                <div className="border-b border-gray-100 px-4 py-2">
                                    <p className="text-xs font-semibold text-[#1b1c1c]">{user?.name ?? 'Core Admin'}</p>
                                    <p className="truncate text-[10px] text-[#727783]">{user?.email ?? ''}</p>
                                </div>
                                <form onSubmit={handleLogout}>
                                    <button
                                        type="submit"
                                        className="flex w-full items-center gap-2 px-4 py-2 text-sm font-medium text-[#d40f22] transition hover:bg-[#fff1f1]"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" className="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                            <polyline points="16 17 21 12 16 7" />
                                            <line x1="21" y1="12" x2="9" y2="12" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        )}
                    </div>
                </div>
            </header>

            {children}
        </div>
    );
}
