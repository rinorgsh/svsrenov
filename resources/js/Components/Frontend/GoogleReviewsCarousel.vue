<script setup>
import { ref, computed, watch, onUnmounted } from 'vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();

const props = defineProps({
    reviews: { type: Array, default: () => [] },
    stats: { type: Object, default: () => ({}) },
    profileUrl: { type: String, default: null },
});

const STAR = 'M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z';

// Nombre minimum de cartes par passage, pour que la bande couvre les écrans très larges
const MIN_PER_ROW = 6;
const SECONDS_PER_CARD = 9;

const fillRow = (list) => {
    if (!list.length) return [];
    const out = [];
    while (out.length < MIN_PER_ROW) out.push(...list);
    return out;
};

const rows = computed(() => {
    const list = props.reviews || [];
    if (list.length < 4) return [fillRow(list)];
    const half = Math.ceil(list.length / 2);
    return [fillRow(list.slice(0, half)), fillRow(list.slice(half))];
});

const rating = computed(() => (props.stats?.average_rating ?? 0).toFixed(1).replace('.', ','));

const initials = (name) => (name || '?').trim().charAt(0).toUpperCase();

// Fenêtre "lire la suite"
const selected = ref(null);
const onKey = (e) => {
    if (e.key === 'Escape') selected.value = null;
};

watch(selected, (value) => {
    document.body.style.overflow = value ? 'hidden' : '';
    if (value) window.addEventListener('keydown', onKey);
    else window.removeEventListener('keydown', onKey);
});

onUnmounted(() => {
    document.body.style.overflow = '';
    window.removeEventListener('keydown', onKey);
});
</script>

