<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, computed, onUnmounted } from 'vue';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import GoogleReviewsCarousel from '@/Components/Frontend/GoogleReviewsCarousel.vue';
import BeforeAfterSlider from '@/Components/Frontend/BeforeAfterSlider.vue';
import PostCard from '@/Components/Frontend/PostCard.vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();

const props = defineProps({
    services: { type: Array, default: () => [] },
    featuredProjects: { type: Array, default: () => [] },
    testimonials: Array,
    hero: Object,
    googleReviews: { type: Array, default: () => [] },
    googleReviewStats: Object,
    heroProjects: { type: Array, default: () => [] },
    latestPosts: { type: Array, default: () => [] },
    googleReviewsUrl: String,
});

// Diaporama avant/après du hero : change tout seul toutes les HERO_INTERVAL ms,
// se met en pause au survol et quelques secondes après une manipulation
const HERO_INTERVAL = 6000;
const HERO_RESUME_DELAY = 8000;
const heroIndex = ref(0);
const heroCycle = ref(0); // relance la barre de progression
const heroHovered = ref(false);
const heroInteracting = ref(false);
let heroResumeTimer = null;

const currentHeroProject = computed(() => props.heroProjects[heroIndex.value] ?? props.heroProjects[0]);
const heroPaused = computed(() => heroHovered.value || heroInteracting.value);

const goToHero = (i) => {
    heroIndex.value = (i + props.heroProjects.length) % props.heroProjects.length;
    heroCycle.value++;
};
const nextHero = () => goToHero(heroIndex.value + 1);

const onHeroInteract = () => {
    heroInteracting.value = true;
    clearTimeout(heroResumeTimer);
    heroResumeTimer = setTimeout(() => {
        heroInteracting.value = false;
    }, HERO_RESUME_DELAY);
};

onUnmounted(() => clearTimeout(heroResumeTimer));

const formattedRating = computed(() =>
    (props.googleReviewStats?.average_rating ?? 0).toFixed(1).replace('.', ',')
);

// Services mis en avant : ceux qui ont une photo ; 5 = 2 rangées pleines (le premier prend 2 colonnes)
const featuredServices = computed(() => props.services.filter((s) => s.image).slice(0, 5));

// Réalisations : projets vedettes avec avant ET après, hors ceux déjà dans le hero
const showcaseProjects = computed(() => {
    const inHero = new Set(props.heroProjects.map((p) => p.id));
    const withPhotos = props.featuredProjects.filter((p) => p.image_before && p.image_after);
    const others = withPhotos.filter((p) => !inHero.has(p.id));
    return (others.length >= 2 ? others : withPhotos).slice(0, 2);
});

const strengths = computed(() => ['experience', 'quality', 'work', 'materials', 'tech'].map((key) => ({
    key,
    title: t(`home_professionals_${key}_title`),
    desc: t(`home_professionals_${key}_desc`),
})));

const STRENGTH_ICONS = {
    experience: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
    quality: 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
    work: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
    materials: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
    tech: 'M13 10V3L4 14h7v7l9-11h-7z',
};
</script>

