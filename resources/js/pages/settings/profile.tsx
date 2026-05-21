import { Head, useForm, usePage } from '@inertiajs/react';
import { type FormEvent } from 'react';
import { type PageProps } from '../../types';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

export default function ProfileSettings({ mustVerifyEmail, status }: Props) {
    const { auth } = usePage<PageProps>().props;
    const user = auth?.user;

    const { data, setData, patch, processing, errors } = useForm({
        name: user?.name ?? '',
        email: user?.email ?? '',
    });

    function handleSubmit(e: FormEvent) {
        e.preventDefault();
        patch(route('profile.update'));
    }

    return (
        <>
            <Head title="Profile Settings" />
            <div className="min-h-screen bg-[#f5f6f6] text-[#1b1c1c] antialiased" style={{ fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif' }}>
                <main className="mx-auto flex w-full max-w-[980px] flex-col gap-8 px-5 py-10 sm:px-8 lg:py-14">
                    <h1 className="text-4xl font-extrabold" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>Profile Settings</h1>

                    {status && (
                        <div className="rounded-xl border border-[#8cfa96] bg-[#8cfa96]/25 px-4 py-3 text-sm font-semibold text-[#004b19]">
                            {status}
                        </div>
                    )}

                    <form onSubmit={handleSubmit} className="overflow-hidden rounded-2xl bg-white shadow-[0_8px_30px_rgba(0,0,0,0.04)]">
                        <div className="grid gap-6 p-6 md:grid-cols-2 lg:p-8">
                            <div className="md:col-span-2">
                                <label htmlFor="name" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Name</label>
                                <input
                                    id="name"
                                    type="text"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white"
                                />
                                {errors.name && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.name}</p>}
                            </div>

                            <div className="md:col-span-2">
                                <label htmlFor="email" className="text-xs font-semibold uppercase tracking-[0.8px] text-[#727783]">Email</label>
                                <input
                                    id="email"
                                    type="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    required
                                    className="mt-2 h-12 w-full rounded-xl border border-[#e0dddd] bg-[#f8f7f7] px-4 text-sm font-semibold text-[#1b1c1c] outline-none transition focus:border-[#00407f] focus:bg-white"
                                />
                                {errors.email && <p className="mt-2 text-sm font-semibold text-[#a80606]">{errors.email}</p>}
                            </div>
                        </div>

                        <div className="flex justify-end gap-3 bg-[#f0eded] px-6 py-4 lg:px-8">
                            <button
                                type="submit"
                                disabled={processing}
                                className="inline-flex h-11 items-center justify-center rounded-xl bg-gradient-to-br from-[#7f1c00] to-[#a80606] px-5 text-sm font-semibold text-white disabled:opacity-70"
                            >
                                {processing ? 'Menyimpan...' : 'Save Changes'}
                            </button>
                        </div>
                    </form>
                </main>
            </div>
        </>
    );
}
