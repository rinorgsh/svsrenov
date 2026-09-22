<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';
import LanguageSwitcher from './LanguageSwitcher.vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();
const mobileMenuOpen = ref(false);
const isScrolled = ref(false);

const PHONE_HREF = 'tel:+32472640679';
const PHONE_LABEL = '0472 64 06 79';

const navigation = computed(() => [
    { name: t('about'), href: route('about.index'), match: 'about.*' },
    { name: t('services'), href: route('services.index'), match: 'services.*' },
    { name: t('nav_realisations'), href: route('portfolio.index'), match: 'portfolio.*' },
    { name: t('gallery'), href: route('gallery.index'), match: 'gallery.*' },
    { name: t('blog'), href: route('blog.index'), match: 'blog.*' },
    { name: t('contact'), href: route('contact.index'), match: 'contact.*' },
]);

const isActive = (item) => route().current(item.match);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 8;
};

// Ferme le menu mobile à chaque navigation Inertia
let removeNavListener = null;

onMounted(() => {
    handleScroll();
    window.addEventListener('scroll', handleScroll, { passive: true });
    removeNavListener = router.on('navigate', () => {
        mobileMenuOpen.value = false;
    });
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    removeNavListener?.();
});
</script>

<template>
    <header
        class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
        :class="isScrolled || mobileMenuOpen
            ? 'bg-white shadow-[0_1px_0_rgba(0,0,0,0.06),0_8px_24px_-12px_rgba(0,0,0,0.12)]'
            : 'bg-white'"
    >
        <nav class="mx-auto flex h-[72px] max-w-7xl items-center justify-between gap-6 px-4 sm:px-6 lg:px-8">
            <!-- Logo -->
            <Link :href="route('home')" class="flex shrink-0 items-center gap-3" aria-label="SVS RENOV - Accueil">
                <img src="/image/logo.png" alt="SVS RENOV" class="h-12 w-12 sm:h-14 sm:w-14">
            </Link>

            <!-- Desktop navigation -->
            <div class="hidden flex-1 items-center justify-center gap-1 lg:flex">
                <Link
                    v-for="item in navigation"
                    :key="item.href"
                    :href="item.href"
                    class="relative rounded-full px-4 py-2 text-[15px] font-medium transition-colors"
                    :class="isActive(item)
                        ? 'text-primary'
                        : 'text-secondary/80 hover:bg-secondary/5 hover:text-secondary'"
                >
                    {{ item.name }}
                    <span
                        v-if="isActive(item)"
                        class="absolute bottom-0.5 left-1/2 h-1 w-1 -translate-x-1/2 rounded-full bg-primary"
                    ></span>
                </Link>
            </div>

            <!-- Desktop actions -->
            <div class="hidden items-center gap-3 lg:flex">
                <LanguageSwitcher />
                <a
                    :href="PHONE_HREF"
                    class="flex items-center gap-2 rounded-full px-3 py-2 text-sm font-semibold text-secondary transition-colors hover:text-primary xl:px-4"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span class="hidden xl:inline">{{ PHONE_LABEL }}</span>
                </a>
                <Link
                    :href="route('contact.index')"
                    class="group inline-flex items-center gap-2 rounded-full bg-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-primary/30 transition-all hover:bg-secondary"
                >
                    {{ t('nav_quote_cta') }}
                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </Link>
            </div>

            <!-- Mobile burger -->
            <button
                type="button"
                class="-mr-2 rounded-full p-2.5 text-secondary transition-colors hover:bg-secondary/5 lg:hidden"
                :aria-expanded="mobileMenuOpen"
                aria-label="Menu"
                @click="mobileMenuOpen = !mobileMenuOpen"
            >
                <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h10" />
                    <path v-else stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </nav>

        <!-- Mobile navigation -->
        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 -translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-2"
        >
            <div v-show="mobileMenuOpen" class="border-t border-gray-100 bg-white lg:hidden">
                <div class="mx-auto max-w-7xl space-y-1 px-4 pb-6 pt-3 sm:px-6">
                    <Link
                        v-for="item in navigation"
                        :key="item.href"
                        :href="item.href"
                        class="flex items-center justify-between rounded-xl px-4 py-3.5 text-lg font-semibold transition-colors"
                        :class="isActive(item) ? 'bg-primary/5 text-primary' : 'text-secondary hover:bg-gray-50'"
                    >
                        {{ item.name }}
                        <svg class="h-5 w-5 opacity-40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </Link>

                    <div class="flex items-center justify-between gap-4 px-4 pt-4">
                        <LanguageSwitcher />
                        <a :href="PHONE_HREF" class="text-sm font-semibold text-secondary">{{ PHONE_LABEL }}</a>
                    </div>
                </div>
            </div>
        </transition>
    </header>
</template>
