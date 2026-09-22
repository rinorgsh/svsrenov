<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();
const currentYear = new Date().getFullYear();

const socialLinks = [
    {
        name: 'Facebook',
        href: 'https://www.facebook.com/p/SVS-Renov-61558432052856/',
        path: 'M14 8.5V6.6c0-.8.2-1.3 1.4-1.3H17V2.2C16.7 2.1 15.7 2 14.6 2 12.2 2 10.6 3.4 10.6 6.1v2.4H8v3.4h2.6V22H14V11.9h2.7l.4-3.4H14z',
    },
    {
        name: 'Instagram',
        href: 'https://www.instagram.com/svsrenov_be/',
        path: 'M12 7.3a4.7 4.7 0 100 9.4 4.7 4.7 0 000-9.4zm0 7.7a3 3 0 110-6 3 3 0 010 6zm6-7.9a1.1 1.1 0 11-2.2 0 1.1 1.1 0 012.2 0zM21.9 8.2c-.1-1.5-.4-2.9-1.5-4-1.1-1.1-2.5-1.4-4-1.5-1.6-.1-6.3-.1-7.9 0-1.5.1-2.9.4-4 1.5S3.1 6.7 3 8.2c-.1 1.6-.1 6.3 0 7.9.1 1.5.4 2.9 1.5 4 1.1 1.1 2.5 1.4 4 1.5 1.6.1 6.3.1 7.9 0 1.5-.1 2.9-.4 4-1.5 1.1-1.1 1.4-2.5 1.5-4 .1-1.6.1-6.3 0-7.9zm-2.1 9.6a3.2 3.2 0 01-1.8 1.8c-1.3.5-4.3.4-5.6.4s-4.4.1-5.6-.4a3.2 3.2 0 01-1.8-1.8c-.5-1.3-.4-4.3-.4-5.6s-.1-4.4.4-5.6a3.2 3.2 0 011.8-1.8c1.3-.5 4.3-.4 5.6-.4s4.4-.1 5.6.4a3.2 3.2 0 011.8 1.8c.5 1.3.4 4.3.4 5.6s.1 4.4-.4 5.6z',
    },
];

const links = computed(() => [
    { name: t('about'), href: route('about.index') },
    { name: t('services'), href: route('services.index') },
    { name: t('nav_realisations'), href: route('portfolio.index') },
    { name: t('gallery'), href: route('gallery.index') },
    { name: t('blog'), href: route('blog.index') },
    { name: t('contact'), href: route('contact.index') },
]);
</script>

<template>
    <footer class="border-t border-white/10 bg-black text-white">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
            <!-- CTA band -->
            <div class="mb-14 flex flex-col items-start justify-between gap-6 border-b border-white/10 pb-14 md:flex-row md:items-center">
                <h2 class="max-w-xl text-3xl font-extrabold leading-tight sm:text-4xl">
                    {{ t('hero_heading_1') }} <span class="text-primary">{{ t('hero_heading_2') }}</span>
                </h2>
                <div class="flex flex-wrap gap-3">
                    <Link
                        :href="route('contact.index')"
                        class="inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3.5 font-semibold transition-colors hover:bg-white hover:text-secondary"
                    >
                        {{ t('nav_quote_cta') }}
                    </Link>
                    <a
                        href="tel:+32472640679"
                        class="inline-flex items-center gap-2 rounded-full border border-white/20 px-6 py-3.5 font-semibold transition-colors hover:border-white"
                    >
                        0472 64 06 79
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Brand -->
                <div class="space-y-4">
                    <Link :href="route('home')" class="inline-block">
                        <img src="/image/logo.png" alt="SVS RENOV" class="h-16 w-16" loading="lazy">
                    </Link>
                    <p class="max-w-xs text-sm leading-relaxed text-gray-400">{{ t('footer_tagline') }}</p>
                    <div class="flex gap-3">
                        <a
                            v-for="social in socialLinks"
                            :key="social.name"
                            :href="social.href"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-gray-300 transition-colors hover:bg-primary hover:text-white"
                            :aria-label="social.name"
                        >
                            <svg class="h-[18px] w-[18px]" fill="currentColor" viewBox="0 0 24 24"><path :d="social.path" /></svg>
                        </a>
                    </div>
                </div>

                <!-- Navigation -->
                <div>
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-gray-500">{{ t('footer_quick_links') }}</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li v-for="link in links" :key="link.href">
                            <Link :href="link.href" class="text-gray-300 transition-colors hover:text-white">{{ link.name }}</Link>
                        </li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-gray-500">{{ t('contact') }}</h3>
                    <ul class="space-y-2.5 text-sm text-gray-300">
                        <li><a href="tel:+32472640679" class="transition-colors hover:text-white">0472 64 06 79</a></li>
                        <li><a href="mailto:info@svsrenov.be" class="transition-colors hover:text-white">info@svsrenov.be</a></li>
                        <li>Vilvoordsesteenweg<br>1860 Meise</li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-gray-500">SVS RENOV</h3>
                    <ul class="space-y-2.5 text-sm text-gray-300">
                        <li>{{ t('footer_legal_vat') }} : BE1011.945.471</li>
                    </ul>
                </div>
            </div>

            <div class="mt-14 flex flex-col justify-between gap-3 border-t border-white/10 pt-8 text-sm text-gray-500 sm:flex-row">
                <p>&copy; {{ currentYear }} SVS RENOV. {{ t('footer_rights') }}</p>
            </div>
        </div>
    </footer>
</template>
