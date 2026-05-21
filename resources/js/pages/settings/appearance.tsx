import { Head } from '@inertiajs/react';

export default function AppearanceSettings() {
    return (
        <>
            <Head title="Appearance Settings" />
            <div className="min-h-screen bg-[#f5f6f6] text-[#1b1c1c] antialiased" style={{ fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif' }}>
                <main className="mx-auto flex w-full max-w-[980px] flex-col gap-8 px-5 py-10 sm:px-8 lg:py-14">
                    <h1 className="text-4xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Appearance Settings</h1>
                    <div className="rounded-2xl bg-white p-8 shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                        <p className="text-sm text-[#727783]">Appearance settings coming soon.</p>
                    </div>
                </main>
            </div>
        </>
    );
}
