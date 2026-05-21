import { Head, useForm } from '@inertiajs/react';
import { type FormEvent } from 'react';

interface Props {
    canManageTwoFactor?: boolean;
    twoFactorEnabled?: boolean;
}

export default function SecuritySettings({ canManageTwoFactor, twoFactorEnabled }: Props) {
    const { data, setData, put, processing, errors, reset } = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    function handleSubmit(e: FormEvent) {
        e.preventDefault();
        put(route('user-password.update'), {
            onSuccess: () => reset(),
        });
    }

    return (
        <>
            <Head title="Security Settings" />
            <div className="min-h-screen bg-[#f5f6f6] text-[#1b1c1c] antialiased" style={{ fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif' }}>
                <main className="mx-auto flex w-full max-w-[980px] flex-col gap-8 px-5 py-10 sm:px-8 lg:py-14">
                    <h1 className="text-4xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Security Settings</h1>

                    <form onSubmit={handleSubmit} className="overflow-hidden rounded-2xl bg-white shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                        <div className="grid gap-6 p-6 lg:p-8">
                            <div>
                                <label htmlFor="current_password" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Current Password</label>
                                <input
                                    id="current_password"
                                    type="password"
                                    value={data.current_password}
                                    onChange={(e) => setData('current_password', e.target.value)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white"
                                />
                                {errors.current_password && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.current_password}</p>}
                            </div>

                            <div>
                                <label htmlFor="password" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">New Password</label>
                                <input
                                    id="password"
                                    type="password"
                                    value={data.password}
                                    onChange={(e) => setData('password', e.target.value)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white"
                                />
                                {errors.password && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.password}</p>}
                            </div>

                            <div>
                                <label htmlFor="password_confirmation" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Confirm Password</label>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    value={data.password_confirmation}
                                    onChange={(e) => setData('password_confirmation', e.target.value)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white"
                                />
                            </div>
                        </div>

                        <div className="flex justify-end gap-3 bg-[#f0eded] px-6 py-4 lg:px-8">
                            <button
                                type="submit"
                                disabled={processing}
                                className="inline-flex h-11 items-center justify-center rounded-xl bg-gradient-to-br from-[#7f1c00] to-[#a80606] px-5 text-sm font-semibold text-white disabled:opacity-70"
                            >
                                {processing ? 'Menyimpan...' : 'Update Password'}
                            </button>
                        </div>
                    </form>
                </main>
            </div>
        </>
    );
}
