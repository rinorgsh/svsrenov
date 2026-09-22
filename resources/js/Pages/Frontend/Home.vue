<script setup>
    import { Link } from '@inertiajs/vue3';
    import { ref, computed, onMounted, onUnmounted } from 'vue';
    import FrontendLayout from '@/Layouts/FrontendLayout.vue';
    import GoogleReviewsCarousel from '@/Components/Frontend/GoogleReviewsCarousel.vue';
    import BeforeAfterSlider from '@/Components/Frontend/BeforeAfterSlider.vue';
    import PostCard from '@/Components/Frontend/PostCard.vue';
    import { useTranslations } from '@/Composables/useTranslations';
    import { useScrollAnimation } from '@/Composables/useScrollAnimation';

    const { t } = useTranslations();
    const { initScrollAnimation } = useScrollAnimation();
    
    const props = defineProps({
        services: Array,
        featuredProjects: Array,
        testimonials: Array,
        hero: Object,
        googleReviews: Array,
        googleReviewStats: Object,
        heroProjects: { type: Array, default: () => [] },
        latestPosts: { type: Array, default: () => [] },
        googleReviewsUrl: String,
    });

    // Diaporama avant/après du hero : change tout seul toutes les HERO_INTERVAL ms,
    // se met en pause au survol et quelques secondes après une manipulation
    const HERO_INTERVAL = 6000;
    const HERO_RESUME_DELAY = 8000;
    const heroIndex = ref(0);
    const heroCycle = ref(0); // relance la barre de progression
    const heroHovered = ref(false);
    const heroInteracting = ref(false);
    let heroResumeTimer = null;

    const currentHeroProject = computed(() => props.heroProjects[heroIndex.value] ?? props.heroProjects[0]);
    const heroPaused = computed(() => heroHovered.value || heroInteracting.value);

    const goToHero = (i) => {
        heroIndex.value = (i + props.heroProjects.length) % props.heroProjects.length;
        heroCycle.value++;
    };
    const nextHero = () => goToHero(heroIndex.value + 1);

    const onHeroInteract = () => {
        heroInteracting.value = true;
        clearTimeout(heroResumeTimer);
        heroResumeTimer = setTimeout(() => {
            heroInteracting.value = false;
        }, HERO_RESUME_DELAY);
    };

    onUnmounted(() => clearTimeout(heroResumeTimer));

    const formattedRating = computed(() =>
        (props.googleReviewStats?.average_rating ?? 0).toFixed(1).replace('.', ',')
    );
    
    // Accordion state
    const activeAccordion = ref(null);
    
    // Services Carousel
    const servicesCarousel = ref(null);
    const currentServiceIndex = ref(0);
    const isDragging = ref(false);
    const startX = ref(0);
    const scrollLeft = ref(0);

    // Projects Infinite Carousel
    const projectsCarousel = ref(null);
    const isDraggingProject = ref(false);
    const startXProject = ref(0);
    const scrollLeftProject = ref(0);
    const animationSpeed = ref(1); // pixels par frame (augmenté pour mobile)
    const animationId = ref(null);
    const isPaused = ref(false);

    const scrollCarousel = (direction) => {
        if (!servicesCarousel.value) return;
    
        // Sur desktop, scroll d'une card à la fois (450px + 24px gap)
        // Sur mobile, scroll de toute la largeur
        const cardWidth = 474; // 450px card + 24px gap
        const scrollAmount = window.innerWidth < 768
            ? servicesCarousel.value.offsetWidth
            : cardWidth;
    
        const newScrollLeft = direction === 'next'
            ? servicesCarousel.value.scrollLeft + scrollAmount
            : servicesCarousel.value.scrollLeft - scrollAmount;
    
        servicesCarousel.value.scrollTo({
            left: newScrollLeft,
            behavior: 'smooth'
        });
    };
    
    const scrollToService = (index) => {
        if (!servicesCarousel.value) return;
    
        const cardWidth = 474;
        const scrollAmount = window.innerWidth < 768
            ? servicesCarousel.value.offsetWidth * index
            : cardWidth * index;
    
        servicesCarousel.value.scrollTo({
            left: scrollAmount,
            behavior: 'smooth'
        });
    };
    
    const updateCurrentServiceIndex = () => {
        if (!servicesCarousel.value) return;
    
        const scrollLeft = servicesCarousel.value.scrollLeft;
        const cardWidth = window.innerWidth < 768
            ? servicesCarousel.value.offsetWidth
            : 474;
    
        currentServiceIndex.value = Math.round(scrollLeft / cardWidth);
    };
    
    // Mouse drag functionality for desktop
    const handleMouseDown = (e) => {
        if (!servicesCarousel.value) return;
        isDragging.value = true;
        startX.value = e.pageX - servicesCarousel.value.offsetLeft;
        scrollLeft.value = servicesCarousel.value.scrollLeft;
        servicesCarousel.value.style.cursor = 'grabbing';
    };
    
    const handleMouseUp = () => {
        isDragging.value = false;
        if (servicesCarousel.value) {
            servicesCarousel.value.style.cursor = 'grab';
        }
    };
    
    const handleMouseMove = (e) => {
        if (!isDragging.value || !servicesCarousel.value) return;
        e.preventDefault();
        const x = e.pageX - servicesCarousel.value.offsetLeft;
        const walk = (x - startX.value) * 2; // Scroll speed multiplier
        servicesCarousel.value.scrollLeft = scrollLeft.value - walk;
    };
    
    const handleMouseLeave = () => {
        if (isDragging.value) {
            isDragging.value = false;
            if (servicesCarousel.value) {
                servicesCarousel.value.style.cursor = 'grab';
            }
        }
    };
    
    // Infinite Carousel Animation
    const animateCarousel = () => {
        if (!projectsCarousel.value) {
            animationId.value = requestAnimationFrame(animateCarousel);
            return;
        }

        // Sur mobile, ne pas mettre en pause (isPaused ne fonctionne pas bien sur tactile)
        const isMobile = window.innerWidth < 1024;
        if (!isMobile && (isPaused.value || isDraggingProject.value)) {
            animationId.value = requestAnimationFrame(animateCarousel);
            return;
        }

        // Déplacer vers la droite
        projectsCarousel.value.scrollLeft += animationSpeed.value;

        // Vérifier si on a scrollé au-delà de la moitié (les originaux)
        const maxScroll = projectsCarousel.value.scrollWidth / 2;
        if (projectsCarousel.value.scrollLeft >= maxScroll) {
            // Revenir au début sans animation visible (boucle infinie)
            projectsCarousel.value.scrollLeft = 0;
        }

        animationId.value = requestAnimationFrame(animateCarousel);
    };

    const startCarousel = () => {
        if (!animationId.value) {
            animationId.value = requestAnimationFrame(animateCarousel);
        }
    };

    const stopCarousel = () => {
        if (animationId.value) {
            cancelAnimationFrame(animationId.value);
            animationId.value = null;
        }
    };

    // Mouse drag for projects
    const handleProjectMouseDown = (e) => {
        if (!projectsCarousel.value) return;
        isDraggingProject.value = true;
        startXProject.value = e.pageX - projectsCarousel.value.offsetLeft;
        scrollLeftProject.value = projectsCarousel.value.scrollLeft;
        projectsCarousel.value.style.cursor = 'grabbing';
    };

    const handleProjectMouseUp = () => {
        isDraggingProject.value = false;
        if (projectsCarousel.value) {
            projectsCarousel.value.style.cursor = 'grab';
        }
    };

    const handleProjectMouseMove = (e) => {
        if (!isDraggingProject.value || !projectsCarousel.value) return;
        e.preventDefault();
        const x = e.pageX - projectsCarousel.value.offsetLeft;
        const walk = (x - startXProject.value) * 1.5;
        projectsCarousel.value.scrollLeft = scrollLeftProject.value - walk;
    };

    const handleProjectMouseLeave = () => {
        if (isDraggingProject.value) {
            isDraggingProject.value = false;
            if (projectsCarousel.value) {
                projectsCarousel.value.style.cursor = 'grab';
            }
        }
        // Reprendre l'animation quand la souris sort
        isPaused.value = false;
    };

    const handleProjectsMouseEnter = () => {
        isPaused.value = true;
    };

    onMounted(() => {
        if (servicesCarousel.value) {
            servicesCarousel.value.addEventListener('scroll', updateCurrentServiceIndex);
            servicesCarousel.value.style.cursor = 'grab';
        }
        if (projectsCarousel.value) {
            projectsCarousel.value.style.cursor = 'grab';
            // Démarrer le carousel infini après un court délai
            setTimeout(() => {
                startCarousel();
            }, 500);
        }
        // Relancer l'animation quand la page redevient visible (mobile)
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden && projectsCarousel.value && !animationId.value) {
                startCarousel();
            }
        });
    });

    onUnmounted(() => {
        if (servicesCarousel.value) {
            servicesCarousel.value.removeEventListener('scroll', updateCurrentServiceIndex);
        }
        stopCarousel();
    });

    </script>
    
    <template>
        <FrontendLayout :title="t('hero_heading_1') + ' ' + t('hero_heading_2')" :description="t('hero_lead')">
            <!-- HERO : texte à gauche, avant/après interactif à droite -->
            <section class="relative overflow-hidden bg-white pt-[72px]">

                <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 pb-16 pt-10 sm:px-6 md:pt-16 lg:grid-cols-12 lg:gap-10 lg:px-8 lg:pb-24 lg:pt-20">
                    <!-- Texte -->
                    <div class="lg:col-span-6">
                        <div class="animate-fade-in-up inline-flex flex-wrap items-center gap-x-3 gap-y-1 rounded-full bg-white px-4 py-2 text-sm shadow-sm ring-1 ring-black/5">
                            <template v-if="googleReviewStats?.total_count">
                                <span class="flex items-center gap-1 font-bold text-secondary">
                                    <svg class="h-4 w-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    {{ formattedRating }}
                                </span>
                                <span class="text-gray-500">Google</span>
                                <span class="hidden h-1 w-1 rounded-full bg-gray-300 sm:block"></span>
                            </template>
                            <span class="text-gray-600">{{ t('hero_badge_zone') }}</span>
                        </div>

                        <h1 class="animate-fade-in-up mt-6 text-[2.75rem] font-extrabold leading-[0.95] text-secondary sm:text-6xl xl:text-[4.75rem]">
                            {{ t('hero_heading_1') }}<br>
                            <span class="relative inline-block text-primary">
                                {{ t('hero_heading_2') }}
                                <svg class="absolute -bottom-2 left-0 h-3 w-full text-primary/30" viewBox="0 0 200 12" preserveAspectRatio="none" aria-hidden="true">
                                    <path d="M2 9c40-6 110-8 196-3" fill="none" stroke="currentColor" stroke-width="5" stroke-linecap="round" />
                                </svg>
                            </span>
                        </h1>

                        <p class="animate-fade-in-up animation-delay-200 mt-8 max-w-xl text-lg leading-relaxed text-gray-600">
                            {{ t('hero_lead') }}
                        </p>

                        <div class="animate-fade-in-up animation-delay-200 mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                            <Link
                                :href="route('contact.index')"
                                class="group inline-flex items-center justify-center gap-2 rounded-full bg-primary px-7 py-4 text-base font-semibold text-white shadow-lg shadow-primary/25 transition-all hover:-translate-y-0.5 hover:bg-secondary"
                            >
                                {{ t('home_hero_btn_quote') }}
                                <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </Link>
                            <a
                                href="tel:+32472640679"
                                class="inline-flex items-center justify-center gap-3 rounded-full px-5 py-4 font-semibold text-secondary transition-colors hover:text-primary"
                            >
                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-sm ring-1 ring-black/5">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </span>
                                0472 64 06 79
                            </a>
                        </div>

                        <!-- Chiffres clés -->
                        <dl class="mt-12 grid max-w-lg grid-cols-3 divide-x divide-black/10 border-t border-black/10 pt-6">
                            <div class="pr-4">
                                <dt class="sr-only">{{ t('hero_stat_years') }}</dt>
                                <dd class="font-display text-2xl font-extrabold text-secondary sm:text-3xl">15+</dd>
                                <dd class="mt-1 text-xs leading-snug text-gray-500 sm:text-sm">{{ t('hero_stat_years') }}</dd>
                            </div>
                            <div v-if="googleReviewStats?.total_count" class="px-4">
                                <dt class="sr-only">{{ t('hero_stat_rating') }}</dt>
                                <dd class="font-display text-2xl font-extrabold text-secondary sm:text-3xl">{{ formattedRating }}<span class="text-amber-400">★</span></dd>
                                <dd class="mt-1 text-xs leading-snug text-gray-500 sm:text-sm">{{ t('hero_stat_rating') }}</dd>
                            </div>
                            <div class="pl-4">
                                <dt class="sr-only">{{ t('hero_stat_quote') }}</dt>
                                <dd class="font-display text-2xl font-extrabold text-secondary sm:text-3xl">{{ t('hero_stat_quote_value') }}</dd>
                                <dd class="mt-1 text-xs leading-snug text-gray-500 sm:text-sm">{{ t('hero_stat_quote') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Visuel -->
                    <div class="relative lg:col-span-6">
                        <div class="animate-fade-in-up animation-delay-200 relative">
                            <div
                                v-if="heroProjects.length"
                                class="relative isolate aspect-[4/5] w-full overflow-hidden rounded-[2rem] bg-gray-200 shadow-2xl shadow-black/20 sm:aspect-[5/4] lg:aspect-[4/5] xl:aspect-square"
                                @mouseenter="heroHovered = true"
                                @mouseleave="heroHovered = false"
                            >
                                <!-- Diapos empilées, fondu entre elles -->
                                <BeforeAfterSlider
                                    v-for="(project, i) in heroProjects"
                                    :key="project.id"
                                    :before="project.image_before"
                                    :after="project.image_after"
                                    :before-label="t('before')"
                                    :after-label="t('after')"
                                    :alt="project.title"
                                    :active="i === heroIndex"
                                    :eager="i <= 1"
                                    hint
                                    class="!absolute inset-0 transition-opacity duration-700 ease-out"
                                    :class="i === heroIndex ? 'z-10 opacity-100' : 'pointer-events-none z-0 opacity-0'"
                                    :aria-hidden="i !== heroIndex"
                                    @interact="onHeroInteract"
                                />

                                <!-- Légende + progression -->
                                <div class="pointer-events-none absolute inset-x-0 bottom-0 z-20 bg-gradient-to-t from-black/70 to-transparent p-6 pt-20 text-right">
                                    <div :key="currentHeroProject.id" class="hero-caption">
                                        <p class="text-sm font-semibold text-white">{{ currentHeroProject.title }}</p>
                                        <p class="text-xs text-white/70">{{ currentHeroProject.location }} · {{ t('hero_drag_hint') }}</p>
                                    </div>

                                    <div v-if="heroProjects.length > 1" class="pointer-events-auto mt-4 flex justify-end gap-1.5">
                                        <button
                                            v-for="(project, i) in heroProjects"
                                            :key="project.id"
                                            type="button"
                                            class="relative h-1.5 overflow-hidden rounded-full bg-white/35 transition-all duration-300"
                                            :class="i === heroIndex ? 'w-10' : 'w-4 hover:bg-white/60'"
                                            :aria-label="project.title"
                                            :aria-current="i === heroIndex"
                                            @click="goToHero(i)"
                                        >
                                            <span
                                                v-if="i === heroIndex"
                                                :key="`progress-${heroCycle}`"
                                                class="hero-progress absolute inset-y-0 left-0 rounded-full bg-white"
                                                :style="{ animationDuration: `${HERO_INTERVAL}ms`, animationPlayState: heroPaused ? 'paused' : 'running' }"
                                                @animationend="nextHero"
                                            ></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <img
                                v-else
                                :src="hero?.image_url || '/image/hero.webp'"
                                alt="SVS RENOV - Façade"
                                class="aspect-[4/5] w-full rounded-[2rem] object-cover shadow-2xl shadow-black/20 sm:aspect-[5/4] lg:aspect-[4/5] xl:aspect-[5/4]"
                            >

                            <!-- Carte avis flottante -->
                            <div
                                v-if="googleReviews?.length"
                                class="absolute -bottom-6 -left-2 z-30 hidden max-w-[260px] rounded-2xl bg-white p-4 shadow-xl ring-1 ring-black/5 sm:block lg:-left-10"
                            >
                                <div class="mb-1 flex text-amber-400">
                                    <svg v-for="i in 5" :key="i" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                                <p class="line-clamp-2 text-sm leading-snug text-gray-700">“{{ googleReviews[0].comment }}”</p>
                                <p class="mt-2 text-xs font-semibold text-secondary">{{ googleReviews[0].author_name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    
            <!-- À PROPOS / QUI SOMMES-NOUS SECTION -->
            <section class="py-12 md:py-20 lg:py-28 bg-gradient-to-b from-white to-gray-100 overflow-hidden w-full">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid lg:grid-cols-2 gap-6 md:gap-12 lg:gap-16 items-center">
                        <!-- Left: Content -->
                        <div class="space-y-4 md:space-y-8 scroll-animate scroll-animate-fade-right">
                            <!-- Title -->
                            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold leading-tight">
                                <span class="text-primary block">{{ t('home_about_title_1') }}</span>
                                <span class="text-secondary"> {{ t('home_about_title_2') }}</span><span class="text-primary">.</span>
                            </h2>

                            <!-- Description Paragraphs -->
                            <div class="space-y-4 md:space-y-5 text-gray-700 text-base md:text-lg leading-relaxed">
                                <p class="relative pl-4 border-l-4 border-primary/30" v-html="t('home_about_desc_1')">
                                </p>
                                <p>
                                    {{ t('home_about_desc_2') }}
                                </p>
                            </div>
                        </div>

                        <!-- Right: Image with Yellow Band -->
                        <div class="relative mt-8 lg:mt-0">
                            <!-- Yellow Band Background -->
                            <div class="hidden lg:block absolute -right-4 lg:-right-12 top-0 bottom-0 w-1/3 bg-gradient-to-br from-primary to-primary/80 rounded-2xl -z-10"></div>

                            <!-- Image Container -->
                            <div class="relative rounded-2xl overflow-hidden shadow-soft-lg transform hover:scale-[1.02] transition-transform duration-500">
                                <img
                                    src="/image/camionette.jpeg"
                                    alt="Échafaudage et rénovation de façade"
                                    class="w-full h-[300px] md:h-[400px] lg:h-[500px] object-cover"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    
            <!-- NOS SERVICES SECTION - Carousel Élégant -->
            <section class="py-12 md:py-20 lg:py-24 bg-gradient-to-b from-gray-100 to-gray-50 overflow-hidden w-full">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Section Header -->
                    <div class="text-center mb-8 md:mb-16 scroll-animate scroll-animate-fade-up">
                        <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-secondary mb-3 md:mb-4">
                            {{ t('home_services_title') }}
                        </h2>
                        <div class="w-20 md:w-24 h-1 bg-gradient-to-r from-primary/50 via-primary to-primary/50 mx-auto mb-4 md:mb-6 rounded-full"></div>
                        <p class="text-base md:text-xl text-gray-600 max-w-3xl mx-auto px-4">
                            {{ t('home_services_subtitle') }}
                        </p>
                    </div>
    
                    <!-- Services Carousel -->
                    <div class="relative pb-8 md:pb-16">
                        <!-- Carousel Container -->
                        <div
                            ref="servicesCarousel"
                            class="flex gap-4 md:gap-6 overflow-x-auto scrollbar-hide snap-x snap-mandatory select-none py-2 md:py-4"
                            style="scroll-behavior: smooth; -webkit-overflow-scrolling: touch; scroll-snap-type: x mandatory;"
                            @mousedown="handleMouseDown"
                            @mouseup="handleMouseUp"
                            @mousemove="handleMouseMove"
                            @mouseleave="handleMouseLeave"
                        >
                            <div
                                v-for="(service, index) in services"
                                :key="service.id"
                                class="flex-none w-[85vw] sm:w-[70vw] md:w-[450px] snap-center group"
                            >
                                <Link
                                    :href="route('services.show', service.slug)"
                                    class="block relative h-[420px] sm:h-[450px] md:h-[450px] rounded-2xl md:rounded-3xl overflow-hidden shadow-soft hover:shadow-soft-lg transition-all duration-500 active:scale-95 md:hover:scale-[1.02]"
                                    @click.prevent="!isDragging && $inertia.visit(route('services.show', service.slug))"
                                >
                                    <!-- Background Image -->
                                    <img
                                        :src="service.image || '/image/hero.webp'"
                                        :alt="service.title"
                                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 pointer-events-none"
                                        draggable="false"
                                    >
    
                                    <!-- Gradient Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
    
                                    <!-- Number Badge -->
                                    <div class="absolute top-4 right-4 md:top-6 md:right-6 w-12 h-12 md:w-16 md:h-16 bg-primary rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                        <span class="text-xl md:text-2xl font-black text-white">{{ index + 1 }}</span>
                                    </div>
    
                                    <!-- Content -->
                                    <div class="absolute inset-0 flex flex-col justify-end p-5 sm:p-8 md:p-10 pointer-events-none">
                                        <!-- Title -->
                                        <h3 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-3 md:mb-4 transform group-hover:translate-y-[-4px] transition-transform">
                                            {{ service.title }}
                                        </h3>

                                        <!-- Description -->
                                        <p class="text-white/90 text-sm sm:text-base md:text-lg leading-relaxed mb-4 md:mb-6 line-clamp-2 md:line-clamp-3">
                                            {{ service.description }}
                                        </p>

                                        <!-- CTA Button -->
                                        <div class="flex items-center text-white font-bold text-base md:text-lg group-hover:gap-3 transition-all">
                                            <span>{{ t('home_discover_service') }}</span>
                                            <svg class="w-5 h-5 md:w-6 md:h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </Link>
                            </div>
                        </div>
    
                        <!-- Navigation Buttons - Desktop (côtés) -->
                        <div class="hidden md:block">
                            <!-- Prev Button -->
                            <button
                                @click="scrollCarousel('prev')"
                                class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 lg:-translate-x-6 w-16 h-16 rounded-full bg-white border-2 border-primary text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-all shadow-soft-lg hover:scale-110 z-10 group"
                                aria-label="Service précédent"
                            >
                                <svg class="w-7 h-7 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
    
                            <!-- Next Button -->
                            <button
                                @click="scrollCarousel('next')"
                                class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 lg:translate-x-6 w-16 h-16 rounded-full bg-primary text-white flex items-center justify-center hover:bg-secondary transition-all shadow-soft-lg hover:scale-110 z-10 group"
                                aria-label="Service suivant"
                            >
                                <svg class="w-7 h-7 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
    
                        <!-- Navigation Buttons - Mobile (bas) -->
                        <div class="flex md:hidden justify-center gap-4 mt-8">
                            <button
                                @click="scrollCarousel('prev')"
                                class="w-14 h-14 rounded-full bg-white border-2 border-primary text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-all shadow-lg active:scale-95"
                                aria-label="Service précédent"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button
                                @click="scrollCarousel('next')"
                                class="w-14 h-14 rounded-full bg-primary text-white flex items-center justify-center hover:bg-secondary transition-all shadow-lg active:scale-95"
                                aria-label="Service suivant"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
    
                    </div>
                </div>
            </section>
    
            <!-- PORTFOLIO SECTION -->
            <section v-if="featuredProjects.length > 0" class="py-12 md:py-20 lg:py-24 bg-gradient-to-b from-gray-50 to-gray-100 overflow-hidden w-full">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Section Header -->
                    <div class="text-center mb-8 md:mb-16 scroll-animate scroll-animate-fade-up">
                        <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-secondary mb-3 md:mb-4">
                            {{ t('home_portfolio_title') }}
                        </h2>
                        <div class="w-16 md:w-24 h-1 bg-gradient-to-r from-primary/50 via-primary to-primary/50 mx-auto mb-3 md:mb-6 rounded-full"></div>
                        <p class="text-sm md:text-xl text-gray-600 max-w-3xl mx-auto px-4">
                            {{ t('home_portfolio_subtitle') }}
                        </p>
                    </div>

                    <!-- Infinite Carousel Container -->
                    <div class="relative pb-8 md:pb-16">
                        <div
                            ref="projectsCarousel"
                            class="flex gap-4 md:gap-6 overflow-x-auto scrollbar-hide select-none cursor-grab py-2 md:py-4"
                            style="-webkit-overflow-scrolling: touch;"
                            @mousedown="handleProjectMouseDown"
                            @mouseup="handleProjectMouseUp"
                            @mousemove="handleProjectMouseMove"
                            @mouseleave="handleProjectMouseLeave"
                            @mouseenter="handleProjectsMouseEnter"
                        >
                            <!-- Première série de projets -->
                            <div
                                v-for="project in featuredProjects"
                                :key="`original-${project.id}`"
                                class="flex-none w-[300px] md:w-[380px] group"
                            >
                                <div class="bg-white rounded-3xl overflow-hidden shadow-soft hover:shadow-soft-lg transition-all duration-500 hover:-translate-y-3 h-full">
                                    <!-- Images Comparison -->
                                    <div class="grid grid-cols-2 gap-0 relative">
                                        <div class="relative overflow-hidden">
                                            <img
                                                v-if="project.image_before"
                                                :src="project.image_before"
                                                :alt="t('before')"
                                                class="w-full h-44 md:h-48 object-cover pointer-events-none group-hover:scale-110 transition-transform duration-700"
                                                draggable="false"
                                            >
                                            <div v-else class="w-full h-44 md:h-48 bg-gray-200"></div>
                                            <div class="absolute inset-0 bg-gradient-to-br from-black/40 to-transparent"></div>
                                            <div class="absolute top-2 left-2 bg-black/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                                AVANT
                                            </div>
                                        </div>
                                        <div class="relative overflow-hidden">
                                            <img
                                                v-if="project.image_after"
                                                :src="project.image_after"
                                                :alt="t('after')"
                                                class="w-full h-44 md:h-48 object-cover pointer-events-none group-hover:scale-110 transition-transform duration-700"
                                                draggable="false"
                                            >
                                            <div v-else class="w-full h-44 md:h-48 bg-gray-300"></div>
                                            <div class="absolute inset-0 bg-gradient-to-bl from-primary/20 to-transparent"></div>
                                            <div class="absolute top-2 right-2 bg-primary backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                                APRÈS
                                            </div>
                                        </div>
                                        <!-- Séparateur central -->
                                        <div class="absolute left-1/2 top-0 bottom-0 w-1 bg-white/50 transform -translate-x-1/2"></div>
                                    </div>

                                    <!-- Project Info -->
                                    <div class="p-5 md:p-6">
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-lg md:text-xl font-bold text-secondary mb-1 line-clamp-1">
                                                    {{ project.title }}
                                                </h3>
                                                <div v-if="project.services && project.services.length > 0" class="flex flex-wrap gap-1">
                                                    <span v-for="(service, idx) in project.services.slice(0, 2)" :key="idx" class="text-primary font-semibold text-xs md:text-sm">
                                                        {{ service }}<span v-if="idx < Math.min(project.services.length, 2) - 1">,</span>
                                                    </span>
                                                    <span v-if="project.services.length > 2" class="text-primary font-semibold text-xs md:text-sm">...</span>
                                                </div>
                                                <p v-else-if="project.service" class="text-primary font-semibold text-xs md:text-sm">
                                                    {{ project.service.title }}
                                                </p>
                                            </div>
                                        </div>
                                        <p v-if="project.description" class="text-gray-600 text-sm leading-relaxed line-clamp-2">
                                            {{ project.description }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Duplication pour boucle infinie -->
                            <div
                                v-for="project in featuredProjects"
                                :key="`duplicate-${project.id}`"
                                class="flex-none w-[300px] md:w-[380px] group"
                            >
                                <div class="bg-white rounded-3xl overflow-hidden shadow-soft hover:shadow-soft-lg transition-all duration-500 hover:-translate-y-3 h-full">
                                    <!-- Images Comparison -->
                                    <div class="grid grid-cols-2 gap-0 relative">
                                        <div class="relative overflow-hidden">
                                            <img
                                                v-if="project.image_before"
                                                :src="project.image_before"
                                                :alt="t('before')"
                                                class="w-full h-44 md:h-48 object-cover pointer-events-none group-hover:scale-110 transition-transform duration-700"
                                                draggable="false"
                                            >
                                            <div v-else class="w-full h-44 md:h-48 bg-gray-200"></div>
                                            <div class="absolute inset-0 bg-gradient-to-br from-black/40 to-transparent"></div>
                                            <div class="absolute top-2 left-2 bg-black/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                                AVANT
                                            </div>
                                        </div>
                                        <div class="relative overflow-hidden">
                                            <img
                                                v-if="project.image_after"
                                                :src="project.image_after"
                                                :alt="t('after')"
                                                class="w-full h-44 md:h-48 object-cover pointer-events-none group-hover:scale-110 transition-transform duration-700"
                                                draggable="false"
                                            >
                                            <div v-else class="w-full h-44 md:h-48 bg-gray-300"></div>
                                            <div class="absolute inset-0 bg-gradient-to-bl from-primary/20 to-transparent"></div>
                                            <div class="absolute top-2 right-2 bg-primary backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                                                APRÈS
                                            </div>
                                        </div>
                                        <!-- Séparateur central -->
                                        <div class="absolute left-1/2 top-0 bottom-0 w-1 bg-white/50 transform -translate-x-1/2"></div>
                                    </div>

                                    <!-- Project Info -->
                                    <div class="p-5 md:p-6">
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-lg md:text-xl font-bold text-secondary mb-1 line-clamp-1">
                                                    {{ project.title }}
                                                </h3>
                                                <div v-if="project.services && project.services.length > 0" class="flex flex-wrap gap-1">
                                                    <span v-for="(service, idx) in project.services.slice(0, 2)" :key="idx" class="text-primary font-semibold text-xs md:text-sm">
                                                        {{ service }}<span v-if="idx < Math.min(project.services.length, 2) - 1">,</span>
                                                    </span>
                                                    <span v-if="project.services.length > 2" class="text-primary font-semibold text-xs md:text-sm">...</span>
                                                </div>
                                                <p v-else-if="project.service" class="text-primary font-semibold text-xs md:text-sm">
                                                    {{ project.service.title }}
                                                </p>
                                            </div>
                                        </div>
                                        <p v-if="project.description" class="text-gray-600 text-sm leading-relaxed line-clamp-2">
                                            {{ project.description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- View All Button -->
                    <div class="text-center mt-8 md:mt-12">
                        <Link
                            :href="route('portfolio.index')"
                            class="group inline-flex items-center justify-center px-8 md:px-10 py-4 md:py-5 bg-primary text-white font-bold text-base md:text-lg rounded-xl hover:bg-primary/90 transition-all shadow-soft-lg hover:scale-105 hover:-translate-y-1"
                        >
                            <span>{{ t('home_view_all_projects') }}</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </Link>
                    </div>
                </div>
            </section>
    
            <!-- DES PROFESSIONNELS À VOTRE SERVICE SECTION -->
            <section class="py-12 md:py-20 lg:py-24 bg-gray-100 overflow-hidden w-full">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Section Title -->
                    <div class="text-center mb-16 scroll-animate scroll-animate-fade-up">
                        <h2 class="text-4xl md:text-5xl font-bold">
                            <span class="text-primary">{{ t('home_professionals_title_1') + " " }}</span>  
                            <span class="text-secondary"> {{ t('home_professionals_title_2') }}</span><span class="text-primary">.</span>
                        </h2>
                    </div>

                    <!-- Content Grid -->
                    <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-start">
                        <!-- Left: Image -->
                        <div class="order-2 lg:order-1">
                            <div class="rounded-2xl overflow-hidden shadow-soft-lg">
                                <img
                                    src="/image/echa.png"
                                    alt="Professionnels SVS RENOV - Camionnette"
                                    class="w-full h-[500px] object-cover"
                                >
                            </div>
                        </div>

                        <!-- Right: Accordion Items -->
                        <div class="order-1 lg:order-2 bg-primary p-8 lg:p-12 rounded-2xl flex flex-col justify-center">
                            <div class="space-y-6">
                                <!-- Accordion Item 1 -->
                                <div class="border-b-2 border-white/20 pb-6">
                                    <button
                                        @click="activeAccordion = activeAccordion === 1 ? null : 1"
                                        class="w-full text-center"
                                    >
                                        <h3 class="text-2xl lg:text-3xl font-bold transition-all duration-300 text-white uppercase" :class="activeAccordion === 1 ? 'scale-105' : ''">
                                            {{ t('home_professionals_experience_title') }}
                                        </h3>
                                    </button>
                                    <div class="overflow-hidden transition-all duration-500 ease-in-out" :style="{ maxHeight: activeAccordion === 1 ? '150px' : '0px' }">
                                        <p class="mt-3 text-white text-sm lg:text-base leading-relaxed bg-white/10 p-4 rounded-lg text-center">
                                            {{ t('home_professionals_experience_desc') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Accordion Item 2 -->
                                <div class="border-b-2 border-white/20 pb-6">
                                    <button
                                        @click="activeAccordion = activeAccordion === 2 ? null : 2"
                                        class="w-full text-center"
                                    >
                                        <h3 class="text-2xl lg:text-3xl font-bold transition-all duration-300 text-white uppercase" :class="activeAccordion === 2 ? 'scale-105' : ''">
                                            {{ t('home_professionals_quality_title') }}
                                        </h3>
                                    </button>
                                    <div class="overflow-hidden transition-all duration-500 ease-in-out" :style="{ maxHeight: activeAccordion === 2 ? '150px' : '0px' }">
                                        <p class="mt-3 text-white text-sm lg:text-base leading-relaxed bg-white/10 p-4 rounded-lg text-center">
                                            {{ t('home_professionals_quality_desc') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Accordion Item 3 -->
                                <div class="border-b-2 border-white/20 pb-6">
                                    <button
                                        @click="activeAccordion = activeAccordion === 3 ? null : 3"
                                        class="w-full text-center"
                                    >
                                        <h3 class="text-2xl lg:text-3xl font-bold transition-all duration-300 text-white uppercase" :class="activeAccordion === 3 ? 'scale-105' : ''">
                                            {{ t('home_professionals_work_title') }}
                                        </h3>
                                    </button>
                                    <div class="overflow-hidden transition-all duration-500 ease-in-out" :style="{ maxHeight: activeAccordion === 3 ? '150px' : '0px' }">
                                        <p class="mt-3 text-white text-sm lg:text-base leading-relaxed bg-white/10 p-4 rounded-lg text-center">
                                            {{ t('home_professionals_work_desc') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Accordion Item 4 -->
                                <div class="border-b-2 border-white/20 pb-6">
                                    <button
                                        @click="activeAccordion = activeAccordion === 4 ? null : 4"
                                        class="w-full text-center"
                                    >
                                        <h3 class="text-2xl lg:text-3xl font-bold transition-all duration-300 text-white uppercase" :class="activeAccordion === 4 ? 'scale-105' : ''">
                                            {{ t('home_professionals_materials_title') }}
                                        </h3>
                                    </button>
                                    <div class="overflow-hidden transition-all duration-500 ease-in-out" :style="{ maxHeight: activeAccordion === 4 ? '150px' : '0px' }">
                                        <p class="mt-3 text-white text-sm lg:text-base leading-relaxed bg-white/10 p-4 rounded-lg text-center">
                                            {{ t('home_professionals_materials_desc') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Accordion Item 5 -->
                                <div class="pb-6">
                                    <button
                                        @click="activeAccordion = activeAccordion === 5 ? null : 5"
                                        class="w-full text-center"
                                    >
                                        <h3 class="text-2xl lg:text-3xl font-bold transition-all duration-300 text-white uppercase" :class="activeAccordion === 5 ? 'scale-105' : ''">
                                            {{ t('home_professionals_tech_title') }}
                                        </h3>
                                    </button>
                                    <div class="overflow-hidden transition-all duration-500 ease-in-out" :style="{ maxHeight: activeAccordion === 5 ? '150px' : '0px' }">
                                        <p class="mt-3 text-white text-sm lg:text-base leading-relaxed bg-white/10 p-4 rounded-lg text-center">
                                            {{ t('home_professionals_tech_desc') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    
            <!-- AVIS CLIENTS SECTION (Google Reviews) -->
            <GoogleReviewsCarousel :reviews="googleReviews" :stats="googleReviewStats" :profile-url="googleReviewsUrl" />

            <!-- DERNIERS ARTICLES DU BLOG -->
            <section v-if="latestPosts.length" class="bg-white py-20 md:py-28">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-10 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                        <div>
                            <span class="mb-3 block text-sm font-bold uppercase tracking-[0.2em] text-primary">{{ t('blog_eyebrow') }}</span>
                            <h2 class="text-3xl font-extrabold text-secondary sm:text-4xl md:text-5xl">{{ t('home_blog_title') }}</h2>
                        </div>
                        <Link :href="route('blog.index')" class="inline-flex items-center gap-2 font-semibold text-secondary transition-all hover:gap-3 hover:text-primary">
                            {{ t('home_blog_link') }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </Link>
                    </div>
                    <div class="grid gap-8 md:grid-cols-3">
                        <PostCard v-for="post in latestPosts" :key="post.id" :post="post" />
                    </div>
                </div>
            </section>


            <!-- PRÊT À DISCUTER SECTION -->
            <section class="py-12 md:py-20 lg:py-24 bg-gray-100 overflow-hidden w-full">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                        <!-- Left: Content -->
                        <div class="space-y-6">
                            <!-- Title -->
                            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                                <span class="text-primary">{{ t('home_cta_title_1') }}</span><br>
                                <span class="text-secondary">{{ t('home_cta_title_2') }} </span><span class="text-primary">?</span>
                            </h2>

                            <!-- Description -->
                            <div class="space-y-4 text-gray-700 text-base lg:text-lg leading-relaxed">
                                <p>
                                    {{ t('home_cta_desc_1') }}
                                </p>
                                <p>
                                    {{ t('home_cta_desc_2') }}
                                </p>
                            </div>
                        </div>

                        <!-- Right: CTA Box -->
                        <div class="bg-white p-8 lg:p-12 rounded-2xl shadow-2xl">
                            <div class="space-y-8">
                                <!-- Title -->
                                <h3 class="text-2xl lg:text-3xl font-bold text-secondary leading-tight">
                                    {{ t('home_cta_form_title') }}<br>
                                    {{ t('home_cta_form_subtitle') }} <span class="text-primary">{{ t('home_cta_form_quote') }}</span>
                                </h3>

                                <!-- CTA Buttons -->
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <a
                                        href="tel:+32472640679"
                                        class="inline-flex items-center justify-center px-8 py-4 bg-primary text-white font-bold text-lg hover:bg-opacity-90 transition-all shadow-lg hover:scale-105"
                                    >
                                        0472 64 06 79
                                    </a>
                                    <Link
                                        :href="route('contact.index')"
                                        class="inline-flex items-center justify-center px-8 py-4 bg-secondary text-white font-bold text-lg hover:bg-opacity-90 transition-all shadow-lg hover:scale-105 uppercase"
                                    >
                                        {{ t('home_cta_online') }}
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </FrontendLayout>
    </template>
    
    <style scoped>
    /* Hide scrollbar but keep functionality */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* Animations élégantes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes subtleZoom {
        0%, 100% {
            transform: scale(1.05);
        }
        50% {
            transform: scale(1.08);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 1s ease-out forwards;
    }

    .animation-delay-200 {
        animation-delay: 0.2s;
        opacity: 0;
    }

    .animate-subtle-zoom {
        animation: subtleZoom 20s ease-in-out infinite;
    }

    /* Line clamp utilities */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Enhanced soft shadows - Natural and professional */
    .shadow-soft {
        box-shadow:
            0 2px 4px rgba(0, 0, 0, 0.04),
            0 4px 8px rgba(0, 0, 0, 0.06),
            0 8px 16px rgba(0, 0, 0, 0.08);
    }

    .shadow-soft-lg {
        box-shadow:
            0 4px 6px rgba(0, 0, 0, 0.05),
            0 10px 20px rgba(0, 0, 0, 0.08),
            0 20px 40px rgba(0, 0, 0, 0.10);
    }

    .shadow-3xl {
        box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.4);
    }

    /* Smooth transitions */
    * {
        -webkit-tap-highlight-color: transparent;
    }

    /* Mobile optimizations */
    @media (max-width: 768px) {
        /* Amélioration des zones tactiles */
        button, a {
            min-height: 44px;
            min-width: 44px;
        }

        /* Meilleure lisibilité sur mobile */
        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    }
    
    .hero-progress {
        width: 0;
        animation-name: heroProgress;
        animation-timing-function: linear;
        animation-fill-mode: forwards;
    }

    .hero-caption {
        animation: heroCaption 0.5s ease-out both;
    }

    @keyframes heroCaption {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: none; }
    }

    @keyframes heroProgress {
        from { width: 0; }
        to { width: 100%; }
    }

    @media (prefers-reduced-motion: reduce) {
        .hero-progress {
            animation: none;
            width: 100%;
        }
    }
</style>