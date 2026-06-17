import { Link, router, usePage } from '@inertiajs/react';
import { useState, type ReactNode, type FormEvent } from 'react';
import { type PageProps } from '../types';

interface Props {
    children: ReactNode;
}

export default function PortalLayout({ children }: Props) {
    const { auth } = usePage<PageProps>().props;
    const member = auth?.member;
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

    function handleLogout(e: FormEvent) {
        e.preventDefault();
        router.post(route('member.logout'));
    }

    function closeMobileMenu() {
        setMobileMenuOpen(false);
    }

    function handleNavigate() {
        closeMobileMenu();
    }

    return (
        <div className="min-h-screen bg-[#f6f7f8] text-[#1b1c1c] antialiased" style={{ fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif' }}>
            {/* Sidebar */}
            <aside className="fixed inset-y-0 left-0 z-20 hidden w-[176px] flex-col bg-white px-5 py-6 shadow-[12px_0_30px_rgba(0,0,0,0.04)] lg:flex">
                <Link href={route('dashboard')} className="text-sm font-extrabold text-[#d40f22]">Core Plasma</Link>
                <p className="mt-1 text-[10px] font-bold uppercase tracking-[1px] text-[#1b1c1c]">Academy Portal</p>
                <nav className="mt-10 flex flex-col gap-2 text-xs font-semibold text-[#727783]">
                    <Link
                        href={route('dashboard')}
                        className={`rounded-lg px-3 py-2 ${route().current('dashboard') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]'}`}
                    >
                        Dashboard
                    </Link>
                    <Link
                        href={route('tryouts.index')}
                        className={`rounded-lg px-3 py-2 ${route().current('tryouts.*') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]'}`}
                    >
                        My Try Out
                    </Link>
                    <Link
                        href={route('leaderboard')}
                        className={`rounded-lg px-3 py-2 ${route().current('leaderboard') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]'}`}
                    >
                        Leaderboard
                    </Link>
                    <Link
                        href={route('member.profile.edit')}
                        className={`rounded-lg px-3 py-2 ${route().current('member.profile.*') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]'}`}
                    >
                        Profil
                    </Link>
                </nav>
                <form onSubmit={handleLogout} className="mt-auto">
                    <button className="w-full rounded-lg bg-[#a80606] px-3 py-3 text-center text-xs font-bold text-white shadow-[0_10px_20px_rgba(168,6,6,0.2)]">
                        Logout
                    </button>
                </form>
            </aside>

            {mobileMenuOpen ? (
                <div className="fixed inset-0 z-30 bg-black/40 lg:hidden" onClick={closeMobileMenu} />
            ) : null}

            {/* Mobile Sidebar */}
            <aside
                className={`fixed inset-y-0 left-0 z-40 w-[82vw] max-w-[280px] flex-col bg-white px-5 py-6 shadow-[12px_0_30px_rgba(0,0,0,0.12)] transition-transform duration-300 lg:hidden ${
                    mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'
                }`}
            >
                <div className="flex items-start justify-between gap-4">
                    <div>
                        <Link href={route('dashboard')} onClick={handleNavigate} className="text-sm font-extrabold text-[#d40f22]">
                            Core Plasma
                        </Link>
                        <p className="mt-1 text-[10px] font-bold uppercase tracking-[1px] text-[#1b1c1c]">Academy Portal</p>
                    </div>
                    <button
                        type="button"
                        onClick={closeMobileMenu}
                        className="rounded-full bg-[#f6f7f8] px-3 py-2 text-xs font-bold text-[#1b1c1c]"
                        aria-label="Close menu"
                    >
                        Close
                    </button>
                </div>
                <nav className="mt-10 flex flex-col gap-2 text-xs font-semibold text-[#727783]">
                    <Link
                        href={route('dashboard')}
                        onClick={handleNavigate}
                        className={`rounded-lg px-3 py-2 ${route().current('dashboard') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]'}`}
                    >
                        Dashboard
                    </Link>
                    <Link
                        href={route('tryouts.index')}
                        onClick={handleNavigate}
                        className={`rounded-lg px-3 py-2 ${route().current('tryouts.*') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]'}`}
                    >
                        My Try Out
                    </Link>
                    <Link
                        href={route('leaderboard')}
                        onClick={handleNavigate}
                        className={`rounded-lg px-3 py-2 ${route().current('leaderboard') ? 'bg-[#fff1f1] text-[#d40f22]' : 'hover:bg-[#f6f3f2]'}`}
                    >
                        Leaderboard
                    </Link>
                </nav>
                <form onSubmit={handleLogout} className="mt-auto">
                    <button className="w-full rounded-lg bg-[#a80606] px-3 py-3 text-center text-xs font-bold text-white shadow-[0_10px_20px_rgba(168,6,6,0.2)]">
                        Logout
                    </button>
                </form>
            </aside>

            {/* Header */}
            <header className="fixed left-0 right-0 top-0 z-10 flex h-[72px] items-center justify-between bg-white/90 px-5 shadow-[0_1px_20px_rgba(0,0,0,0.03)] backdrop-blur lg:left-[176px] lg:px-8">
                <div className="flex items-center gap-3">
                    <button
                        type="button"
                        onClick={() => setMobileMenuOpen(true)}
                        className="group inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#f2f2f2] text-[#1b1c1c] transition-transform duration-300 active:scale-95 lg:hidden"
                        aria-label="Open menu"
                    >
                        <span className="sr-only">Open menu</span>
                        <span className="relative flex h-4 w-5 items-center justify-center">
                            <span className={`absolute h-0.5 w-5 rounded-full bg-current transition-all duration-300 ${mobileMenuOpen ? 'translate-y-0 rotate-45' : '-translate-y-1.5'}`} />
                            <span className={`absolute h-0.5 w-5 rounded-full bg-current transition-all duration-300 ${mobileMenuOpen ? 'scale-x-0 opacity-0' : 'opacity-100'}`} />
                            <span className={`absolute h-0.5 w-5 rounded-full bg-current transition-all duration-300 ${mobileMenuOpen ? 'translate-y-0 -rotate-45' : 'translate-y-1.5'}`} />
                        </span>
                    </button>
                    <input type="search" placeholder="Search here..." className="hidden h-8 w-64 rounded-full bg-[#f2f2f2] px-4 text-xs font-medium outline-none sm:block" />
                </div>
                <div className="flex items-center gap-4">
                    <span className="size-2 rounded-full bg-[#d40f22]"></span>
                    {member && (
                        <span className="hidden text-xs font-semibold text-[#727783] sm:inline">{member.name}</span>
                    )}
                    <Link href={route('member.profile.edit')} className="size-8 rounded-full bg-[#00407f]" aria-label="Profil" />
                </div>
            </header>

            {/* Main */}
            <main className="min-h-screen px-5 pb-10 pt-[96px] lg:ml-[176px] lg:px-8">
                {children}
            </main>
        </div>
    );
}
