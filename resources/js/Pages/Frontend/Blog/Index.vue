<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import PostCard from '@/Components/Frontend/PostCard.vue';
import { useTranslations } from '@/Composables/useTranslations';
import { useDate } from '@/Composables/useDate';

const props = defineProps({
    posts: { type: Array, default: () => [] },
});

const { t } = useTranslations();
const { formatDate } = useDate();

const featured = computed(() => props.posts[0] ?? null);
const others = computed(() => props.posts.slice(1));
</script>

<template>
    <FrontendLayout :title="t('blog_title')" :description="t('blog_subtitle')">
        <section class="relative isolate overflow-hidden bg-secondary pb-20 pt-[140px] md:pb-28 md:pt-[190px]">
            <img
                src="/image/blog-hero.jpg"
                alt=""
                class="absolute inset-0 -z-10 h-full w-full object-cover"
                fetchpriority="high"
            >
            <div class="absolute inset-0 -z-10 bg-gradient-to-r from-black/85 via-black/60 to-black/20"></div>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <span class="mb-4 inline-block rounded-full bg-white/10 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.2em] text-white ring-1 ring-white/20 backdrop-blur">
                    {{ t('blog_eyebrow') }}
                </span>
                <h1 class="max-w-3xl text-4xl font-extrabold leading-[1.05] text-white sm:text-5xl md:text-6xl">{{ t('blog_title') }}</h1>
                <p class="mt-6 max-w-xl text-lg leading-relaxed text-white/80">{{ t('blog_subtitle') }}</p>
            </div>
        </section>

        <section class="py-16 md:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <p v-if="!posts.length" class="py-20 text-center text-gray-500">{{ t('blog_empty') }}</p>

                <!-- Article à la une -->
                <Link
                    v-if="featured"
                    :href="route('blog.show', featured.slug)"
                    class="group mb-16 grid items-center gap-8 md:mb-24 lg:grid-cols-2 lg:gap-14"
                >
                    <div class="aspect-[16/10] overflow-hidden rounded-[2rem] bg-gray-50">
                        <img
                            v-if="featured.cover"
                            :src="featured.cover"
                            :alt="featured.title"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        >
                        <div v-else class="flex h-full w-full items-center justify-center">
                            <img src="/image/logo.png" alt="" class="h-24 w-24 opacity-30">
                        </div>
                    </div>
                    <div>
                        <div class="mb-4 flex items-center gap-2 text-sm text-gray-500">
                            <time :datetime="featured.published_at">{{ formatDate(featured.published_at) }}</time>
                            <span class="h-1 w-1 rounded-full bg-gray-300"></span>
                            <span>{{ featured.reading_minutes }} {{ t('blog_min_read') }}</span>
                        </div>
                        <h2 class="mb-5 text-3xl font-extrabold leading-tight text-secondary transition-colors group-hover:text-primary md:text-4xl">
                            {{ featured.title }}
                        </h2>
                        <p class="mb-6 text-lg leading-relaxed text-gray-600">{{ featured.excerpt }}</p>
                        <span class="inline-flex items-center gap-2 font-semibold text-primary transition-all group-hover:gap-3">
                            {{ t('blog_read_more') }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </span>
                    </div>
                </Link>

                <div v-if="others.length" class="grid gap-x-8 gap-y-14 md:grid-cols-2 lg:grid-cols-3">
                    <PostCard v-for="post in others" :key="post.id" :post="post" />
                </div>
            </div>
        </section>
    </FrontendLayout>
</template>
