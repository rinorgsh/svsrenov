import '../css/app.css';
import './bootstrap';

import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Fonction pour envoyer les page views à Google Analytics
function trackPageView(url: string) {
    if (typeof window !== 'undefined' && typeof window.gtag === 'function') {
        window.gtag('config', import.meta.env.VITE_GA_MEASUREMENT_ID, {
            page_path: url,
        });
    }
}

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// Tracker la première page view
if (typeof window !== 'undefined') {
    trackPageView(window.location.pathname + window.location.search);
}

// Tracker les page views lors de la navigation Inertia
router.on('navigate', (event) => {
    trackPageView(event.detail.page.url);
});
