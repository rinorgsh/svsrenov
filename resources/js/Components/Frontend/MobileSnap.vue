<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';

/**
 * Sur mobile : carrousel horizontal (une carte à la fois, on voit la suivante dépasser).
 * Sur ordinateur : grille classique. Le même balisage sert aux deux.
 */
const props = defineProps({
    count: { type: Number, required: true },
    // Classes de grille appliquées à partir de lg
    grid: { type: String, default: 'lg:grid lg:grid-cols-3' },
    label: { type: String, default: null },
});

const track = ref(null);
const active = ref(0);

const onScroll = () => {
    if (!track.value || props.count < 2) return;
    const step = track.value.scrollWidth / props.count;
    active.value = Math.min(props.count - 1, Math.max(0, Math.round(track.value.scrollLeft / step)));
};

const goTo = (i) => {
    if (!track.value) return;
    track.value.scrollTo({ left: (track.value.scrollWidth / props.count) * i, behavior: 'smooth' });
};

onMounted(() => track.value?.addEventListener('scroll', onScroll, { passive: true }));
onUnmounted(() => track.value?.removeEventListener('scroll', onScroll));

const dots = computed(() => Array.from({ length: props.count }, (_, i) => i));
</script>

<template>
    <div>
        <div
            ref="track"
            class="hide-scrollbar -mx-4 flex snap-x snap-mandatory gap-4 overflow-x-auto px-4 pb-1 sm:-mx-6 sm:px-6 lg:mx-0 lg:snap-none lg:gap-8 lg:overflow-visible lg:px-0"
            :class="grid"
            :aria-label="label"
        >
            <slot />
        </div>

        <!-- Points de progression (mobile uniquement) -->
        <div v-if="count > 1" class="mt-5 flex justify-center gap-2 lg:hidden">
            <button
                v-for="i in dots"
                :key="i"
                type="button"
                class="h-1.5 rounded-full transition-all"
                :class="active === i ? 'w-6 bg-accent' : 'w-1.5 bg-fg/25'"
                :aria-label="`${i + 1} / ${count}`"
                :aria-current="active === i"
                @click="goTo(i)"
            ></button>
        </div>
    </div>
</template>
