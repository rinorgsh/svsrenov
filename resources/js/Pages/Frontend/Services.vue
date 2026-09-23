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
        <section class="py-12 md:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-3 sm:gap-4 lg:grid-cols-3 lg:gap-x-8 lg:gap-y-12">
                    <Link
                        v-for="(service, index) in services"
                        :key="service.id"
                        :href="route('services.show', service.slug)"
                        class="group flex items-center gap-4 rounded-2xl bg-surface-3 p-3 ring-1 ring-line/10 transition-colors hover:bg-surface-2 lg:block lg:bg-transparent lg:p-0 lg:ring-0 lg:hover:bg-transparent"
                    >
                        <div class="relative aspect-square w-24 shrink-0 overflow-hidden rounded-xl bg-surface-2 sm:w-28 lg:mb-5 lg:aspect-[4/3] lg:w-auto lg:rounded-3xl">
                            <img
                                v-if="service.image"
                                :src="service.image"
                                :alt="service.title"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                                :loading="index < 4 ? 'eager' : 'lazy'"
                            >
                            <div v-else class="relative flex h-full w-full items-center justify-center overflow-hidden bg-secondary p-3 lg:items-end lg:p-6">
                                <span class="font-display text-3xl font-extrabold leading-none text-white/20 lg:absolute lg:-right-4 lg:-top-10 lg:text-[10rem] lg:text-white/5" aria-hidden="true">
                                    {{ String(index + 1).padStart(2, '0') }}
                                </span>
                                <span class="hidden h-1 w-12 rounded-full bg-primary lg:block"></span>
                            </div>
                            <span v-if="service.image" class="absolute left-4 top-4 hidden h-9 min-w-[2.25rem] items-center justify-center rounded-full bg-white/90 px-2 text-sm font-bold text-secondary backdrop-blur lg:flex">
                                {{ String(index + 1).padStart(2, '0') }}
                            </span>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h2 class="text-lg font-extrabold leading-snug text-fg transition-colors group-hover:text-accent lg:mb-2 lg:text-2xl">
                                {{ service.title }}
                            </h2>
                            <p class="mt-1 line-clamp-2 text-sm text-fg-muted lg:mt-0 lg:line-clamp-3 lg:text-base">{{ service.description }}</p>
                            <span class="mt-4 hidden items-center gap-2 text-sm font-semibold text-accent transition-all group-hover:gap-3 lg:inline-flex">
                                {{ t('services_discover') }}
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </span>
                        </div>

                        <svg class="h-5 w-5 shrink-0 text-fg-soft lg:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Méthode -->
        <section class="theme-light bg-surface-2 py-12 md:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-8 max-w-2xl md:mb-12">
                    <span class="mb-3 block text-sm font-bold uppercase tracking-[0.2em] text-accent">{{ t('services_process_eyebrow') }}</span>
                    <h2 class="text-[1.7rem] font-extrabold leading-tight text-fg sm:text-4xl md:text-5xl">{{ t('services_process_title') }}</h2>
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
