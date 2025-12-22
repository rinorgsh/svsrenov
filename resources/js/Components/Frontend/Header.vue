<script setup>
    import { Link } from '@inertiajs/vue3';
    import { ref, computed, onMounted, onUnmounted } from 'vue';
    import LanguageSwitcher from './LanguageSwitcher.vue';
    
    const mobileMenuOpen = ref(false);
    const isScrolled = ref(false);
    
    const navigation = computed(() => [
        { name: 'Home', href: route('home') },
        { name: 'Services', href: route('services.index') },
        { name: 'Portfolio', href: route('portfolio.index') },
        { name: 'Galerie', href: route('gallery.index') },
        { name: 'Contact', href: route('contact.index') },
    ]);
    
    const handleScroll = () => {
        isScrolled.value = window.scrollY > 50;
    };
    
    onMounted(() => {
        window.addEventListener('scroll', handleScroll);
    });
    
    onUnmounted(() => {
        window.removeEventListener('scroll', handleScroll);
    });
    </script>
    
    <template>
    <header
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        :class="isScrolled ? 'bg-white/80 backdrop-blur-md shadow-md' : 'bg-transparent'"
    >
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-28">
                <!-- Logo uniquement -->
                <Link :href="route('home')" class="flex items-center">
                    <img
                        src="/image/logo.png"
                        alt="SVS RENOV"
                        class="h-28 w-28 sm:h-32 sm:w-32 transition-all"
                    >
                </Link>
    
                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-8">
                    <Link
                        v-for="item in navigation"
                        :key="item.name"
                        :href="item.href"
                        class="text-base font-semibold transition-all duration-200 uppercase tracking-wide px-3 py-2 rounded-md hover:text-primary hover:bg-primary/10"
                        :class="$page.url === item.href ? 'text-primary border-b-2 border-primary' : isScrolled ? 'text-secondary' : 'text-white'"
                    >
                        {{ item.name }}
                    </Link>
    
                    <LanguageSwitcher :is-scrolled="isScrolled" />
                </div>
    
                <!-- Mobile menu button -->
                <div class="flex lg:hidden items-center">
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-3 rounded-md hover:text-primary focus:outline-none transition-colors"
                        :class="isScrolled ? 'text-secondary' : 'text-white'"
                    >
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
    
            <!-- Mobile Navigation -->
            <transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="transform opacity-0 -translate-y-6"
                enter-to-class="transform opacity-100 translate-y-0"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="transform opacity-100 translate-y-0"
                leave-to-class="transform opacity-0 -translate-y-6"
            >
                <div
                    v-show="mobileMenuOpen"
                    class="lg:hidden mt-2 bg-white/80 shadow-xl rounded-b-2xl backdrop-blur-md border-t border-gray-200"
                >
                    <div class="flex flex-col space-y-3 pt-6 pb-4 px-6">
                        <Link
                            v-for="(item, index) in navigation"
                            :key="item.name"
                            :href="item.href"
                            class="py-4 text-lg font-semibold text-secondary hover:text-primary hover:bg-primary/10 rounded-xl transition-all transform hover:translate-x-2 flex items-center justify-center uppercase"
                            :class="{ 'text-primary bg-primary/20': $page.url === item.href }"
                            :style="{ transitionDelay: `${index * 50}ms` }"
                            @click="mobileMenuOpen = false"
                        >
                            {{ item.name }}
                        </Link>
    
                        <!-- LanguageSwitcher visible uniquement dans le menu mobile -->
                        <div class="pt-4 flex justify-center">
                            <LanguageSwitcher />
                        </div>
                    </div>
                </div>
            </transition>
        </nav>
    </header>
    </template>
    