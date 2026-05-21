import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';
import { route as ziggyRoute } from 'ziggy-js';

declare global {
    function route(name?: string, params?: unknown, absolute?: boolean): string;
    // eslint-disable-next-line no-var
    var Ziggy: object;
}

// Make route() available globally
window.route = (name?: string, params?: unknown, absolute?: boolean) =>
    ziggyRoute(name, params as Record<string, unknown>, absolute, window.Ziggy as Parameters<typeof ziggyRoute>[3]);

const appName = document.querySelector('meta[name="app-name"]')?.getAttribute('content') ?? 'Core Plasma';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(`./pages/${name}.tsx`, import.meta.glob('./pages/**/*.tsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} />);
    },
    progress: {
        color: '#d40f22',
    },
});
