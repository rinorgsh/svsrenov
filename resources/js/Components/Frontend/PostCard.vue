<script setup>
import { Link } from '@inertiajs/vue3';
import { useTranslations } from '@/Composables/useTranslations';
import { useDate } from '@/Composables/useDate';

defineProps({
    post: { type: Object, required: true },
});

const { t } = useTranslations();
const { formatDate } = useDate();
</script>

<template>
    <Link :href="route('blog.show', post.slug)" class="group flex flex-col">
        <div class="relative mb-5 aspect-[16/10] overflow-hidden rounded-3xl bg-gray-50">
            <img
                v-if="post.cover"
                :src="post.cover"
                :alt="post.title"
                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                loading="lazy"
            >
            <div v-else class="flex h-full w-full items-center justify-center">
                <img src="/image/logo.png" alt="" class="h-16 w-16 opacity-30">
            </div>
        </div>
        <div class="mb-3 flex items-center gap-2 text-xs font-medium text-gray-500">
            <time :datetime="post.published_at">{{ formatDate(post.published_at) }}</time>
            <span class="h-1 w-1 rounded-full bg-gray-300"></span>
            <span>{{ post.reading_minutes }} {{ t('blog_min_read') }}</span>
        </div>
        <h3 class="mb-3 text-xl font-bold leading-snug text-secondary transition-colors group-hover:text-primary">
            {{ post.title }}
        </h3>
        <p class="line-clamp-3 text-sm leading-relaxed text-gray-600">{{ post.excerpt }}</p>
        <span class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-primary transition-all group-hover:gap-3">
            {{ t('blog_read_more') }}
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
        </span>
    </Link>
</template>
