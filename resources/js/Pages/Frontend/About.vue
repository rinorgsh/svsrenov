<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import PageHero from '@/Components/Frontend/PageHero.vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();

defineProps({
    hero: Object,
});

const values = computed(() => [
    {
        key: 'quality',
        icon: 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
    },
    {
        key: 'experience',
        icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
    },
    {
        key: 'passion',
        icon: 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
    },
    {
        key: 'service',
        icon: 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z',
    },
].map((v) => ({ ...v, title: t(`about_value_${v.key}_title`), desc: t(`about_value_${v.key}_desc`) })));

const features = computed(() => ['expertise', 'quality', 'availability'].map((key, i) => ({
    key,
    n: String(i + 1).padStart(2, '0'),
    title: t(`about_feature_${key}_title`),
    desc: t(`about_feature_${key}_desc`),
})));
</script>

<template>
    <FrontendLayout :title="t('about')">
        <PageHero
            :image="hero?.image_url"
            fallback="/image/camionette.jpeg"
            :eyebrow="t('about_hero_subtitle')"
            :title="t('about_hero_description')"
        />

        <!-- Histoire du fondateur -->
        <section class="theme-light bg-surface py-16 md:py-24">
            <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:gap-16 lg:px-8">
                <div>
                    <span class="mb-3 block text-sm font-bold uppercase tracking-[0.2em] text-accent">{{ t('about_story_subtitle') }}</span>
                    <h2 class="text-3xl font-extrabold leading-tight text-fg sm:text-4xl md:text-5xl">{{ t('about_story_title') }}</h2>
                    <blockquote class="mt-8 border-l-4 border-primary pl-6 text-lg leading-[1.8] text-fg-muted">
                        {{ t('about_story_intro') }}
                    </blockquote>
                    <div class="mt-8 flex items-center gap-4">
                        <img src="/image/logo.png" alt="SVS RENOV" class="h-14 w-14 rounded-full bg-surface-3 object-contain p-1 ring-1 ring-line/10">
                        <div>
                            <p class="font-bold text-fg">SVS RENOV</p>
                            <p class="text-sm text-fg-soft">{{ t('about_founder_label') }} · Meise</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <img
                        src="/image/chantier.jpeg"
                        :alt="t('about_story_title')"
                        class="aspect-[4/5] w-full rounded-[2rem] object-cover shadow-2xl shadow-black/15"
                        loading="lazy"
                    >
                    <img
                        src="/image/camionette.jpeg"
                        alt="SVS RENOV"
                        class="absolute -bottom-8 -left-4 hidden aspect-[4/3] w-1/2 rounded-3xl object-cover shadow-xl ring-8 ring-white sm:block lg:-left-10"
                        loading="lazy"
                    >
                </div>
            </div>
        </section>

        <!-- Valeurs -->
        <section class="border-t border-line/10 bg-surface py-16 md:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-12 max-w-2xl">
                    <span class="mb-3 block text-sm font-bold uppercase tracking-[0.2em] text-accent">{{ t('about_values_eyebrow') }}</span>
                    <h2 class="text-3xl font-extrabold text-fg sm:text-4xl md:text-5xl">{{ t('about_values_title') }}</h2>
                </div>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div v-for="value in values" :key="value.key" class="rounded-3xl bg-surface-3 p-7 ring-1 ring-line/10">
                        <span class="mb-6 flex h-12 w-12 items-center justify-center rounded-2xl bg-primary/10 text-accent">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" :d="value.icon" />
                            </svg>
                        </span>
                        <h3 class="mb-2 text-xl font-bold text-fg">{{ value.title }}</h3>
                        <p class="text-fg-muted">{{ value.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pourquoi nous -->
        <section class="theme-light bg-surface py-16 md:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-12 max-w-2xl">
                    <span class="mb-3 block text-sm font-bold uppercase tracking-[0.2em] text-accent">{{ t('about_why_subtitle') }}</span>
                    <h2 class="text-3xl font-extrabold text-fg sm:text-4xl md:text-5xl">{{ t('about_why_title') }}</h2>
                </div>
                <div class="grid gap-10 md:grid-cols-3">
                    <div v-for="feature in features" :key="feature.key" class="border-t-2 border-secondary pt-6">
                        <span class="font-display text-sm font-extrabold text-accent">{{ feature.n }}</span>
                        <h3 class="mb-3 mt-2 text-2xl font-extrabold text-fg">{{ feature.title }}</h3>
                        <p class="leading-relaxed text-fg-muted">{{ feature.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="px-4 pb-16 sm:px-6 lg:px-8">
            <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-6 rounded-[2rem] bg-gradient-to-br from-primary to-[#7a130f] p-8 text-white shadow-2xl shadow-primary/20 md:flex-row md:items-center md:p-12">
                <div>
                    <h2 class="text-2xl font-extrabold md:text-3xl">{{ t('about_cta_title') }}</h2>
                    <p class="mt-2 max-w-xl text-white/80">{{ t('about_cta_description') }}</p>
                </div>
                <div class="flex shrink-0 flex-wrap gap-3">
                    <Link :href="route('contact.index')" class="rounded-full bg-white text-secondary px-7 py-4 font-semibold transition-colors hover:bg-secondary hover:text-white">
                        {{ t('nav_quote_cta') }}
                    </Link>
                    <Link :href="route('portfolio.index')" class="rounded-full border border-white/20 px-7 py-4 font-semibold transition-colors hover:border-white">
                        {{ t('nav_realisations') }}
                    </Link>
                </div>
            </div>
        </section>
    </FrontendLayout>
</template>
