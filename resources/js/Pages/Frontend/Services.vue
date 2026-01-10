<script setup>
    import { Link } from '@inertiajs/vue3';
    import FrontendLayout from '@/Layouts/FrontendLayout.vue';
    import { useTranslations } from '@/Composables/useTranslations';
    import { useScrollAnimation } from '@/Composables/useScrollAnimation';

    const { t } = useTranslations();
    const { initScrollAnimation } = useScrollAnimation();

    defineProps({
        services: Array,
        hero: Object,
    });
    </script>
    
    <template>
        <FrontendLayout :title="t('services')">
            <!-- HERO SECTION - Ultra Professional -->
            <section class="relative h-[50vh] min-h-[400px] lg:h-[60vh] lg:min-h-[500px] flex items-center overflow-hidden">
                <!-- Background Image with Parallax Effect -->
                <div class="absolute inset-0">
                    <img
                        :src="hero?.image_url || '/image/hero.webp'"
                        alt="Services SVS RENOV"
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
                                <span class="text-primary font-semibold text-sm uppercase tracking-wider">{{ t('services_our_expertises') }}</span>
                            </div>
                            <h1 class="text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-black text-white leading-tight">
                                {{ t('services') }}<span class="text-primary">.</span>
                            </h1>
                            <p class="text-lg lg:text-xl text-white/80 max-w-xl leading-relaxed">
                                {{ t('services_hero_description') }}
                            </p>
                        </div>
    
                        <!-- CTA Button - Desktop -->
                        <Link
                            :href="route('contact.index')"
                            class="hidden lg:inline-flex items-center gap-3 px-10 py-5 bg-primary text-white font-bold text-lg hover:bg-opacity-90 transition-all shadow-2xl hover:shadow-primary/50 hover:scale-105 group"
                        >
                            <span>{{ t('services_request_quote') }}</span>
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </Link>
                    </div>
                </div>
    
                <!-- Scroll Indicator -->
                <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 hidden lg:block">
                    <div class="flex flex-col items-center gap-2 text-white/60 animate-bounce">
                        <span class="text-xs uppercase tracking-wider">{{ t('services_discover') }}</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </div>
                </div>
            </section>
    
            <!-- SERVICES LIST SECTION - Ultra Professional with Mobile Optimization -->
            <section class="py-16 md:py-20 lg:py-32 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Section Intro -->
                    <div class="text-center mb-16 lg:mb-24 scroll-animate scroll-animate-fade-up">
                        <span class="text-primary font-semibold text-sm uppercase tracking-wider">{{ t('services_excellence_expertise') }}</span>
                        <h2 class="text-3xl lg:text-4xl font-bold text-secondary mt-4 mb-6">
                            {{ t('services_specialized_title') }}
                        </h2>
                        <div class="w-24 h-1 bg-primary mx-auto"></div>
                    </div>
    
                    <div class="space-y-16 md:space-y-24 lg:space-y-32">
                        <!-- Service Item -->
                        <div
                            v-for="(service, index) in services"
                            :key="service.id"
                            class="group scroll-animate"
                            :class="index % 2 === 0 ? 'scroll-animate-fade-right' : 'scroll-animate-fade-left'"
                        >
                            <!-- Desktop Layout (>= lg) -->
                            <div class="hidden lg:grid lg:grid-cols-12 gap-12 items-center">
                                <!-- Image Column -->
                                <div
                                    class="relative"
                                    :class="index % 2 === 0 ? 'lg:col-span-7 order-1' : 'lg:col-span-7 order-2'"
                                >
                                    <!-- Decorative Number -->
                                    <div
                                        class="absolute -top-8 z-10 text-[120px] font-black opacity-5"
                                        :class="index % 2 === 0 ? '-left-8 text-primary' : '-right-8 text-secondary'"
                                    >
                                        {{ String(index + 1).padStart(2, '0') }}
                                    </div>

                                    <!-- Image Container -->
                                    <div class="relative rounded-3xl overflow-hidden shadow-2xl group-hover:shadow-3xl transition-all duration-500">
                                        <img
                                            :src="service.image || '/image/hero.webp'"
                                            :alt="service.title"
                                            class="w-full h-[450px] object-cover transform group-hover:scale-110 transition-transform duration-700"
                                        >
                                        <!-- Subtle Gradient Overlay -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>

                                        <!-- Number Badge -->
                                        <div class="absolute bottom-6 left-6">
                                            <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center shadow-2xl">
                                                <span class="text-2xl font-black text-white">{{ String(index + 1).padStart(2, '0') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Decorative Element -->
                                    <div
                                        class="absolute -bottom-6 w-32 h-32 bg-primary/10 rounded-full blur-3xl transform group-hover:scale-150 transition-transform duration-500"
                                        :class="index % 2 === 0 ? '-right-6' : '-left-6'"
                                    ></div>
                                </div>

                                <!-- Content Column -->
                                <div
                                    class="space-y-6"
                                    :class="index % 2 === 0 ? 'lg:col-span-5 order-2' : 'lg:col-span-5 order-1'"
                                >
                                    <!-- Title -->
                                    <h3 class="text-4xl xl:text-5xl font-black text-secondary leading-tight group-hover:text-primary transition-colors">
                                        {{ service.title }}
                                    </h3>

                                    <!-- Divider -->
                                    <div class="w-16 h-1 bg-primary"></div>

                                    <!-- Short Description -->
                                    <p class="text-gray-700 text-lg xl:text-xl leading-relaxed font-medium">
                                        {{ service.description }}
                                    </p>

                                    <!-- Long Description - Directly Visible -->
                                    <div v-if="service.long_description" class="bg-gray-50 rounded-2xl p-6 border-l-4 border-primary">
                                        <p class="text-gray-600 leading-relaxed">
                                            {{ service.long_description }}
                                        </p>
                                    </div>

                                    <!-- Features List -->
                                    <div class="flex flex-wrap gap-2 pt-2">
                                        <span class="px-4 py-2 bg-primary/10 text-primary text-sm font-semibold rounded-full">
                                            {{ t('services_certified_expertise') }}
                                        </span>
                                        <span class="px-4 py-2 bg-secondary/10 text-secondary text-sm font-semibold rounded-full">
                                            {{ t('services_free_quote') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile/Tablet Optimized Layout (< lg) - ALTERNATING -->
                            <div class="lg:hidden">
                                <div class="bg-white rounded-2xl overflow-hidden shadow-xl">
                                    <!-- Alternating Layout -->
                                    <div :class="index % 2 === 0 ? '' : 'flex flex-col'">
                                        <!-- Image -->
                                        <div class="relative h-56 overflow-hidden">
                                            <img
                                                :src="service.image || '/image/hero.webp'"
                                                :alt="service.title"
                                                class="w-full h-full object-cover"
                                            >
                                            <!-- Gradient Overlay -->
                                            <div
                                                class="absolute inset-0"
                                                :class="index % 2 === 0 ? 'bg-gradient-to-t from-primary/90 via-primary/60 to-transparent' : 'bg-gradient-to-t from-secondary/90 via-secondary/60 to-transparent'"
                                            ></div>

                                            <!-- Number Badge -->
                                            <div class="absolute top-4 right-4 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg">
                                                <span class="text-lg font-black text-primary">{{ String(index + 1).padStart(2, '0') }}</span>
                                            </div>

                                            <!-- Title on Image -->
                                            <div class="absolute bottom-0 left-0 right-0 p-5">
                                                <h3 class="text-xl font-black text-white leading-tight">
                                                    {{ service.title }}
                                                </h3>
                                            </div>
                                        </div>

                                        <!-- Content with Colored Background -->
                                        <div
                                            class="p-5 space-y-4"
                                            :class="index % 2 === 0 ? 'bg-gradient-to-br from-primary/5 to-white' : 'bg-gradient-to-br from-secondary/5 to-white'"
                                        >
                                            <!-- Short Description -->
                                            <p class="text-gray-700 leading-relaxed font-medium">
                                                {{ service.description }}
                                            </p>

                                            <!-- Long Description -->
                                            <div v-if="service.long_description" class="bg-white rounded-xl p-4 border-l-4 border-primary shadow-sm">
                                                <p class="text-gray-600 text-sm leading-relaxed">
                                                    {{ service.long_description }}
                                                </p>
                                            </div>

                                            <!-- Tags -->
                                            <div class="flex flex-wrap gap-2 pt-2">
                                                <span class="px-3 py-1.5 bg-primary/10 text-primary text-xs font-semibold rounded-full">
                                                    {{ t('services_certified_expertise') }}
                                                </span>
                                                <span class="px-3 py-1.5 bg-secondary/10 text-secondary text-xs font-semibold rounded-full">
                                                    {{ t('services_free_quote') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Separator Line (not for last item) -->
                            <div
                                v-if="index < services.length - 1"
                                class="hidden lg:block mt-16 lg:mt-32"
                            >
                                <div class="relative">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t-2 border-gray-100"></div>
                                    </div>
                                    <div class="relative flex justify-center">
                                        <span class="px-6 bg-white text-gray-400 text-sm">
                                            ◆
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    
            <!-- CTA SECTION - Enhanced -->
            <section class="py-20 lg:py-32 bg-gradient-to-br from-gray-50 to-white relative overflow-hidden">
                <!-- Decorative Background Elements -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute top-0 left-0 w-96 h-96 bg-primary rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 right-0 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
                </div>
    
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                        <!-- Left: Content -->
                        <div class="space-y-6 scroll-animate scroll-animate-fade-right">
                            <div class="flex items-center gap-4">
                                <div class="h-1 w-16 bg-primary"></div>
                                <span class="text-primary font-semibold text-sm uppercase tracking-wider">{{ t('services_contact_us_label') }}</span>
                            </div>

                            <h2 class="text-4xl lg:text-5xl xl:text-6xl font-black text-secondary leading-tight">
                                {{ t('services_cta_project_title') }}<br>
                                <span class="text-primary">{{ t('services_cta_project_subtitle') }}</span>
                            </h2>

                            <p class="text-gray-700 text-lg lg:text-xl leading-relaxed">
                                {{ t('services_cta_team_desc') }}
                            </p>


                        </div>

                        <!-- Right: CTA Card -->
                        <div class="bg-white rounded-3xl shadow-2xl p-8 lg:p-10 space-y-6 scroll-animate scroll-animate-fade-left animation-delay-200">
                            <h3 class="text-2xl font-bold text-secondary">
                                {{ t('services_cta_quote_title') }}
                            </h3>
                            
                            <div class="space-y-4">
                                <a
                                    href="tel:+32472640679"
                                    class="flex items-center justify-center gap-3 w-full px-8 py-5 bg-primary text-white font-bold text-lg hover:bg-opacity-90 transition-all shadow-lg hover:shadow-xl hover:scale-105 group"
                                >
                                    <svg class="w-6 h-6 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span>0472 64 06 79</span>
                                </a>
    
                                <div class="relative">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t border-gray-200"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                                        <span class="px-4 bg-white text-gray-500">ou</span>
                                    </div>
                                </div>
    
                                <Link
                                    :href="route('contact.index')"
                                    class="flex items-center justify-center gap-3 w-full px-8 py-5 bg-secondary text-white font-bold text-lg hover:bg-opacity-90 transition-all shadow-lg hover:shadow-xl hover:scale-105 group"
                                >
                                    <span>Formulaire en ligne</span>
                                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </Link>
                            </div>
    
                            <!-- Additional Info -->
                            <div class="pt-4 border-t border-gray-100">
                                <p class="text-sm text-gray-600 text-center">
                                    ⚡ Réponse sous 24h • 📋 Devis détaillé gratuit
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    
            <!-- NOTRE APPROCHE SECTION - Enhanced -->
            <section class="py-20 lg:py-32 bg-secondary text-white relative overflow-hidden">
                <!-- Decorative Elements -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute top-1/4 left-0 w-96 h-96 bg-primary rounded-full blur-3xl"></div>
                    <div class="absolute bottom-1/4 right-0 w-96 h-96 bg-primary rounded-full blur-3xl"></div>
                </div>
    
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Header -->
                    <div class="text-center mb-16 lg:mb-24 scroll-animate scroll-animate-fade-up">
                        <span class="text-primary font-semibold text-sm uppercase tracking-wider">Méthodologie</span>
                        <h2 class="text-4xl lg:text-5xl font-black mt-4 mb-6">
                            Notre <span class="text-primary">Approche</span>
                        </h2>
                        <div class="w-24 h-1 bg-primary mx-auto mb-6"></div>
                        <p class="text-xl text-white/80 max-w-3xl mx-auto">
                            Un processus rigoureux et éprouvé pour des résultats garantis
                        </p>
                    </div>
    
                    <!-- Steps Grid -->
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                        <!-- Step 1 -->
                        <div class="relative group scroll-animate scroll-animate-fade-up animation-delay-100">
                            <!-- Connecting Line (desktop) -->
                            <div class="hidden lg:block absolute top-10 left-1/2 w-full h-0.5 bg-primary/30 -z-10"></div>

                            <div class="text-center">
                                <div class="relative inline-block mb-6">
                                    <!-- Number Circle -->
                                    <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform duration-300">
                                        <span class="text-3xl font-black text-white">1</span>
                                    </div>
                                    <!-- Pulse Effect -->
                                    <div class="absolute inset-0 w-20 h-20 bg-primary rounded-full animate-ping opacity-20"></div>
                                </div>
                                <h3 class="text-xl lg:text-2xl font-bold mb-3">Diagnostic</h3>
                                <p class="text-white/70 leading-relaxed">
                                    Évaluation complète et détaillée de l'état de votre façade
                                </p>
                            </div>
                        </div>
    
                        <!-- Step 2 -->
                        <div class="relative group scroll-animate scroll-animate-fade-up animation-delay-200">
                            <div class="hidden lg:block absolute top-10 left-1/2 w-full h-0.5 bg-primary/30 -z-10"></div>

                            <div class="text-center">
                                <div class="relative inline-block mb-6">
                                    <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform duration-300">
                                        <span class="text-3xl font-black text-white">2</span>
                                    </div>
                                    <div class="absolute inset-0 w-20 h-20 bg-primary rounded-full animate-ping opacity-20"></div>
                                </div>
                                <h3 class="text-xl lg:text-2xl font-bold mb-3">Devis Détaillé</h3>
                                <p class="text-white/70 leading-relaxed">
                                    Proposition personnalisée, transparente et sans surprise
                                </p>
                            </div>
                        </div>
    
                        <!-- Step 3 -->
                        <div class="relative group scroll-animate scroll-animate-fade-up animation-delay-300">
                            <div class="hidden lg:block absolute top-10 left-1/2 w-full h-0.5 bg-primary/30 -z-10"></div>

                            <div class="text-center">
                                <div class="relative inline-block mb-6">
                                    <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform duration-300">
                                        <span class="text-3xl font-black text-white">3</span>
                                    </div>
                                    <div class="absolute inset-0 w-20 h-20 bg-primary rounded-full animate-ping opacity-20"></div>
                                </div>
                                <h3 class="text-xl lg:text-2xl font-bold mb-3">Réalisation</h3>
                                <p class="text-white/70 leading-relaxed">
                                    Travaux réalisés par des professionnels qualifiés et expérimentés
                                </p>
                            </div>
                        </div>
    
                        <!-- Step 4 -->
                        <div class="relative group scroll-animate scroll-animate-fade-up animation-delay-400">
                            <div class="text-center">
                                <div class="relative inline-block mb-6">
                                    <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform duration-300">
                                        <span class="text-3xl font-black text-white">4</span>
                                    </div>
                                    <div class="absolute inset-0 w-20 h-20 bg-primary rounded-full animate-ping opacity-20"></div>
                                </div>
                                <h3 class="text-xl lg:text-2xl font-bold mb-3">Suivi</h3>
                                <p class="text-white/70 leading-relaxed">
                                    Garantie et conseils d'entretien personnalisés sur le long terme
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </FrontendLayout>
    </template>
    
    <style scoped>
    /* Enhanced shadow for ultra-professional look */
    .shadow-3xl {
        box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
    }
    
    /* Smooth transitions for all interactive elements */
    * {
        transition-property: transform, box-shadow, background-color, opacity;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Pulse animation for step numbers */
    @keyframes ping {
        75%, 100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }
    
    .animate-ping {
        animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
    </style>