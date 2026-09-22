<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import Header from '@/Components/Frontend/Header.vue';
import Footer from '@/Components/Frontend/Footer.vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();
const page = usePage();

const props = defineProps({
    title: String,
    description: String,
});

// Balises SEO calculées côté serveur (App\Support\Seo) ; les props servent de repli
const seo = computed(() => page.props.seo || {});
const pageTitle = computed(() => seo.value.title || props.title || '');
const fullTitle = computed(() => (pageTitle.value ? `${pageTitle.value} - SVS RENOV` : 'SVS RENOV'));
const pageDescription = computed(() => seo.value.description || props.description);
</script>

<template>
    <div class="theme-dark flex min-h-screen flex-col overflow-x-hidden bg-surface pb-[72px] lg:pb-0">
        <Head :title="pageTitle">
            <meta v-if="pageDescription" head-key="description" name="description" :content="pageDescription">
            <meta v-if="seo.noindex" head-key="robots" name="robots" content="noindex, nofollow">
            <link v-if="!seo.noindex && seo.canonical" head-key="canonical" rel="canonical" :href="seo.canonical">
            <template v-if="!seo.noindex && seo.alternates">
                <link
                    v-for="(href, lang) in seo.alternates"
                    :key="lang"
                    :head-key="`alternate-${lang}`"
                    rel="alternate"
                    :hreflang="`${lang}-BE`"
                    :href="href"
                >
                <link head-key="alternate-default" rel="alternate" hreflang="x-default" :href="seo.alternates.fr">
            </template>
            <meta head-key="og:site_name" property="og:site_name" content="SVS RENOV">
            <meta head-key="og:type" property="og:type" :content="seo.type || 'website'">
            <meta head-key="og:title" property="og:title" :content="fullTitle">
            <meta v-if="pageDescription" head-key="og:description" property="og:description" :content="pageDescription">
            <meta v-if="seo.canonical" head-key="og:url" property="og:url" :content="seo.canonical">
            <meta v-if="seo.image" head-key="og:image" property="og:image" :content="seo.image">
            <meta head-key="og:locale" property="og:locale" :content="seo.locale || 'fr_BE'">
            <meta head-key="twitter:card" name="twitter:card" content="summary_large_image">
        </Head>

        <Header />

        <main class="w-full flex-grow overflow-x-hidden">
            <slot />
        </main>

        <Footer />

        <!-- Barre d'actions mobile (toujours visible) -->
        <div class="fixed inset-x-0 bottom-0 z-40 border-t border-white/10 bg-surface/95 px-4 pt-3 backdrop-blur-lg lg:hidden" style="padding-bottom: max(0.75rem, env(safe-area-inset-bottom))">
            <div class="mx-auto grid max-w-md grid-cols-2 gap-3">
                <a
                    href="tel:+32472640679"
                    class="flex items-center justify-center gap-2 rounded-full border border-white/20 py-3 text-sm font-semibold text-white"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    {{ t('nav_call') }}
                </a>
                <Link
                    :href="route('contact.index')"
                    class="flex items-center justify-center rounded-full bg-primary py-3 text-sm font-semibold text-white"
                >
                    {{ t('nav_quote_cta') }}
                </Link>
            </div>
        </div>
    </div>
</template>
