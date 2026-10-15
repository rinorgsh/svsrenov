<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue';
import { useTranslations } from '@/Composables/useTranslations';

const props = defineProps({
    before: { type: String, required: true },
    after: { type: String, required: true },
    beforeLabel: { type: String, default: 'Avant' },
    afterLabel: { type: String, default: 'Après' },
    alt: { type: String, default: '' },
    // Petite animation au chargement pour montrer que c'est interactif
    hint: { type: Boolean, default: false },
    eager: { type: Boolean, default: false },
    // Dans un diaporama : false quand la diapo est cachée
    active: { type: Boolean, default: true },
    // 'contain' : photo entière (fond flou autour) ; 'cover' : remplit le cadre en rognant
    fit: { type: String, default: 'contain' },
    // Bouton « Agrandir » : avant / après en plein écran, format d'origine
    expandable: { type: Boolean, default: false },
});

const { t } = useTranslations();

const emit = defineEmits(['interact']);

const container = ref(null);
const position = ref(50);
const dragging = ref(false);
let hintTimer = null;
let hintFrame = null;
// L'animation n'est jouée que lorsque le curseur est réellement à l'écran
const visible = ref(false);
let observer = null;

const setFromClientX = (clientX) => {
    const rect = container.value.getBoundingClientRect();
    const pct = ((clientX - rect.left) / rect.width) * 100;
    position.value = Math.min(100, Math.max(0, pct));
};

const onPointerDown = (e) => {
    stopHint();
    emit('interact');
    dragging.value = true;
    container.value.setPointerCapture(e.pointerId);
    setFromClientX(e.clientX);
};

const onPointerMove = (e) => {
    if (dragging.value) setFromClientX(e.clientX);
};

const onPointerUp = () => {
    dragging.value = false;
};

const stopHint = () => {
    clearTimeout(hintTimer);
    cancelAnimationFrame(hintFrame);
};

// 50 → 30 → 62 → 50 sur ~1,6 s, en douceur
const playHint = () => {
    const keys = [50, 30, 62, 50];
    const duration = 1600;
    const start = performance.now();
    const step = (now) => {
        const p = Math.min(1, (now - start) / duration);
        const seg = Math.min(keys.length - 2, Math.floor(p * (keys.length - 1)));
        const local = p * (keys.length - 1) - seg;
        const ease = local < 0.5 ? 2 * local * local : 1 - Math.pow(-2 * local + 2, 2) / 2;
        position.value = keys[seg] + (keys[seg + 1] - keys[seg]) * ease;
        if (p < 1) hintFrame = requestAnimationFrame(step);
    };
    hintFrame = requestAnimationFrame(step);
};

const scheduleHint = (delay) => {
    stopHint();
    position.value = 50;
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (props.hint && props.active && visible.value && !reduced) hintTimer = setTimeout(playHint, delay);
};

onMounted(() => {
    if (!props.hint) return;
    if (!('IntersectionObserver' in window)) {
        visible.value = true;
        scheduleHint(900);
        return;
    }
    // Une seule fois, la première fois que le slider apparaît à l'écran
    observer = new IntersectionObserver(([entry]) => {
        if (!entry.isIntersecting) return;
        visible.value = true;
        scheduleHint(600);
        observer.disconnect();
    }, { threshold: 0.6 });
    observer.observe(container.value);
});

// Rejoue l'animation à chaque fois que la diapo revient à l'écran
watch(() => props.active, (active) => {
    if (active) scheduleHint(600);
    else stopHint();
});

// Visionneuse plein écran : côte à côte sur grand écran, bascule avant / après sur mobile
const viewerOpen = ref(false);
const viewerSide = ref('after');

const onKey = (e) => {
    if (e.key === 'Escape') closeViewer();
    if (e.key === 'ArrowLeft') viewerSide.value = 'before';
    if (e.key === 'ArrowRight') viewerSide.value = 'after';
};

const openViewer = () => {
    stopHint();
    emit('interact');
    viewerSide.value = 'after';
    viewerOpen.value = true;
    document.body.style.overflow = 'hidden';
    window.addEventListener('keydown', onKey);
};

const closeViewer = () => {
    viewerOpen.value = false;
    document.body.style.overflow = '';
    window.removeEventListener('keydown', onKey);
};

onUnmounted(() => {
    stopHint();
    observer?.disconnect();
    if (viewerOpen.value) closeViewer();
});
</script>

