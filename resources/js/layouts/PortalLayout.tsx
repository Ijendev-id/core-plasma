import { Link, router, usePage } from '@inertiajs/react';
import { type ReactNode } from 'react';
import { type PageProps } from '../types';

interface Props {
    children: ReactNode;
}

export default function PortalLayout({ children }: Props) {
    const { auth } = usePage<PageProps>().props;
    const member = auth?.member;

    function handleLogout(e: React.FormEvent) {
        e.preventDefault();
        router.post(route('member.logout'));
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

            {/* Header */}
            <header className="fixed left-0 right-0 top-0 z-10 flex h-[72px] items-center justify-between bg-white/90 px-5 shadow-[0_1px_20px_rgba(0,0,0,0.03)] backdrop-blur lg:left-[176px] lg:px-8">
                <div />
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
