<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const currentLocale = computed(() => page.props.locale);

// Recharge la page courante avec ?lang=xx (le serveur mémorise le choix en session)
const switchLanguage = (locale) => {
    if (locale === currentLocale.value) return;
    const url = new URL(window.location.href);
    url.searchParams.set('lang', locale);
    router.visit(url.pathname + url.search, {
        preserveState: false,
        preserveScroll: true,
    });
};
</script>

<template>
    <div class="flex items-center rounded-full bg-white/10 p-1 text-xs font-bold">
        <button
            v-for="locale in ['fr', 'nl']"
            :key="locale"
            type="button"
            class="rounded-full px-3 py-1.5 uppercase transition-all"
            :class="currentLocale === locale
                ? 'bg-white text-secondary shadow-sm'
                : 'text-white/50 hover:text-white'"
            :aria-pressed="currentLocale === locale"
            @click="switchLanguage(locale)"
        >
            {{ locale }}
        </button>
    </div>
</template>