<template>
    <section v-if="reviews?.length" class="overflow-hidden bg-surface-2 py-20 md:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12 flex flex-col items-center text-center">
                <span class="mb-4 text-sm font-bold uppercase tracking-[0.2em] text-accent">{{ t('reviews_eyebrow') }}</span>
                <h2 class="max-w-2xl text-3xl font-extrabold leading-tight text-fg sm:text-4xl md:text-5xl">
                    {{ t('reviews_title') }}
                </h2>

                <!-- Badge note Google -->
                <component
                    :is="profileUrl ? 'a' : 'div'"
                    :href="profileUrl || undefined"
                    :target="profileUrl ? '_blank' : undefined"
                    :rel="profileUrl ? 'noopener noreferrer' : undefined"
                    class="mt-8 inline-flex items-center gap-3 rounded-full bg-surface-3 px-5 py-3 shadow-sm ring-1 ring-line/10 transition-shadow sm:gap-4 sm:px-6"
                    :class="{ 'hover:shadow-lg': profileUrl }"
                >
                    <svg class="h-6 w-6 shrink-0" viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                    <span class="flex text-amber-400">
                        <svg v-for="i in 5" :key="i" class="h-4 w-4 sm:h-5 sm:w-5" fill="currentColor" viewBox="0 0 20 20"><path :d="STAR" /></svg>
                    </span>
                    <span class="text-lg font-extrabold text-fg">{{ rating }}</span>
                    <span class="border-l border-line/10 pl-3 text-xs font-medium text-fg-soft sm:pl-4 sm:text-sm">
                        {{ t('reviews_based_on') }} {{ stats?.total_count }} {{ t('reviews_count_label') }}
                    </span>
                </component>
            </div>
        </div>

        <!-- Bandes défilantes (sens opposés) -->
        <div class="reviews-fade space-y-5">
            <div v-for="(row, r) in rows" :key="r" class="overflow-hidden py-2">
                <div
                    class="reviews-track"
                    :class="{ 'reviews-track--reverse': r === 1 }"
                    :style="{ animationDuration: `${row.length * SECONDS_PER_CARD}s` }"
                >
                    <template v-for="pass in 3" :key="pass">
                        <div
                            v-for="(review, index) in row"
                            :key="`${pass}-${index}`"
                            class="w-[82vw] flex-none px-2.5 sm:w-[360px]"
                            :aria-hidden="pass > 1 ? 'true' : undefined"
                        >
                            <button
                                type="button"
                                class="flex h-full min-h-[220px] w-full flex-col rounded-3xl bg-surface-3 p-6 text-left ring-1 ring-line/10 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl"
                                :tabindex="pass > 1 ? -1 : 0"
                                @click="selected = review"
                            >
                                <div class="mb-4 flex items-center gap-3">
                                    <img
                                        v-if="review.author_photo_url"
                                        :src="review.author_photo_url"
                                        :alt="review.author_name"
                                        class="h-11 w-11 shrink-0 rounded-full object-cover"
                                        referrerpolicy="no-referrer"
                                        loading="lazy"
                                    >
                                    <span v-else class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-primary/10 font-bold text-accent">
                                        {{ initials(review.author_name) }}
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block truncate text-sm font-semibold text-fg">{{ review.author_name }}</span>
                                        <span class="block text-xs text-fg-soft">{{ review.relative_time }}</span>
                                    </span>
                                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                                </div>
                                <span class="mb-3 flex gap-0.5">
                                    <svg
                                        v-for="i in 5"
                                        :key="i"
                                        class="h-4 w-4"
                                        :class="i <= (review.rating || 5) ? 'text-amber-400' : 'text-gray-200'"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    ><path :d="STAR" /></svg>
                                </span>
                                <span class="line-clamp-4 flex-1 text-sm leading-relaxed text-fg-muted">{{ review.comment }}</span>
                                <span v-if="review.comment?.length > 160" class="mt-3 text-sm font-semibold text-accent">
                                    {{ t('home_google_reviews_read_more') }} →
                                </span>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div v-if="profileUrl" class="mt-10 flex justify-center px-4">
            <a
                :href="profileUrl"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-2 text-sm font-semibold text-fg transition-all hover:gap-3 hover:text-accent"
            >
                {{ t('reviews_see_all') }}
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </a>
        </div>

        <!-- Fenêtre avis complet -->
        <Teleport to="body">
            <transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0"
                leave-active-class="transition duration-150 ease-in"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="selected"
                    class="fixed inset-0 z-[60] flex items-end justify-center bg-black/60 p-0 backdrop-blur-sm sm:items-center sm:p-4"
                    role="dialog"
                    aria-modal="true"
                    @click.self="selected = null"
                >
                    <div class="max-h-[85vh] w-full overflow-y-auto rounded-t-3xl bg-surface-3 p-6 sm:max-w-lg sm:rounded-3xl sm:p-8">
                        <div class="mb-5 flex items-start gap-4">
                            <img
                                v-if="selected.author_photo_url"
                                :src="selected.author_photo_url"
                                :alt="selected.author_name"
                                class="h-14 w-14 shrink-0 rounded-full object-cover"
                                referrerpolicy="no-referrer"
                            >
                            <span v-else class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-primary/10 text-lg font-bold text-accent">
                                {{ initials(selected.author_name) }}
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="font-bold text-fg">{{ selected.author_name }}</p>
                                <p class="text-xs text-fg-soft">{{ selected.relative_time }}</p>
                                <div class="mt-1.5 flex gap-0.5">
                                    <svg
                                        v-for="i in 5"
                                        :key="i"
                                        class="h-4 w-4"
                                        :class="i <= (selected.rating || 5) ? 'text-amber-400' : 'text-gray-200'"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    ><path :d="STAR" /></svg>
                                </div>
                            </div>
                            <button
                                type="button"
                                class="shrink-0 rounded-full p-1 text-fg-soft transition-colors hover:bg-surface-2 hover:text-fg-muted"
                                :aria-label="t('reviews_close')"
                                @click="selected = null"
                            >
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <p class="whitespace-pre-line leading-relaxed text-fg-muted">{{ selected.comment }}</p>
                    </div>
                </div>
            </transition>
        </Teleport>
    </section>
</template>

<style scoped>
.reviews-track {
    display: flex;
    width: max-content;
    animation: reviews-scroll linear infinite;
}

.reviews-track--reverse {
    animation-direction: reverse;
}

.reviews-track:hover,
.reviews-track:focus-within {
    animation-play-state: paused;
}

.reviews-fade {
    -webkit-mask-image: linear-gradient(to right, transparent, #000 6%, #000 94%, transparent);
    mask-image: linear-gradient(to right, transparent, #000 6%, #000 94%, transparent);
}

/* 3 passages identiques : décaler d'un tiers boucle sans raccord visible */
@keyframes reviews-scroll {
    from { transform: translateX(0); }
    to { transform: translateX(-33.3333%); }
}

@media (prefers-reduced-motion: reduce) {
    .reviews-track {
        animation: none;
    }
    .reviews-fade > div {
        overflow-x: auto;
    }
}
</style>