<template>
    <FrontendLayout>
            <!-- HERO : texte à gauche, avant/après interactif à droite -->
            <section class="relative overflow-hidden bg-surface pt-[72px]">

                <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 pb-16 pt-10 sm:px-6 md:pt-16 lg:grid-cols-12 lg:gap-10 lg:px-8 lg:pb-24 lg:pt-20">
                    <!-- Texte -->
                    <div class="lg:col-span-6">
                        <div class="animate-fade-in-up inline-flex flex-wrap items-center gap-x-3 gap-y-1 rounded-full bg-surface-3 px-4 py-2 text-sm shadow-sm ring-1 ring-line/10">
                            <template v-if="googleReviewStats?.total_count">
                                <span class="flex items-center gap-1 font-bold text-fg">
                                    <svg class="h-4 w-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    {{ formattedRating }}
                                </span>
                                <span class="text-fg-soft">Google</span>
                                <span class="hidden h-1 w-1 rounded-full bg-fg/20 sm:block"></span>
                            </template>
                            <span class="text-fg-muted">{{ t('hero_badge_zone') }}</span>
                        </div>

                        <h1 class="animate-fade-in-up mt-6 text-[2.75rem] font-extrabold leading-[0.95] text-fg sm:text-6xl xl:text-[4.75rem]">
                            {{ t('hero_heading_1') }}<br>
                            <span class="relative inline-block text-accent">
                                {{ t('hero_heading_2') }}
                                <svg class="absolute -bottom-2 left-0 h-3 w-full text-accent/40" viewBox="0 0 200 12" preserveAspectRatio="none" aria-hidden="true">
                                    <path d="M2 9c40-6 110-8 196-3" fill="none" stroke="currentColor" stroke-width="5" stroke-linecap="round" />
                                </svg>
                            </span>
                        </h1>

                        <p class="animate-fade-in-up animation-delay-200 mt-8 max-w-xl text-lg leading-relaxed text-fg-muted">
                            {{ t('hero_lead') }}
                        </p>

                        <div class="animate-fade-in-up animation-delay-200 mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                            <Link
                                :href="route('contact.index')"
                                class="group inline-flex items-center justify-center gap-2 rounded-full bg-primary px-7 py-4 text-base font-semibold text-white shadow-lg shadow-primary/25 transition-all hover:-translate-y-0.5 hover:bg-white hover:text-secondary"
                            >
                                {{ t('home_hero_btn_quote') }}
                                <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </Link>
                            <a
                                href="tel:+32472640679"
                                class="inline-flex items-center justify-center gap-3 rounded-full px-5 py-4 font-semibold text-fg transition-colors hover:text-accent"
                            >
                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-surface-3 shadow-sm ring-1 ring-line/10">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </span>
                                0472 64 06 79
                            </a>
                        </div>

                        <!-- Chiffres clés -->
                        <dl class="mt-12 grid max-w-lg grid-cols-3 divide-x divide-line/10 border-t border-line/10 pt-6">
                            <div class="pr-4">
                                <dt class="sr-only">{{ t('hero_stat_years') }}</dt>
                                <dd class="font-display text-2xl font-extrabold text-fg sm:text-3xl">15+</dd>
                                <dd class="mt-1 text-xs leading-snug text-fg-soft sm:text-sm">{{ t('hero_stat_years') }}</dd>
                            </div>
                            <div v-if="googleReviewStats?.total_count" class="px-4">
                                <dt class="sr-only">{{ t('hero_stat_rating') }}</dt>
                                <dd class="font-display text-2xl font-extrabold text-fg sm:text-3xl">{{ formattedRating }}<span class="text-amber-400">★</span></dd>
                                <dd class="mt-1 text-xs leading-snug text-fg-soft sm:text-sm">{{ t('hero_stat_rating') }}</dd>
                            </div>
                            <div class="pl-4">
                                <dt class="sr-only">{{ t('hero_stat_quote') }}</dt>
                                <dd class="font-display text-2xl font-extrabold text-fg sm:text-3xl">{{ t('hero_stat_quote_value') }}</dd>
                                <dd class="mt-1 text-xs leading-snug text-fg-soft sm:text-sm">{{ t('hero_stat_quote') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Visuel -->
                    <div class="relative lg:col-span-6">
                        <div class="animate-fade-in-up animation-delay-200 relative">
                            <div
                                v-if="heroProjects.length"
                                class="relative isolate aspect-[4/5] w-full overflow-hidden rounded-[2rem] bg-surface-3 shadow-2xl shadow-black/40 sm:aspect-[5/4] lg:aspect-[4/5] xl:aspect-square"
                                @mouseenter="heroHovered = true"
                                @mouseleave="heroHovered = false"
                            >
                                <!-- Diapos empilées, fondu entre elles -->
                                <BeforeAfterSlider
                                    v-for="(project, i) in heroProjects"
                                    :key="project.id"
                                    :before="project.image_before"
                                    :after="project.image_after"
                                    :before-label="t('before')"
                                    :after-label="t('after')"
                                    :alt="project.title"
                                    :active="i === heroIndex"
                                    :eager="i <= 1"
                                    hint
                                    class="!absolute inset-0 transition-opacity duration-700 ease-out"
                                    :class="i === heroIndex ? 'z-10 opacity-100' : 'pointer-events-none z-0 opacity-0'"
                                    :aria-hidden="i !== heroIndex"
                                    @interact="onHeroInteract"
                                />

                                <!-- Légende + progression -->
                                <div class="pointer-events-none absolute inset-x-0 bottom-0 z-20 bg-gradient-to-t from-black/70 to-transparent p-6 pt-20 text-right">
                                    <div :key="currentHeroProject.id" class="hero-caption">
                                        <p class="text-sm font-semibold text-white">{{ currentHeroProject.title }}</p>
                                        <p class="text-xs text-white/70">{{ currentHeroProject.location }} · {{ t('hero_drag_hint') }}</p>
                                    </div>

                                    <div v-if="heroProjects.length > 1" class="pointer-events-auto mt-4 flex justify-end gap-1.5">
                                        <button
                                            v-for="(project, i) in heroProjects"
                                            :key="project.id"
                                            type="button"
                                            class="relative h-1.5 overflow-hidden rounded-full bg-white/35 transition-all duration-300"
                                            :class="i === heroIndex ? 'w-10' : 'w-4 hover:bg-white/60'"
                                            :aria-label="project.title"
                                            :aria-current="i === heroIndex"
                                            @click="goToHero(i)"
                                        >
                                            <span
                                                v-if="i === heroIndex"
                                                :key="`progress-${heroCycle}`"
                                                class="hero-progress absolute inset-y-0 left-0 rounded-full bg-white"
                                                :style="{ animationDuration: `${HERO_INTERVAL}ms`, animationPlayState: heroPaused ? 'paused' : 'running' }"
                                                @animationend="nextHero"
                                            ></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <img
                                v-else
                                :src="hero?.image_url || '/image/hero.webp'"
                                alt="SVS RENOV - Façade"
                                class="aspect-[4/5] w-full rounded-[2rem] object-cover shadow-2xl shadow-black/20 sm:aspect-[5/4] lg:aspect-[4/5] xl:aspect-[5/4]"
                            >

                            <!-- Carte avis flottante -->
                            <div
                                v-if="googleReviews?.length"
                                class="absolute -bottom-6 -left-2 z-30 hidden max-w-[260px] rounded-2xl bg-surface-3 p-4 shadow-xl ring-1 ring-line/10 sm:block lg:-left-10"
                            >
                                <div class="mb-1 flex text-amber-400">
                                    <svg v-for="i in 5" :key="i" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                                <p class="line-clamp-2 text-sm leading-snug text-fg-muted">“{{ googleReviews[0].comment }}”</p>
                                <p class="mt-2 text-xs font-semibold text-fg">{{ googleReviews[0].author_name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SERVICES : grande grille photo -->
            <section v-if="featuredServices.length" class="bg-surface-2 py-20 md:py-28">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12 flex flex-col justify-between gap-6 md:flex-row md:items-end">
                        <div class="max-w-2xl">
                            <span class="mb-3 block text-sm font-bold uppercase tracking-[0.2em] text-accent">{{ t('services') }}</span>
                            <h2 class="text-3xl font-extrabold text-fg sm:text-4xl md:text-5xl">{{ t('home_services_title') }}</h2>
                            <p class="mt-4 text-lg text-fg-muted">{{ t('home_services_subtitle') }}</p>
                        </div>
                        <Link :href="route('services.index')" class="inline-flex shrink-0 items-center gap-2 font-semibold text-fg transition-all hover:gap-3 hover:text-accent">
                            {{ t('services_title') }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </Link>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <Link
                            v-for="(service, index) in featuredServices"
                            :key="service.id"
                            :href="route('services.show', service.slug)"
                            class="group relative isolate flex aspect-[4/5] flex-col justify-end overflow-hidden rounded-3xl bg-surface-3 p-7 sm:aspect-[4/5]"
                            :class="{ 'lg:col-span-2 lg:aspect-auto': index === 0 }"
                        >
                            <img
                                :src="service.image"
                                :alt="service.title"
                                class="absolute inset-0 -z-10 h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 -z-10 bg-gradient-to-t from-black via-black/40 to-black/0"></div>
                            <span class="absolute left-6 top-6 font-display text-sm font-bold text-white/70">{{ String(index + 1).padStart(2, '0') }}</span>
                            <h3 class="text-2xl font-extrabold text-white md:text-3xl">{{ service.title }}</h3>
                            <p class="mt-2 line-clamp-2 max-w-md text-white/75">{{ service.description }}</p>
                            <span class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-white transition-all group-hover:gap-3">
                                {{ t('home_discover_service') }}
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </span>
                        </Link>
                    </div>
                </div>
            </section>

            <!-- RÉALISATIONS : avant / après -->
            <section v-if="showcaseProjects.length" class="bg-surface py-20 md:py-28">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12 flex flex-col justify-between gap-6 md:flex-row md:items-end">
                        <div class="max-w-2xl">
                            <span class="mb-3 block text-sm font-bold uppercase tracking-[0.2em] text-accent">{{ t('before') }} / {{ t('after') }}</span>
                            <h2 class="text-3xl font-extrabold text-fg sm:text-4xl md:text-5xl">{{ t('home_portfolio_title') }}</h2>
                            <p class="mt-4 text-lg text-fg-muted">{{ t('home_portfolio_subtitle') }}</p>
                        </div>
                        <Link :href="route('portfolio.index')" class="inline-flex shrink-0 items-center gap-2 rounded-full bg-primary px-6 py-3.5 font-semibold text-white transition-colors hover:bg-white hover:text-secondary">
                            {{ t('home_view_all_projects') }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </Link>
                    </div>

                    <div class="grid gap-8 md:grid-cols-2">
                        <figure v-for="project in showcaseProjects" :key="project.id">
                            <BeforeAfterSlider
                                :before="project.image_before"
                                :after="project.image_after"
                                :before-label="t('before')"
                                :after-label="t('after')"
                                :alt="project.title"
                                class="aspect-[4/3] w-full rounded-3xl"
                            />
                            <figcaption class="mt-4 flex items-baseline justify-between gap-4">
                                <span class="font-bold text-fg">{{ project.title }}</span>
                                <span v-if="project.location" class="shrink-0 text-sm text-fg-soft">{{ project.location }}</span>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </section>

            <!-- POURQUOI NOUS (section claire, lecture) -->
            <section class="theme-light bg-surface py-20 md:py-28">
                <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:gap-16 lg:px-8">
                    <div>
                        <span class="mb-3 block text-sm font-bold uppercase tracking-[0.2em] text-accent">SVS RENOV</span>
                        <h2 class="text-3xl font-extrabold leading-tight text-fg sm:text-4xl md:text-5xl">
                            {{ t('home_about_title_1') }} <span class="text-accent">{{ t('home_about_title_2') }}</span>
                        </h2>
                        <p class="mt-6 text-lg leading-relaxed text-fg-muted [&_strong]:text-fg" v-html="t('home_about_desc_1')"></p>
                        <p class="mt-4 text-lg leading-relaxed text-fg-muted">{{ t('home_about_desc_2') }}</p>
                        <Link :href="route('about.index')" class="mt-8 inline-flex items-center gap-2 font-semibold text-fg transition-all hover:gap-3 hover:text-accent">
                            {{ t('about') }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </Link>
                    </div>
                    <div class="relative">
                        <img src="/image/camionette.jpeg" :alt="t('home_about_title_1')" class="aspect-[4/3] w-full rounded-[2rem] object-cover shadow-2xl shadow-black/15" loading="lazy">
                        <div class="absolute -bottom-6 right-6 rounded-2xl bg-secondary px-6 py-4 text-white shadow-xl">
                            <p class="font-display text-3xl font-extrabold">15+</p>
                            <p class="text-sm text-white/70">{{ t('hero_stat_years') }}</p>
                        </div>
                    </div>
                </div>

                <div class="mx-auto mt-20 max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h3 class="mb-8 text-2xl font-extrabold text-fg md:text-3xl">
                        {{ t('home_professionals_title_1') }} <span class="text-accent">{{ t('home_professionals_title_2') }}</span>
                    </h3>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                        <div v-for="item in strengths" :key="item.key" class="rounded-3xl bg-surface-2 p-6 ring-1 ring-line/10">
                            <span class="mb-5 flex h-11 w-11 items-center justify-center rounded-2xl bg-primary text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" :d="STRENGTH_ICONS[item.key]" /></svg>
                            </span>
                            <h4 class="mb-2 font-bold text-fg">{{ item.title }}</h4>
                            <p class="text-sm leading-relaxed text-fg-muted">{{ item.desc }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- AVIS GOOGLE -->
            <GoogleReviewsCarousel :reviews="googleReviews" :stats="googleReviewStats" :profile-url="googleReviewsUrl" />

            <!-- DERNIERS ARTICLES DU BLOG -->
            <section v-if="latestPosts.length" class="bg-surface py-20 md:py-28">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-10 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                        <div>
                            <span class="mb-3 block text-sm font-bold uppercase tracking-[0.2em] text-accent">{{ t('blog_eyebrow') }}</span>
                            <h2 class="text-3xl font-extrabold text-fg sm:text-4xl md:text-5xl">{{ t('home_blog_title') }}</h2>
                        </div>
                        <Link :href="route('blog.index')" class="inline-flex items-center gap-2 font-semibold text-fg transition-all hover:gap-3 hover:text-accent">
                            {{ t('home_blog_link') }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </Link>
                    </div>
                    <div class="grid gap-8 md:grid-cols-3">
                        <PostCard v-for="post in latestPosts" :key="post.id" :post="post" />
                    </div>
                </div>
            </section>

            <!-- CTA FINAL -->
            <section class="bg-surface px-4 pb-20 sm:px-6 lg:px-8">
                <div class="relative isolate mx-auto max-w-7xl overflow-hidden rounded-[2rem] bg-gradient-to-br from-primary to-[#7a130f] p-8 text-white shadow-2xl shadow-primary/20 md:p-14">
                    <div class="grid items-center gap-10 lg:grid-cols-2">
                        <div>
                            <h2 class="text-3xl font-extrabold leading-tight md:text-5xl">{{ t('home_cta_title_1') }} {{ t('home_cta_title_2') }} ?</h2>
                            <p class="mt-5 max-w-xl text-lg text-white/80">{{ t('home_cta_desc_2') }}</p>
                        </div>
                        <div class="flex flex-col gap-3 sm:flex-row lg:justify-end">
                            <Link :href="route('contact.index')" class="inline-flex items-center justify-center rounded-full bg-white px-8 py-4 font-semibold text-secondary transition-colors hover:bg-secondary hover:text-white">
                                {{ t('nav_quote_cta') }}
                            </Link>
                            <a href="tel:+32472640679" class="inline-flex items-center justify-center rounded-full border border-white/40 px-8 py-4 font-semibold transition-colors hover:border-white">
                                0472 64 06 79
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </FrontendLayout>
</template>

<style scoped>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in-up {
    animation: fadeInUp 0.9s ease-out both;
}

.animation-delay-200 {
    animation-delay: 0.2s;
}

.hero-caption {
    animation: heroCaption 0.5s ease-out both;
}

@keyframes heroCaption {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: none; }
}

.hero-progress {
    width: 0;
    animation-name: heroProgress;
    animation-timing-function: linear;
    animation-fill-mode: forwards;
}

@keyframes heroProgress {
    from { width: 0; }
    to { width: 100%; }
}

@media (prefers-reduced-motion: reduce) {
    .animate-fade-in-up,
    .hero-caption {
        animation: none;
    }
    .hero-progress {
        animation: none;
        width: 100%;
    }
}
</style>
