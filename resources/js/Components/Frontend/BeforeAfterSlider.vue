<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue';

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
});

const emit = defineEmits(['interact']);

const container = ref(null);
const position = ref(50);
const dragging = ref(false);
let hintTimer = null;
let hintFrame = null;

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
    if (props.hint && props.active && !reduced) hintTimer = setTimeout(playHint, delay);
};

onMounted(() => scheduleHint(900));

// Rejoue l'animation à chaque fois que la diapo revient à l'écran
watch(() => props.active, (active) => {
    if (active) scheduleHint(600);
    else stopHint();
});

onUnmounted(stopHint);
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
        <!-- Après (fond) -->
        <img
            :src="after"
            :alt="`${alt} - ${afterLabel}`"
            class="pointer-events-none absolute inset-0 h-full w-full object-cover"
            draggable="false"
            :loading="eager ? 'eager' : 'lazy'"
        >
        <!-- Avant (rogné) -->
        <img
            :src="before"
            :alt="`${alt} - ${beforeLabel}`"
            class="pointer-events-none absolute inset-0 h-full w-full object-cover"
            :style="{ clipPath: `inset(0 ${100 - position}% 0 0)` }"
            draggable="false"
            :loading="eager ? 'eager' : 'lazy'"
        >

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

        <slot />
    </div>
</template>
