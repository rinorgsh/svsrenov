<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import BeforeAfterSlider from '@/Components/Frontend/BeforeAfterSlider.vue';
import PostCard from '@/Components/Frontend/PostCard.vue';
import { useTranslations } from '@/Composables/useTranslations';

const props = defineProps({
    service: { type: Object, required: true },
    projects: { type: Array, default: () => [] },
    otherServices: { type: Array, default: () => [] },
    posts: { type: Array, default: () => [] },
});

const { t } = useTranslations();

const comparableProjects = computed(() => props.projects.filter((p) => p.image_before && p.image_after));

// La description longue est du texte brut : un paragraphe par ligne vide
const paragraphs = computed(() =>
    (props.service.long_description || props.service.description || '')
        .split(/\n\s*\n/)
        .map((p) => p.trim())
        .filter(Boolean)
);
</script>

<template>
    <FrontendLayout :title="service.title" :description="service.description">
        <!-- En-tête -->
        <section class="bg-surface-2 pb-16 pt-[110px] md:pt-[140px]">
            <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:gap-16 lg:px-8">
                <div>
                    <Link :href="route('services.index')" class="mb-8 inline-flex items-center gap-2 text-sm font-semibold text-fg-soft transition-colors hover:text-accent">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        {{ t('service_detail_back') }}
                    </Link>
                    <h1 class="text-4xl font-extrabold leading-[1.05] text-fg sm:text-5xl lg:text-6xl">{{ service.title }}</h1>
                    <p class="mt-6 max-w-xl text-lg leading-relaxed text-fg-muted">{{ service.description }}</p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <Link :href="route('contact.index')" class="inline-flex items-center justify-center rounded-full bg-primary px-7 py-4 font-semibold text-white shadow-lg shadow-primary/25 transition-colors hover:bg-secondary">
                            {{ t('nav_quote_cta') }}
                        </Link>
                        <a href="tel:+32472640679" class="inline-flex items-center justify-center rounded-full bg-surface-3 px-7 py-4 font-semibold text-fg ring-1 ring-line/10 transition-colors hover:text-accent">
                            0472 64 06 79
                        </a>
                    </div>
                </div>
                <img
                    v-if="service.image"
                    :src="service.image"
                    :alt="service.title"
                    class="aspect-[4/3] w-full rounded-[2rem] object-cover shadow-2xl shadow-black/15"
                >
            </div>
        </section>

        <!-- Description -->
        <section v-if="paragraphs.length" class="theme-light bg-surface py-16 md:py-24">
            <div class="mx-auto max-w-3xl space-y-6 px-4 text-lg leading-[1.8] text-fg-muted sm:px-6">
                <p v-for="(paragraph, i) in paragraphs" :key="i" class="whitespace-pre-line">{{ paragraph }}</p>
            </div>
        </section>

        <!-- Réalisations -->
        <section v-if="comparableProjects.length" class="bg-surface-2 py-16 md:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-10 text-3xl font-extrabold text-fg md:text-4xl">{{ t('service_detail_related') }}</h2>
                <div class="grid gap-8 md:grid-cols-2">
                    <figure v-for="project in comparableProjects" :key="project.id">
                        <BeforeAfterSlider
                            :before="project.image_before"
                            :after="project.image_after"
                            :before-label="t('before')"
                            :after-label="t('after')"
                            :alt="project.title"
                            class="aspect-[4/3] w-full rounded-3xl"
                        />
                        <figcaption class="mt-4">
                            <p class="font-bold text-fg">{{ project.title }}</p>
                            <p v-if="project.location" class="text-sm text-fg-soft">{{ project.location }}</p>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <!-- Articles liés -->
        <section v-if="posts.length" class="py-16 md:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-10 text-3xl font-extrabold text-fg md:text-4xl">{{ t('blog_related') }}</h2>
                <div class="grid gap-8 md:grid-cols-3">
                    <PostCard v-for="post in posts" :key="post.id" :post="post" />
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-6 rounded-[2rem] bg-gradient-to-br from-primary to-[#7a130f] p-8 text-white shadow-2xl shadow-primary/20 md:flex-row md:items-center md:p-12">
                <div>
                    <h2 class="text-2xl font-extrabold md:text-3xl">{{ t('service_detail_cta_title') }}</h2>
                    <p class="mt-2 text-white/80">{{ t('service_detail_cta_text') }}</p>
                </div>
                <Link :href="route('contact.index')" class="shrink-0 rounded-full bg-white text-secondary px-7 py-4 font-semibold transition-colors hover:bg-secondary hover:text-white">
                    {{ t('nav_quote_cta') }}
                </Link>
            </div>
        </section>

        <!-- Autres services -->
        <section v-if="otherServices.length" class="pb-20 pt-4">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-8 text-2xl font-extrabold text-fg">{{ t('service_detail_other') }}</h2>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-6">
                    <Link
                        v-for="other in otherServices"
                        :key="other.slug"
                        :href="route('services.show', other.slug)"
                        class="group relative aspect-square overflow-hidden rounded-2xl bg-secondary"
                    >
                        <img
                            v-if="other.image"
                            :src="other.image"
                            :alt="other.title"
                            class="absolute inset-0 h-full w-full object-cover opacity-70 transition-all duration-500 group-hover:scale-105 group-hover:opacity-50"
                            loading="lazy"
                        >
                        <span class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-4 pt-10 text-sm font-bold text-white">
                            {{ other.title }}
                        </span>
                    </Link>
                </div>
            </div>
        </section>
    </FrontendLayout>
</template>