<template>
    <div
        ref="container"
        class="group relative select-none overflow-hidden bg-gray-200"
        :class="dragging ? 'cursor-grabbing' : 'cursor-ew-resize'"
        style="touch-action: pan-y"
        @pointerdown="onPointerDown"
        @pointermove="onPointerMove"
        @pointerup="onPointerUp"
        @pointercancel="onPointerUp"
    >
        <!-- Après (fond) puis Avant (rogné par le curseur) -->
        <div
            v-for="layer in [{ src: after, label: afterLabel }, { src: before, label: beforeLabel, clip: true }]"
            :key="layer.label"
            class="pointer-events-none absolute inset-0 overflow-hidden bg-gray-200"
            :style="layer.clip ? { clipPath: `inset(0 ${100 - position}% 0 0)` } : null"
        >
            <!-- Même photo floutée pour remplir les bords quand elle est affichée en entier -->
            <img
                v-if="fit === 'contain'"
                :src="layer.src"
                alt=""
                aria-hidden="true"
                class="absolute inset-0 h-full w-full scale-110 object-cover blur-2xl brightness-75"
                draggable="false"
                :loading="eager ? 'eager' : 'lazy'"
            >
            <img
                :src="layer.src"
                :alt="`${alt} - ${layer.label}`"
                class="absolute inset-0 h-full w-full"
                :class="fit === 'contain' ? 'object-contain' : 'object-cover'"
                draggable="false"
                :loading="eager ? 'eager' : 'lazy'"
            >
        </div>

        <!-- Étiquettes -->
        <span class="pointer-events-none absolute left-4 top-4 rounded-full bg-black/60 px-3 py-1 text-xs font-bold uppercase tracking-wider text-white backdrop-blur">
            {{ beforeLabel }}
        </span>
        <span class="pointer-events-none absolute right-4 top-4 rounded-full bg-primary px-3 py-1 text-xs font-bold uppercase tracking-wider text-white">
            {{ afterLabel }}
        </span>

        <!-- Poignée -->
        <div class="pointer-events-none absolute inset-y-0 w-0.5 bg-white shadow-[0_0_12px_rgba(0,0,0,0.35)]" :style="{ left: `${position}%` }">
            <div class="absolute left-1/2 top-1/2 flex h-12 w-12 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-white text-secondary shadow-xl ring-4 ring-white/30 transition-transform group-hover:scale-110">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7l-5 5 5 5M16 7l5 5-5 5" />
                </svg>
            </div>
        </div>

        <!-- Accessibilité clavier -->
        <input
            v-model.number="position"
            type="range"
            min="0"
            max="100"
            step="1"
            class="sr-only"
            :aria-label="`${beforeLabel} / ${afterLabel}`"
            @focus="stopHint"
            @input="emit('interact')"
        >

        <button
            v-if="expandable"
            type="button"
            class="absolute bottom-4 right-4 z-10 inline-flex items-center gap-1.5 rounded-full bg-black/60 px-3 py-2 text-xs font-bold uppercase tracking-wider text-white backdrop-blur transition-colors hover:bg-primary"
            :aria-label="`${t('portfolio_enlarge')} - ${alt}`"
            @pointerdown.stop
            @click="openViewer"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4h4M20 8V4h-4M4 16v4h4M20 16v4h-4" />
            </svg>
            {{ t('portfolio_enlarge') }}
        </button>

        <slot />

        <!-- Visionneuse (téléportée : n'hérite pas des événements du curseur) avant / après plein écran -->
        <Teleport v-if="expandable" to="body">
            <transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0"
                leave-active-class="transition duration-150 ease-in"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="viewerOpen"
                    class="fixed inset-0 z-[70] flex flex-col bg-black"
                    role="dialog"
                    aria-modal="true"
                    :aria-label="alt"
                >
                    <div class="flex items-center justify-between gap-4 px-4 py-4 text-white sm:px-8">
                        <p class="min-w-0 truncate font-bold">{{ alt }}</p>
                        <button
                            type="button"
                            class="shrink-0 rounded-full p-2 text-white/70 transition-colors hover:bg-white/10 hover:text-white"
                            :aria-label="t('portfolio_close')"
                            @click="closeViewer"
                        >
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <!-- Bascule avant / après (mobile) -->
                    <div class="flex justify-center px-4 pb-4 md:hidden">
                        <div class="inline-flex rounded-full bg-white/10 p-1">
                            <button
                                v-for="side in ['before', 'after']"
                                :key="side"
                                type="button"
                                class="rounded-full px-6 py-2 text-sm font-bold uppercase tracking-wider transition-colors"
                                :class="viewerSide === side ? (side === 'after' ? 'bg-primary text-white' : 'bg-white text-secondary') : 'text-white/70'"
                                :aria-pressed="viewerSide === side"
                                @click="viewerSide = side"
                            >
                                {{ side === 'before' ? beforeLabel : afterLabel }}
                            </button>
                        </div>
                    </div>

                    <div class="grid min-h-0 flex-1 gap-4 px-4 pb-6 sm:px-8 md:grid-cols-2" @click.self="closeViewer">
                        <figure
                            v-for="side in ['before', 'after']"
                            :key="side"
                            class="relative min-h-0 items-center justify-center md:flex"
                            :class="viewerSide === side ? 'flex' : 'hidden'"
                            @click.self="closeViewer"
                        >
                            <img
                                :src="side === 'before' ? before : after"
                                :alt="`${alt} - ${side === 'before' ? beforeLabel : afterLabel}`"
                                class="max-h-full max-w-full rounded-2xl object-contain"
                            >
                            <figcaption
                                class="absolute left-3 top-3 hidden rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider text-white md:block"
                                :class="side === 'after' ? 'bg-primary' : 'bg-black/60 backdrop-blur'"
                            >
                                {{ side === 'before' ? beforeLabel : afterLabel }}
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </transition>
        </Teleport>
    </div>
</template>
