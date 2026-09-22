<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import PageHero from '@/Components/Frontend/PageHero.vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();

defineProps({
    services: { type: Array, default: () => [] },
    hero: Object,
});

const steps = computed(() => [1, 2, 3, 4].map((n) => ({
    n,
    title: t(`services_step${n}_title`),
    desc: t(`services_step${n}_desc`),
})));
</script>

<template>
    <FrontendLayout :title="t('services')">
        <PageHero
            :image="hero?.image_url"
            fallback="/image/hero.webp"
            :eyebrow="t('services_our_expertises')"
            :title="t('services_specialized_title')"
            :lead="t('services_page_lead')"
        >
            <Link
                :href="route('contact.index')"
                class="inline-flex items-center justify-center rounded-full bg-primary px-7 py-4 font-semibold text-white transition-colors hover:bg-white hover:text-secondary"
            >
                {{ t('nav_quote_cta') }}
            </Link>
            <a
                href="tel:+32472640679"
                class="inline-flex items-center justify-center rounded-full border border-white/30 px-7 py-4 font-semibold text-white transition-colors hover:border-white"
            >
                0472 64 06 79
            </a>
        </PageHero>

        <!-- Liste des services -->
        <section class="py-16 md:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="(service, index) in services"
                        :key="service.id"
                        :href="route('services.show', service.slug)"
                        class="group flex flex-col"
                    >
                        <div class="relative mb-5 aspect-[4/3] overflow-hidden rounded-3xl bg-surface-2">
                            <img
                                v-if="service.image"
                                :src="service.image"
                                :alt="service.title"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                                :loading="index < 3 ? 'eager' : 'lazy'"
                            >
                            <div v-else class="relative flex h-full w-full items-end overflow-hidden bg-secondary p-6">
                                <span class="absolute -right-4 -top-10 font-display text-[10rem] font-extrabold leading-none text-white/5" aria-hidden="true">
                                    {{ String(index + 1).padStart(2, '0') }}
                                </span>
                                <span class="h-1 w-12 rounded-full bg-primary"></span>
                            </div>
                            <span v-if="service.image" class="absolute left-4 top-4 flex h-9 min-w-[2.25rem] items-center justify-center rounded-full bg-white/90 px-2 text-sm font-bold text-fg backdrop-blur">
                                {{ String(index + 1).padStart(2, '0') }}
                            </span>
                        </div>
                        <h2 class="mb-2 text-2xl font-extrabold text-fg transition-colors group-hover:text-accent">
                            {{ service.title }}
                        </h2>
                        <p class="line-clamp-3 text-fg-muted">{{ service.description }}</p>
                        <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-accent transition-all group-hover:gap-3">
                            {{ t('services_discover') }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </span>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Méthode -->
        <section class="theme-light bg-surface-2 py-16 md:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-12 max-w-2xl">
                    <span class="mb-3 block text-sm font-bold uppercase tracking-[0.2em] text-accent">{{ t('services_process_eyebrow') }}</span>
                    <h2 class="text-3xl font-extrabold text-fg sm:text-4xl md:text-5xl">{{ t('services_process_title') }}</h2>
                </div>
                <ol class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <li v-for="step in steps" :key="step.n" class="rounded-3xl bg-surface-3 p-7 ring-1 ring-line/10">
                        <span class="mb-6 flex h-12 w-12 items-center justify-center rounded-full bg-primary font-display text-lg font-extrabold text-white">
                            {{ step.n }}
                        </span>
                        <h3 class="mb-2 text-xl font-bold text-fg">{{ step.title }}</h3>
                        <p class="text-fg-muted">{{ step.desc }}</p>
                    </li>
                </ol>
            </div>
        </section>

        <!-- CTA -->
        <section class="px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-6 rounded-[2rem] bg-gradient-to-br from-primary to-[#7a130f] p-8 text-white shadow-2xl shadow-primary/20 md:flex-row md:items-center md:p-12">
                <div>
                    <h2 class="text-2xl font-extrabold md:text-3xl">{{ t('services_cta_project_title') }} {{ t('services_cta_project_subtitle') }}</h2>
                    <p class="mt-2 max-w-xl text-white/80">{{ t('services_cta_team_desc') }}</p>
                </div>
                <Link :href="route('contact.index')" class="shrink-0 rounded-full bg-white text-secondary px-7 py-4 font-semibold transition-colors hover:bg-secondary hover:text-white">
                    {{ t('nav_quote_cta') }}
                </Link>
            </div>
        </section>
    </FrontendLayout>
</template>
