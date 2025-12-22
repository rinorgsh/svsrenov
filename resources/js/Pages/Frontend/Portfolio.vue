<script setup>
    import { Link } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import FrontendLayout from '@/Layouts/FrontendLayout.vue';
    import { useTranslations } from '@/Composables/useTranslations';
    import { useScrollAnimation } from '@/Composables/useScrollAnimation';

    const { t } = useTranslations();
    const { initScrollAnimation } = useScrollAnimation();
    
    defineProps({
        projects: Array,
    });
    
    const selectedProject = ref(null);
    const showModal = ref(false);
    
    const openModal = (project) => {
        selectedProject.value = project;
        showModal.value = true;
        // Prevent body scroll when modal is open
        document.body.style.overflow = 'hidden';
    };
    
    const closeModal = () => {
        showModal.value = false;
        selectedProject.value = null;
        // Restore body scroll
        document.body.style.overflow = '';
    };
    </script>
    
    <template>
        <FrontendLayout :title="t('portfolio')">
            <!-- HERO SECTION - Ultra Professional -->
            <section class="relative h-[50vh] min-h-[400px] lg:h-[60vh] lg:min-h-[500px] flex items-center overflow-hidden">
                <!-- Background Image with Parallax Effect -->
                <div class="absolute inset-0">
                    <img
                        src="/image/hero.webp"
                        alt="Portfolio SVS RENOV"
                        class="w-full h-full object-cover scale-105"
                    >
                    <!-- Sophisticated Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
                    <!-- Subtle Pattern Overlay -->
                    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M0 0h20v20H0z\' fill=\'none\'/%3E%3Cpath d=\'M10 0v20M0 10h20\' stroke=\'%23fff\' stroke-width=\'0.5\' opacity=\'0.1\'/%3E%3C/svg%3E');"></div>
                </div>
    
                <!-- Hero Content -->
                <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
                        <!-- Title Section -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="h-1 w-16 bg-primary"></div>
                                <span class="text-primary font-semibold text-sm uppercase tracking-wider">Nos Réalisations</span>
                            </div>
                            <h1 class="text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-black text-white leading-tight">
                                Portfolio<span class="text-primary">.</span>
                            </h1>
                            <p class="text-lg lg:text-xl text-white/80 max-w-xl leading-relaxed">
                                Découvrez nos transformations avant/après et la qualité de notre travail
                            </p>
                        </div>
    
                        <!-- CTA Button - Desktop -->
                        <Link
                            :href="route('contact.index')"
                            class="hidden lg:inline-flex items-center gap-3 px-10 py-5 bg-primary text-white font-bold text-lg hover:bg-opacity-90 transition-all shadow-2xl hover:shadow-primary/50 hover:scale-105 group"
                        >
                            <span>Votre projet</span>
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </Link>
                    </div>
                </div>
    
                <!-- Scroll Indicator -->
                <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 hidden lg:block">
                    <div class="flex flex-col items-center gap-2 text-white/60 animate-bounce">
                        <span class="text-xs uppercase tracking-wider">Découvrir</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </div>
                </div>
            </section>
    
            <!-- PROJECTS SECTION - Ultra Professional -->
            <section class="py-8 md:py-20 lg:py-32 bg-white">
                <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8">
                    <!-- Section Intro -->
                    <div class="text-center mb-8 md:mb-16 lg:mb-24 scroll-animate scroll-animate-fade-up">
                        <span class="text-primary font-semibold text-xs md:text-sm uppercase tracking-wider">Excellence & Qualité</span>
                        <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-secondary mt-3 md:mt-4 mb-4 md:mb-6">
                            Nos Projets Réalisés
                        </h2>
                        <div class="w-16 md:w-24 h-1 bg-primary mx-auto mb-4 md:mb-6"></div>
                        <p class="text-sm md:text-lg text-gray-600 max-w-3xl mx-auto px-2">
                            Chaque projet est une nouvelle opportunité de démontrer notre savoir-faire et notre engagement envers l'excellence
                        </p>
                    </div>

                    <!-- Projects Grid -->
                    <div v-if="projects.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-10">
                        <div
                            v-for="(project, index) in projects"
                            :key="project.id"
                            @click="openModal(project)"
                            class="group cursor-pointer scroll-animate scroll-animate-fade-up"
                            :class="{
                                'animation-delay-100': index % 3 === 0,
                                'animation-delay-200': index % 3 === 1,
                                'animation-delay-300': index % 3 === 2
                            }"
                        >
                            <!-- Project Card -->
                            <div class="bg-white rounded-lg md:rounded-2xl overflow-hidden shadow-md md:shadow-xl md:hover:shadow-3xl transition-all duration-300 md:duration-500 active:scale-95 md:hover:-translate-y-2">
                                <!-- Before/After Images -->
                                <div class="relative h-48 md:h-64 overflow-hidden">
                                    <div class="grid grid-cols-2 h-full">
                                        <!-- Before Image -->
                                        <div class="relative overflow-hidden">
                                            <img
                                                v-if="project.image_before"
                                                :src="project.image_before"
                                                :alt="t('before')"
                                                class="w-full h-full object-cover md:transform md:group-hover:scale-110 md:transition-transform md:duration-700"
                                            >
                                            <div v-else class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-400 text-xs md:text-sm">{{ t('before') }}</span>
                                            </div>
                                            <!-- Before Label -->
                                            <div class="absolute bottom-2 md:bottom-3 left-2 md:left-3 bg-black/80 backdrop-blur-sm text-white px-2 md:px-3 py-1 md:py-1.5 rounded-full text-[10px] md:text-xs font-bold uppercase">
                                                Avant
                                            </div>
                                        </div>

                                        <!-- After Image -->
                                        <div class="relative overflow-hidden">
                                            <img
                                                v-if="project.image_after"
                                                :src="project.image_after"
                                                :alt="t('after')"
                                                class="w-full h-full object-cover md:transform md:group-hover:scale-110 md:transition-transform md:duration-700"
                                            >
                                            <div v-else class="w-full h-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-gray-500 text-xs md:text-sm">{{ t('after') }}</span>
                                            </div>
                                            <!-- After Label -->
                                            <div class="absolute bottom-2 md:bottom-3 right-2 md:right-3 bg-primary text-white px-2 md:px-3 py-1 md:py-1.5 rounded-full text-[10px] md:text-xs font-bold uppercase">
                                                Après
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Divider Line -->
                                    <div class="absolute inset-y-0 left-1/2 w-0.5 bg-white/50 transform -translate-x-1/2"></div>

                                    <!-- Hover Overlay - Hidden on mobile -->
                                    <div class="hidden md:flex absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 items-end justify-center pb-6">
                                        <div class="text-white font-bold flex items-center gap-2">
                                            <span>Voir le projet</span>
                                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Project Info -->
                                <div class="p-3 md:p-6 space-y-2 md:space-y-3">
                                    <!-- Title -->
                                    <h3 class="text-base md:text-xl font-bold text-secondary md:group-hover:text-primary transition-colors line-clamp-2">
                                        {{ project.title }}
                                    </h3>

                                    <!-- Service Badge(s) -->
                                    <div v-if="project.services && project.services.length > 0" class="flex flex-wrap gap-2">
                                        <div v-for="(service, idx) in project.services" :key="idx" class="inline-flex items-center gap-1.5 md:gap-2 px-2 md:px-3 py-1 md:py-1.5 bg-primary/10 rounded-full">
                                            <div class="w-1.5 h-1.5 md:w-2 md:h-2 bg-primary rounded-full"></div>
                                            <span class="text-xs md:text-sm font-semibold text-primary">
                                                {{ service }}
                                            </span>
                                        </div>
                                    </div>
                                    <div v-else-if="project.service" class="inline-flex items-center gap-1.5 md:gap-2 px-2 md:px-3 py-1 md:py-1.5 bg-primary/10 rounded-full">
                                        <div class="w-1.5 h-1.5 md:w-2 md:h-2 bg-primary rounded-full"></div>
                                        <span class="text-xs md:text-sm font-semibold text-primary">
                                            {{ project.service.title }}
                                        </span>
                                    </div>

                                    <!-- Location -->
                                    <p v-if="project.location" class="text-xs md:text-sm text-gray-600 flex items-center gap-1 md:gap-2">
                                        <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ project.location }}
                                    </p>

                                    <!-- Description - Hidden on mobile -->
                                    <p v-if="project.description" class="hidden md:block text-gray-600 text-sm leading-relaxed line-clamp-2">
                                        {{ project.description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Empty State -->
                    <div v-else class="text-center py-20">
                        <div class="max-w-md mx-auto space-y-6">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-secondary">
                                Aucun projet disponible
                            </h3>
                            <p class="text-gray-600">
                                Nos réalisations seront bientôt disponibles ici.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
    
            <!-- CTA SECTION -->
            <section class="py-20 lg:py-32 bg-gradient-to-br from-gray-50 to-white relative overflow-hidden">
                <!-- Decorative Background Elements -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute top-0 left-0 w-96 h-96 bg-primary rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 right-0 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
                </div>
    
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center space-y-8">
                        <div class="space-y-4">
                            <span class="text-primary font-semibold text-sm uppercase tracking-wider">Votre Projet</span>
                            <h2 class="text-4xl lg:text-5xl xl:text-6xl font-black text-secondary leading-tight">
                                Donnez vie à<br>
                                <span class="text-primary">votre façade</span>
                            </h2>
                            <p class="text-lg lg:text-xl text-gray-600 max-w-2xl mx-auto">
                                Transformez votre bâtiment avec notre expertise reconnue. Demandez votre devis gratuit dès aujourd'hui.
                            </p>
                        </div>
    
                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-4">
                            <a
                                href="tel:+3228871021"
                                class="inline-flex items-center gap-3 px-10 py-5 bg-primary text-white font-bold text-lg hover:bg-opacity-90 transition-all shadow-2xl hover:shadow-primary/50 hover:scale-105 group"
                            >
                                <svg class="w-6 h-6 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>02 887 10 21</span>
                            </a>
    
                            <Link
                                :href="route('contact.index')"
                                class="inline-flex items-center gap-3 px-10 py-5 bg-secondary text-white font-bold text-lg hover:bg-opacity-90 transition-all shadow-2xl hover:scale-105 group"
                            >
                                <span>Demander un devis</span>
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
    
            <!-- ENHANCED MODAL - Optimized for Mobile -->
            <teleport to="body">
                <Transition
                    enter-active-class="transition duration-300 ease-out"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="transition duration-200 ease-in"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div
                        v-if="showModal && selectedProject"
                        @click="closeModal"
                        class="fixed inset-0 bg-black/90 backdrop-blur-sm z-50 overflow-y-auto"
                    >
                        <div class="min-h-screen flex items-start md:items-center justify-center p-0 md:p-4">
                            <Transition
                                enter-active-class="transition duration-300 ease-out"
                                enter-from-class="opacity-0 translate-y-4 md:scale-95"
                                enter-to-class="opacity-100 translate-y-0 md:scale-100"
                                leave-active-class="transition duration-200 ease-in"
                                leave-from-class="opacity-100 translate-y-0 md:scale-100"
                                leave-to-class="opacity-0 translate-y-4 md:scale-95"
                            >
                                <div
                                    @click.stop
                                    class="bg-white w-full md:max-w-4xl md:rounded-2xl overflow-hidden shadow-2xl relative"
                                >
                                    <!-- Close Button - Fixed on mobile -->
                                    <button
                                        @click="closeModal"
                                        class="fixed md:absolute top-4 right-4 z-20 w-10 h-10 flex items-center justify-center rounded-full bg-black/80 md:bg-white/90 backdrop-blur-sm hover:bg-black md:hover:bg-gray-100 transition-colors group"
                                    >
                                        <svg class="w-6 h-6 text-white md:text-gray-600 group-hover:text-white md:group-hover:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>

                                    <!-- Modal Header -->
                                    <div class="bg-gradient-to-r from-primary to-secondary text-white px-4 md:px-8 py-6 md:py-8">
                                        <h2 class="text-xl md:text-3xl font-bold mb-3 pr-10">
                                            {{ selectedProject.title }}
                                        </h2>
                                        <div class="flex flex-wrap items-center gap-2 md:gap-3">
                                            <template v-if="selectedProject.services && selectedProject.services.length > 0">
                                                <span v-for="(service, idx) in selectedProject.services" :key="idx" class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full text-xs md:text-sm font-semibold">
                                                    {{ service }}
                                                </span>
                                            </template>
                                            <span v-else-if="selectedProject.service" class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full text-xs md:text-sm font-semibold">
                                                {{ selectedProject.service.title }}
                                            </span>
                                            <span v-if="selectedProject.location" class="text-white/90 text-xs md:text-sm flex items-center gap-1">
                                                <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ selectedProject.location }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Modal Content -->
                                    <div class="p-4 md:p-8 space-y-4 md:space-y-6">
                                        <!-- Before/After Images - Vertical on mobile, Side-by-side on desktop -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                            <!-- Before Image -->
                                            <div class="space-y-2 md:space-y-3">
                                                <div class="flex items-center justify-between">
                                                    <p class="text-xs md:text-sm font-bold text-gray-500 uppercase tracking-wider">Avant</p>
                                                    <span class="px-2 md:px-3 py-1 bg-gray-100 rounded-full text-xs font-semibold text-gray-600">État initial</span>
                                                </div>
                                                <div class="rounded-lg md:rounded-2xl overflow-hidden shadow-lg h-auto md:h-[500px]">
                                                    <img
                                                        v-if="selectedProject.image_before"
                                                        :src="selectedProject.image_before"
                                                        :alt="t('before')"
                                                        class="w-full h-full object-cover"
                                                    >
                                                </div>
                                            </div>

                                            <!-- After Image -->
                                            <div class="space-y-2 md:space-y-3">
                                                <div class="flex items-center justify-between">
                                                    <p class="text-xs md:text-sm font-bold text-primary uppercase tracking-wider">Après</p>
                                                    <span class="px-2 md:px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-semibold">Résultat final</span>
                                                </div>
                                                <div class="rounded-lg md:rounded-2xl overflow-hidden shadow-lg ring-1 md:ring-2 ring-primary/20 h-auto md:h-[500px]">
                                                    <img
                                                        v-if="selectedProject.image_after"
                                                        :src="selectedProject.image_after"
                                                        :alt="t('after')"
                                                        class="w-full h-full object-cover"
                                                    >
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Project Description -->
                                        <div v-if="selectedProject.description" class="bg-gray-50 rounded-lg md:rounded-2xl p-4 md:p-6">
                                            <h3 class="text-sm md:text-lg font-bold text-secondary mb-3 md:mb-4 flex items-center gap-2">
                                                <svg class="w-4 h-4 md:w-5 md:h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Détails du projet
                                            </h3>
                                            <p class="text-gray-700 leading-relaxed text-sm md:text-base">
                                                {{ selectedProject.description }}
                                            </p>
                                        </div>

                                        <!-- CTA in Modal -->
                                        <div class="bg-gradient-to-r from-primary to-secondary text-white rounded-lg md:rounded-2xl p-4 md:p-6">
                                            <div class="text-center space-y-4">
                                                <div>
                                                    <h4 class="text-lg md:text-xl font-bold mb-2">
                                                        Un projet similaire ?
                                                    </h4>
                                                    <p class="text-white/90 text-sm md:text-base">
                                                        Contactez-nous pour un devis gratuit
                                                    </p>
                                                </div>
                                                <Link
                                                    :href="route('contact.index')"
                                                    class="inline-flex items-center gap-2 px-6 md:px-8 py-3 md:py-4 bg-white text-primary font-bold text-sm md:text-base rounded-lg hover:bg-gray-100 transition-all shadow-xl active:scale-95 md:hover:scale-105"
                                                >
                                                    <span>Nous contacter</span>
                                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                                    </svg>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </Transition>
                        </div>
                    </div>
                </Transition>
            </teleport>
        </FrontendLayout>
    </template>
    
    <style scoped>
    /* Enhanced shadow for ultra-professional look */
    .shadow-3xl {
        box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
    }
    
    /* Line clamp utilities */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Smooth transitions */
    * {
        transition-property: transform, box-shadow, background-color, opacity;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Backdrop blur support */
    @supports (backdrop-filter: blur(10px)) {
        .backdrop-blur-sm {
            backdrop-filter: blur(10px);
        }
    }
    </style>