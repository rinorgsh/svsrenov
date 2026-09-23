<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    image: { type: String, default: null },
    fallback: { type: String, default: '/image/hero.webp' },
    eyebrow: { type: String, default: null },
    title: { type: String, required: true },
    lead: { type: String, default: null },
});

// Si l'image configurée dans l'admin est introuvable, on bascule sur la photo de secours
const src = ref(props.image || props.fallback);
watch(() => props.image, (value) => {
    src.value = value || props.fallback;
});

const onError = () => {
    if (src.value !== props.fallback) src.value = props.fallback;
};
</script>

<template>
    <section class="relative isolate overflow-hidden bg-secondary pb-12 pt-[104px] md:pb-28 md:pt-[190px]">
        <img
            :src="src"
            alt=""
            class="absolute inset-0 -z-10 h-full w-full object-cover"
            fetchpriority="high"
            @error="onError"
        >
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-black/85 via-black/60 to-black/20"></div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <span
                v-if="eyebrow"
                class="mb-4 inline-block rounded-full bg-white/10 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.2em] text-white ring-1 ring-white/20 backdrop-blur"
            >
                {{ eyebrow }}
            </span>
            <h1 class="max-w-3xl text-[2rem] font-extrabold leading-[1.08] text-white sm:text-5xl md:text-6xl">{{ title }}</h1>
            <p v-if="lead" class="mt-6 max-w-xl text-lg leading-relaxed text-white/80">{{ lead }}</p>
            <div v-if="$slots.default" class="mt-8 flex flex-col gap-3 sm:flex-row">
                <slot />
            </div>
        </div>
    </section>
</template>
