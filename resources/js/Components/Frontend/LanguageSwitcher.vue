<script setup>
import { router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    isScrolled: {
        type: Boolean,
        default: true
    }
});

const page = usePage();
const currentLocale = computed(() => page.props.locale);

const switchLanguage = (locale) => {
    router.post(route('language.switch', locale), {}, {
        preserveState: false,
        preserveScroll: true,
    });
};
</script>

<template>
    <div
        class="flex items-center space-x-2 rounded-md p-1 transition-colors"
        :class="isScrolled ? 'bg-gray-100' : 'bg-white/20'"
    >
        <button
            @click="switchLanguage('fr')"
            class="px-3 py-1.5 rounded text-sm font-medium transition-all duration-200"
            :class="currentLocale === 'fr'
                ? 'bg-primary text-white'
                : isScrolled
                    ? 'text-secondary hover:text-primary'
                    : 'text-white hover:text-primary'"
        >
            FR
        </button>
        <button
            @click="switchLanguage('nl')"
            class="px-3 py-1.5 rounded text-sm font-medium transition-all duration-200"
            :class="currentLocale === 'nl'
                ? 'bg-primary text-white'
                : isScrolled
                    ? 'text-secondary hover:text-primary'
                    : 'text-white hover:text-primary'"
        >
            NL
        </button>
    </div>
</template>
