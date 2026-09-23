<script setup>
import { ref, computed, watch, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import PageHero from '@/Components/Frontend/PageHero.vue';
import BeforeAfterSlider from '@/Components/Frontend/BeforeAfterSlider.vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();

const props = defineProps({
    projects: { type: Array, default: () => [] },
    hero: Object,
});

// Filtre par service
const activeService = ref(null);

const serviceFilters = computed(() => {
    const titles = props.projects.map((p) => p.service?.title).filter(Boolean);
    return [...new Set(titles)];
});

const visibleProjects = computed(() =>
    activeService.value
        ? props.projects.filter((p) => p.service?.title === activeService.value)
        : props.projects
);

// Galerie d'un chantier (photos supplémentaires) : fenêtre + navigation
const openProject = ref(null);
const photoIndex = ref(0);

const photos = computed(() => {
    const project = openProject.value;
    if (!project) return [];
    const list = [];
    if (project.image_before) list.push({ path: project.image_before, caption: t('before') });
    if (project.image_after) list.push({ path: project.image_after, caption: t('after') });
    (project.additional_images || []).forEach((img) => list.push({ path: img.path, caption: img.caption }));
    return list;
});

const expanded = ref({});
const toggleText = (id) => { expanded.value[id] = !expanded.value[id]; };

const openGallery = (project, index = 0) => {
    openProject.value = project;
    photoIndex.value = index;
};
const closeGallery = () => {
    openProject.value = null;
};
const next = () => {
    photoIndex.value = (photoIndex.value + 1) % photos.value.length;
};
const prev = () => {
    photoIndex.value = (photoIndex.value - 1 + photos.value.length) % photos.value.length;
};

const onKey = (e) => {
    if (e.key === 'Escape') closeGallery();
    if (e.key === 'ArrowRight') next();
    if (e.key === 'ArrowLeft') prev();
};

watch(openProject, (value) => {
    document.body.style.overflow = value ? 'hidden' : '';
    if (value) window.addEventListener('keydown', onKey);
    else window.removeEventListener('keydown', onKey);
});

onUnmounted(() => {
    document.body.style.overflow = '';
    window.removeEventListener('keydown', onKey);
});

const photoCount = (project) =>
    (project.additional_images?.length || 0) + (project.image_before ? 1 : 0) + (project.image_after ? 1 : 0);
</script>

<template>
    <FrontendLayout :title="t('portfolio')">
        <PageHero
            :image="hero?.image_url"
            fallback="/image/blog-hero.jpg"
            :eyebrow="t('portfolio_our_achievements')"
            :title="t('seo_portfolio_title')"
            :lead="t('portfolio_page_lead')"
        />

        <section class="py-12 md:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Filtres -->
                <div v-if="serviceFilters.length > 1" class="hide-scrollbar -mx-4 mb-10 overflow-x-auto px-4 pb-2 sm:mx-0 sm:px-0">
                    <div class="flex w-max gap-2 sm:w-auto sm:flex-wrap">
                        <button
                            type="button"
                            class="whitespace-nowrap rounded-full px-5 py-2.5 text-sm font-semibold transition-colors"
                            :class="!activeService ? 'bg-primary text-white' : 'bg-surface-2 text-fg hover:bg-surface-3'"
                            :aria-pressed="!activeService"
                            @click="activeService = null"
                        >
                            {{ t('gallery_all') }}
                        </button>
                        <button
                            v-for="title in serviceFilters"
                            :key="title"
                            type="button"
                            class="whitespace-nowrap rounded-full px-5 py-2.5 text-sm font-semibold transition-colors"
                            :class="activeService === title ? 'bg-primary text-white' : 'bg-surface-2 text-fg hover:bg-surface-3'"
                            :aria-pressed="activeService === title"
                            @click="activeService = title"
                        >
                            {{ title }}
                        </button>
                    </div>
                </div>

                <p v-if="!visibleProjects.length" class="py-20 text-center text-fg-soft">{{ t('portfolio_empty') }}</p>

                <!-- Chantiers -->
                <div class="grid gap-x-8 gap-y-10 md:grid-cols-2 md:gap-y-14">
                    <article v-for="(project, index) in visibleProjects" :key="project.id" class="flex flex-col">
                        <BeforeAfterSlider
                            v-if="project.image_before && project.image_after"
                            :before="project.image_before"
                            :after="project.image_after"
                            :before-label="t('before')"
                            :after-label="t('after')"
                            :alt="project.title"
                            :eager="index < 2"
                            class="aspect-[4/3] w-full rounded-3xl"
                        />
                        <button
                            v-else-if="project.image_before || project.image_after"
                            type="button"
                            class="aspect-[4/3] w-full overflow-hidden rounded-3xl bg-surface-2"
                            :aria-label="project.title"
                            @click="openGallery(project)"
                        >
                            <img
                                :src="project.image_after || project.image_before"
                                :alt="project.title"
                                class="h-full w-full object-cover"
                                loading="lazy"
                            >
                        </button>
                        <div v-else class="flex aspect-[4/3] w-full items-center justify-center rounded-3xl bg-secondary">
                            <img src="/image/logo.png" alt="" class="h-16 w-16 opacity-40">
                        </div>

                        <div class="mt-5 flex flex-wrap items-center gap-2 text-sm">
                            <span v-if="project.service" class="rounded-full bg-primary/10 px-3 py-1 font-semibold text-accent">
                                {{ project.service.title }}
                            </span>
                            <span v-if="project.location" class="flex items-center gap-1 text-fg-soft">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                {{ project.location }}
                            </span>
                        </div>
                        <h2 class="mt-3 text-2xl font-extrabold text-fg">{{ project.title }}</h2>
                        <p
                            v-if="project.description"
                            class="mt-2 whitespace-pre-line text-fg-muted"
                            :class="{ 'line-clamp-3': !expanded[project.id] }"
                        >{{ project.description }}</p>
                        <button
                            v-if="project.description && project.description.length > 150"
                            type="button"
                            class="mt-1 self-start text-sm font-semibold text-accent"
                            @click="toggleText(project.id)"
                        >
                            {{ expanded[project.id] ? t('read_less') : t('read_more') }}
                        </button>

                        <button
                            v-if="project.additional_images?.length"
                            type="button"
                            class="mt-4 inline-flex items-center gap-2 self-start rounded-full bg-surface-2 px-5 py-2.5 text-sm font-semibold text-fg transition-colors hover:bg-secondary hover:text-white"
                            @click="openGallery(project, project.image_before && project.image_after ? 2 : 0)"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            {{ t('portfolio_view_photos') }} · {{ photoCount(project) }} {{ t('portfolio_photos') }}
                        </button>
                    </article>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="px-4 pb-16 sm:px-6 lg:px-8">
            <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-6 rounded-[2rem] bg-gradient-to-br from-primary to-[#7a130f] p-8 text-white shadow-2xl shadow-primary/20 md:flex-row md:items-center md:p-12">
                <div>
                    <h2 class="text-2xl font-extrabold md:text-3xl">{{ t('portfolio_similar_project') }}</h2>
                    <p class="mt-2 text-white/80">{{ t('service_detail_cta_text') }}</p>
                </div>
                <Link :href="route('contact.index')" class="shrink-0 rounded-full bg-white text-secondary px-7 py-4 font-semibold transition-colors hover:bg-secondary hover:text-white">
                    {{ t('nav_quote_cta') }}
                </Link>
            </div>
        </section>

        <!-- Visionneuse photos du chantier -->
        <Teleport to="body">
            <transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0"
                leave-active-class="transition duration-150 ease-in"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="openProject && photos.length"
                    class="fixed inset-0 z-[70] flex flex-col bg-black"
                    role="dialog"
                    aria-modal="true"
                    :aria-label="openProject.title"
                >
                    <div class="flex items-center justify-between gap-4 px-4 py-4 text-white sm:px-8">
                        <div class="min-w-0">
                            <p class="truncate font-bold">{{ openProject.title }}</p>
                            <p class="text-sm text-white/60">{{ photoIndex + 1 }} / {{ photos.length }}<template v-if="photos[photoIndex].caption"> · {{ photos[photoIndex].caption }}</template></p>
                        </div>
                        <button
                            type="button"
                            class="shrink-0 rounded-full p-2 text-white/70 transition-colors hover:bg-white/10 hover:text-white"
                            :aria-label="t('portfolio_close')"
                            @click="closeGallery"
                        >
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="relative flex min-h-0 flex-1 items-center justify-center px-4 sm:px-20" @click.self="closeGallery">
                        <img
                            :key="photos[photoIndex].path"
                            :src="photos[photoIndex].path"
                            :alt="`${openProject.title} - ${photoIndex + 1}`"
                            class="max-h-full max-w-full rounded-2xl object-contain"
                        >
                        <button
                            v-if="photos.length > 1"
                            type="button"
                            class="absolute left-2 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white backdrop-blur transition-colors hover:bg-white/25 sm:left-6"
                            :aria-label="t('portfolio_prev')"
                            @click="prev"
                        >
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                        </button>
                        <button
                            v-if="photos.length > 1"
                            type="button"
                            class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white backdrop-blur transition-colors hover:bg-white/25 sm:right-6"
                            :aria-label="t('portfolio_next')"
                            @click="next"
                        >
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                        </button>
                    </div>

                    <!-- Miniatures -->
                    <div v-if="photos.length > 1" class="overflow-x-auto px-4 py-4 sm:px-8">
                        <div class="mx-auto flex w-max gap-2">
                            <button
                                v-for="(photo, i) in photos"
                                :key="photo.path"
                                type="button"
                                class="h-16 w-16 shrink-0 overflow-hidden rounded-lg ring-2 transition-opacity"
                                :class="i === photoIndex ? 'opacity-100 ring-primary' : 'opacity-50 ring-transparent hover:opacity-80'"
                                :aria-label="`${i + 1} / ${photos.length}`"
                                @click="photoIndex = i"
                            >
                                <img :src="photo.path" alt="" class="h-full w-full object-cover" loading="lazy">
                            </button>
                        </div>
                    </div>
                </div>
            </transition>
        </Teleport>
    </FrontendLayout>
</template>
