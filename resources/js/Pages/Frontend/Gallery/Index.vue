<script setup>
import { ref, computed, watch, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import PageHero from '@/Components/Frontend/PageHero.vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();

const props = defineProps({
    categories: { type: Array, default: () => [] },
    uncategorizedGalleries: { type: Array, default: () => [] },
    hero: Object,
});

const activeCategory = ref(null); // id de catégorie, ou null pour tout
const activeType = ref(null); // 'image', 'video' ou null

const allItems = computed(() => [
    ...props.categories.flatMap((cat) =>
        (cat.published_galleries || []).map((item) => ({ ...item, category: cat }))
    ),
    ...props.uncategorizedGalleries.map((item) => ({ ...item, category: null })),
]);

const categoriesWithItems = computed(() =>
    props.categories.filter((cat) => (cat.published_galleries || []).length)
);

const items = computed(() =>
    allItems.value.filter((item) =>
        (!activeCategory.value || item.category?.id === activeCategory.value)
        && (!activeType.value || item.type === activeType.value)
    )
);

const youtubeId = (url) => {
    if (!url) return null;
    const match = url.match(/(?:youtu\.be\/|\/shorts\/|\/embed\/|[?&]v=)([\w-]{6,})/);
    return match ? match[1] : null;
};

const embedUrl = (url) => {
    const id = youtubeId(url);
    if (id) return `https://www.youtube.com/embed/${id}?autoplay=1`;
    if (url?.includes('vimeo.com')) {
        return `https://player.vimeo.com/video/${url.split('vimeo.com/')[1]?.split('?')[0]}?autoplay=1`;
    }
    return url;
};

const thumbnail = (item) => {
    if (item.type === 'image') return `/storage/${item.file_path}`;
    if (item.thumbnail_path) return `/storage/${item.thumbnail_path}`;
    const id = youtubeId(item.video_url);
    return id ? `https://img.youtube.com/vi/${id}/hqdefault.jpg` : null;
};

// Visionneuse
const currentIndex = ref(null);
const current = computed(() => (currentIndex.value === null ? null : items.value[currentIndex.value]));

const open = (index) => {
    currentIndex.value = index;
};
const close = () => {
    currentIndex.value = null;
};
const next = () => {
    currentIndex.value = (currentIndex.value + 1) % items.value.length;
};
const prev = () => {
    currentIndex.value = (currentIndex.value - 1 + items.value.length) % items.value.length;
};

const onKey = (e) => {
    if (e.key === 'Escape') close();
    if (e.key === 'ArrowRight') next();
    if (e.key === 'ArrowLeft') prev();
};

watch(current, (value) => {
    document.body.style.overflow = value ? 'hidden' : '';
    if (value) window.addEventListener('keydown', onKey);
    else window.removeEventListener('keydown', onKey);
});

onUnmounted(() => {
    document.body.style.overflow = '';
    window.removeEventListener('keydown', onKey);
});

const chipClass = (active) => [
    'whitespace-nowrap rounded-full px-5 py-2.5 text-sm font-semibold transition-colors',
    active ? 'bg-primary text-white' : 'bg-surface-2 text-fg hover:bg-surface-3',
];
</script>

<template>
    <FrontendLayout :title="t('gallery_title')">
        <PageHero
            :image="hero?.image_url"
            fallback="/image/blog-hero.jpg"
            :eyebrow="t('gallery_photos_videos')"
            :title="t('gallery_our_gallery')"
            :lead="t('gallery_page_lead')"
        />

        <section class="py-12 md:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Filtres -->
                <div class="mb-7 flex flex-col md:mb-10 gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div v-if="categoriesWithItems.length > 1" class="hide-scrollbar -mx-4 overflow-x-auto px-4 pb-1 sm:mx-0 sm:px-0">
                        <div class="flex w-max gap-2 sm:w-auto sm:flex-wrap">
                            <button type="button" :class="chipClass(!activeCategory)" :aria-pressed="!activeCategory" @click="activeCategory = null">
                                {{ t('gallery_all') }}
                            </button>
                            <button
                                v-for="cat in categoriesWithItems"
                                :key="cat.id"
                                type="button"
                                :class="chipClass(activeCategory === cat.id)"
                                :aria-pressed="activeCategory === cat.id"
                                @click="activeCategory = cat.id"
                            >
                                {{ cat.name }}
                            </button>
                        </div>
                    </div>

                    <div class="flex w-max rounded-full bg-surface-2 p-1 text-sm font-semibold">
                        <button
                            v-for="option in [{ value: null, label: t('gallery_all') }, { value: 'image', label: t('gallery_photos') }, { value: 'video', label: t('gallery_videos') }]"
                            :key="option.label"
                            type="button"
                            class="rounded-full px-4 py-2 transition-colors"
                            :class="activeType === option.value ? 'bg-primary text-white shadow-sm' : 'text-fg/60 hover:text-fg'"
                            :aria-pressed="activeType === option.value"
                            @click="activeType = option.value"
                        >
                            {{ option.label }}
                        </button>
                    </div>
                </div>

                <p v-if="!items.length" class="py-20 text-center text-fg-soft">{{ t('gallery_empty') }}</p>

                <!-- Grille -->
                <div class="grid grid-cols-2 gap-3 sm:gap-4 md:grid-cols-3 lg:grid-cols-4">
                    <button
                        v-for="(item, index) in items"
                        :key="item.id"
                        type="button"
                        class="group relative aspect-square overflow-hidden rounded-2xl bg-surface-2 sm:rounded-3xl"
                        :aria-label="item.type === 'video' ? `${t('gallery_play')} : ${item.title || ''}` : (item.title || t('gallery_photos'))"
                        @click="open(index)"
                    >
                        <img
                            v-if="thumbnail(item)"
                            :src="thumbnail(item)"
                            :alt="item.title || ''"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                            loading="lazy"
                        >
                        <div v-else class="flex h-full w-full items-center justify-center bg-secondary">
                            <img src="/image/logo.png" alt="" class="h-12 w-12 opacity-40">
                        </div>

                        <span v-if="item.type === 'video'" class="absolute inset-0 flex items-center justify-center">
                            <span class="flex h-14 w-14 items-center justify-center rounded-full bg-white/90 text-accent shadow-xl transition-transform group-hover:scale-110">
                                <svg class="ml-1 h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z" /></svg>
                            </span>
                        </span>

                        <span
                            v-if="item.title"
                            class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/75 to-transparent p-3 pt-10 text-left text-sm font-semibold text-white opacity-0 transition-opacity group-hover:opacity-100 max-sm:opacity-100"
                        >
                            <span class="line-clamp-1">{{ item.title }}</span>
                        </span>
                    </button>
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

        <!-- Visionneuse -->
        <Teleport to="body">
            <transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0"
                leave-active-class="transition duration-150 ease-in"
                leave-to-class="opacity-0"
            >
                <div v-if="current" class="fixed inset-0 z-[70] flex flex-col bg-black" role="dialog" aria-modal="true">
                    <div class="flex items-center justify-between gap-4 px-4 py-4 text-white sm:px-8">
                        <div class="min-w-0">
                            <p v-if="current.title" class="truncate font-bold">{{ current.title }}</p>
                            <p class="text-sm text-white/60">
                                {{ currentIndex + 1 }} / {{ items.length }}<template v-if="current.category"> · {{ current.category.name }}</template>
                            </p>
                        </div>
                        <button
                            type="button"
                            class="shrink-0 rounded-full p-2 text-white/70 transition-colors hover:bg-white/10 hover:text-white"
                            :aria-label="t('portfolio_close')"
                            @click="close"
                        >
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="relative flex min-h-0 flex-1 items-center justify-center px-4 pb-8 sm:px-20" @click.self="close">
                        <img
                            v-if="current.type === 'image'"
                            :key="current.id"
                            :src="`/storage/${current.file_path}`"
                            :alt="current.title || ''"
                            class="max-h-full max-w-full rounded-2xl object-contain"
                        >
                        <div v-else class="aspect-video w-full max-w-5xl overflow-hidden rounded-2xl bg-black">
                            <iframe
                                :key="current.id"
                                :src="embedUrl(current.video_url)"
                                :title="current.title || t('gallery_videos')"
                                class="h-full w-full"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                            ></iframe>
                        </div>

                        <button
                            v-if="items.length > 1"
                            type="button"
                            class="absolute left-2 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white backdrop-blur transition-colors hover:bg-white/25 sm:left-6"
                            :aria-label="t('portfolio_prev')"
                            @click="prev"
                        >
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                        </button>
                        <button
                            v-if="items.length > 1"
                            type="button"
                            class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white backdrop-blur transition-colors hover:bg-white/25 sm:right-6"
                            :aria-label="t('portfolio_next')"
                            @click="next"
                        >
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                        </button>
                    </div>

                    <p v-if="current.description" class="mx-auto max-w-3xl px-6 pb-8 text-center text-sm text-white/70">{{ current.description }}</p>
                </div>
            </transition>
        </Teleport>
    </FrontendLayout>
</template>
