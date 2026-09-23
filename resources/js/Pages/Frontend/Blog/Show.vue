<script setup>
import { Link } from '@inertiajs/vue3';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import PostCard from '@/Components/Frontend/PostCard.vue';
import { useTranslations } from '@/Composables/useTranslations';
import { useDate } from '@/Composables/useDate';

defineProps({
    post: { type: Object, required: true },
    related: { type: Array, default: () => [] },
});

const { t } = useTranslations();
const { formatDate } = useDate();
</script>

<template>
    <FrontendLayout :title="post.title" :description="post.excerpt">

        <article class="theme-light bg-surface">
            <header class="bg-surface-2 pb-10 pt-[100px] md:pb-12 md:pt-[150px]">
                <div class="mx-auto max-w-3xl px-4 sm:px-6">
                    <Link :href="route('blog.index')" class="mb-8 inline-flex items-center gap-2 text-sm font-semibold text-fg-soft transition-colors hover:text-accent">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        {{ t('blog_back') }}
                    </Link>
                    <div class="mb-5 flex flex-wrap items-center gap-2 text-sm text-fg-soft">
                        <Link
                            v-if="post.service"
                            :href="route('services.show', post.service.slug)"
                            class="rounded-full bg-surface-3 px-3 py-1 font-semibold text-accent ring-1 ring-line/10"
                        >
                            {{ post.service.title }}
                        </Link>
                        <time :datetime="post.published_at">{{ formatDate(post.published_at) }}</time>
                        <span class="h-1 w-1 rounded-full bg-gray-300"></span>
                        <span>{{ post.reading_minutes }} {{ t('blog_min_read') }}</span>
                    </div>
                    <h1 class="text-4xl font-extrabold leading-[1.08] text-fg sm:text-5xl">{{ post.title }}</h1>
                    <p v-if="post.excerpt" class="mt-6 text-xl leading-relaxed text-fg-muted">{{ post.excerpt }}</p>
                </div>
            </header>

            <div v-if="post.cover" class="mx-auto -mb-4 max-w-5xl px-4 pt-10 sm:px-6">
                <img :src="post.cover" :alt="post.title" class="aspect-[16/9] w-full rounded-[2rem] object-cover">
            </div>

            <div class="mx-auto max-w-3xl px-4 py-14 sm:px-6 md:py-20">
                <div class="post-content" v-html="post.html"></div>

                <!-- CTA -->
                <aside class="mt-16 rounded-[2rem] bg-secondary p-8 text-white md:p-10">
                    <h2 class="mb-3 text-2xl font-extrabold md:text-3xl">{{ t('blog_cta_title') }}</h2>
                    <p class="mb-6 text-gray-300">{{ t('blog_cta_text') }}</p>
                    <div class="flex flex-wrap gap-3">
                        <Link :href="route('contact.index')" class="rounded-full bg-primary px-6 py-3 font-semibold transition-colors hover:bg-white hover:text-secondary">
                            {{ t('nav_quote_cta') }}
                        </Link>
                        <a href="tel:+32472640679" class="rounded-full border border-white/20 px-6 py-3 font-semibold transition-colors hover:border-white">
                            0472 64 06 79
                        </a>
                    </div>
                </aside>
            </div>
        </article>

        <section v-if="related.length" class="border-t border-line/10 py-12 md:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-10 text-3xl font-extrabold text-fg">{{ t('blog_related') }}</h2>
                <div class="grid gap-8 md:grid-cols-3">
                    <PostCard v-for="item in related" :key="item.id" :post="item" />
                </div>
            </div>
        </section>
    </FrontendLayout>
</template>

<style scoped>
/* Mise en forme du contenu Markdown */
.post-content {
    @apply text-lg leading-[1.8] text-fg-muted;
}
.post-content :deep(h2) {
    @apply mb-4 mt-12 text-3xl font-extrabold text-fg;
}
.post-content :deep(h3) {
    @apply mb-3 mt-10 text-2xl font-bold text-fg;
}
.post-content :deep(p) {
    @apply mb-6;
}
.post-content :deep(a) {
    @apply font-semibold text-accent underline decoration-primary/30 underline-offset-4 hover:decoration-primary;
}
.post-content :deep(ul) {
    @apply mb-6 list-disc space-y-2 pl-6 marker:text-accent;
}
.post-content :deep(ol) {
    @apply mb-6 list-decimal space-y-2 pl-6 marker:font-bold marker:text-accent;
}
.post-content :deep(blockquote) {
    @apply my-8 border-l-4 border-primary bg-surface-2 py-4 pl-6 pr-4 italic text-fg;
}
.post-content :deep(img) {
    @apply my-8 max-h-[560px] w-full rounded-2xl object-cover;
}
.post-content :deep(table) {
    @apply my-8 block w-full overflow-x-auto rounded-2xl text-left text-base ring-1 ring-gray-200 md:table;
}
.post-content :deep(th) {
    @apply bg-secondary px-4 py-3 font-semibold text-white;
}
.post-content :deep(td) {
    @apply border-t border-line/10 px-4 py-3 align-top;
}
.post-content :deep(strong) {
    @apply font-bold text-fg;
}
.post-content :deep(hr) {
    @apply my-12 border-line/10;
}
</style>
