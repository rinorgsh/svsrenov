<script setup>
    import { ref } from 'vue';
    import { useTranslations } from '@/Composables/useTranslations';

    const { t } = useTranslations();

    const props = defineProps({
        reviews: Array,
        stats: Object,
    });

    // Carousel state
    const carousel = ref(null);
    const isDragging = ref(false);
    const startX = ref(0);
    const scrollLeftPos = ref(0);

    // Expanded reviews (read more/less)
    const expandedReviews = ref({});

    const toggleExpand = (id) => {
        expandedReviews.value[id] = !expandedReviews.value[id];
    };

    const scrollCarousel = (direction) => {
        if (!carousel.value) return;

        const cardWidth = 404; // 380px card + 24px gap
        const scrollAmount = window.innerWidth < 768
            ? carousel.value.offsetWidth
            : cardWidth;

        const newScrollLeft = direction === 'next'
            ? carousel.value.scrollLeft + scrollAmount
            : carousel.value.scrollLeft - scrollAmount;

        carousel.value.scrollTo({
            left: newScrollLeft,
            behavior: 'smooth'
        });
    };

    // Drag handlers
    const handleMouseDown = (e) => {
        if (!carousel.value) return;
        isDragging.value = true;
        startX.value = e.pageX - carousel.value.offsetLeft;
        scrollLeftPos.value = carousel.value.scrollLeft;
        carousel.value.style.cursor = 'grabbing';
    };

    const handleMouseUp = () => {
        isDragging.value = false;
        if (carousel.value) {
            carousel.value.style.cursor = 'grab';
        }
    };

    const handleMouseMove = (e) => {
        if (!isDragging.value || !carousel.value) return;
        e.preventDefault();
        const x = e.pageX - carousel.value.offsetLeft;
        const walk = (x - startX.value) * 2;
        carousel.value.scrollLeft = scrollLeftPos.value - walk;
    };

    const handleMouseLeave = () => {
        if (isDragging.value) {
            isDragging.value = false;
            if (carousel.value) {
                carousel.value.style.cursor = 'grab';
            }
        }
    };

    const getInitials = (name) => {
        if (!name) return '?';
        return name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
    };
</script>

<template>
    <section class="py-16 md:py-20 lg:py-24 bg-gradient-to-b from-gray-100 to-gray-50 overflow-hidden w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-12 md:mb-16 scroll-animate scroll-animate-fade-up">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-secondary mb-4">
                    {{ t('home_testimonials_title') }}
                </h2>
                <div class="w-20 md:w-24 h-1 bg-gradient-to-r from-primary/50 via-primary to-primary/50 mx-auto mb-4 md:mb-6 rounded-full"></div>
                <p class="text-base md:text-xl text-gray-600 max-w-3xl mx-auto px-4">
                    {{ t('home_testimonials_subtitle') }}
                </p>

                <!-- Google Badge -->
                <div v-if="stats && stats.total_count > 0" class="flex items-center justify-center gap-3 mt-6">
                    <div class="flex items-center gap-2 bg-white px-4 py-2.5 rounded-full shadow-md">
                        <!-- Google G Logo -->
                        <svg class="w-6 h-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>

                        <!-- Stars -->
                        <div class="flex items-center gap-0.5">
                            <template v-for="i in 5" :key="i">
                                <svg
                                    class="w-4 h-4"
                                    :class="i <= Math.round(stats.average_rating) ? 'text-yellow-400' : 'text-gray-300'"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </template>
                        </div>

                        <span class="text-sm text-gray-600 font-medium">
                            {{ stats.average_rating.toFixed(1) }}
                        </span>
                        <span class="text-xs text-gray-400">|</span>
                        <span class="text-sm text-gray-500">
                            {{ t('home_google_reviews_based_on') }} {{ stats.total_count }} {{ t('home_google_reviews_reviews') }} {{ t('home_google_reviews_on_google') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Reviews Carousel -->
            <div v-if="reviews && reviews.length > 0" class="relative">
                <!-- Navigation Buttons -->
                <button
                    @click="scrollCarousel('prev')"
                    class="hidden md:flex absolute -left-4 lg:-left-6 top-1/2 -translate-y-1/2 z-10 w-12 h-12 items-center justify-center rounded-full bg-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110 group"
                >
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <button
                    @click="scrollCarousel('next')"
                    class="hidden md:flex absolute -right-4 lg:-right-6 top-1/2 -translate-y-1/2 z-10 w-12 h-12 items-center justify-center rounded-full bg-white shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110 group"
                >
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <!-- Carousel Container -->
                <div
                    ref="carousel"
                    class="flex gap-6 overflow-x-auto scrollbar-hide snap-x snap-mandatory pb-4"
                    style="cursor: grab; -webkit-overflow-scrolling: touch;"
                    @mousedown="handleMouseDown"
                    @mouseup="handleMouseUp"
                    @mousemove="handleMouseMove"
                    @mouseleave="handleMouseLeave"
                >
                    <div
                        v-for="review in reviews"
                        :key="review.id"
                        class="flex-shrink-0 w-[85vw] md:w-[380px] snap-start"
                    >
                        <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
                            <!-- Author Info -->
                            <div class="flex items-center gap-3 mb-4">
                                <!-- Photo or Initials -->
                                <div class="w-11 h-11 rounded-full overflow-hidden flex-shrink-0 bg-primary/10 flex items-center justify-center">
                                    <img
                                        v-if="review.author_photo_url"
                                        :src="review.author_photo_url"
                                        :alt="review.author_name"
                                        class="w-full h-full object-cover"
                                        @error="$event.target.style.display='none'; $event.target.nextElementSibling.style.display='flex'"
                                    >
                                    <span
                                        :style="review.author_photo_url ? 'display:none' : ''"
                                        class="text-sm font-bold text-primary items-center justify-center w-full h-full flex"
                                    >
                                        {{ getInitials(review.author_name) }}
                                    </span>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-secondary text-sm truncate">{{ review.author_name }}</h4>
                                    <p v-if="review.relative_time" class="text-xs text-gray-400">{{ review.relative_time }}</p>
                                </div>

                                <!-- Google Icon -->
                                <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                </svg>
                            </div>

                            <!-- Stars -->
                            <div class="flex items-center gap-0.5 mb-3">
                                <template v-for="i in 5" :key="i">
                                    <svg
                                        class="w-4 h-4"
                                        :class="i <= review.rating ? 'text-yellow-400' : 'text-gray-300'"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </template>
                            </div>

                            <!-- Comment -->
                            <div class="flex-1">
                                <template v-if="review.comment">
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        <template v-if="review.comment.length > 200 && !expandedReviews[review.id]">
                                            {{ review.comment.slice(0, 200) }}...
                                            <button
                                                @click.stop="toggleExpand(review.id)"
                                                class="text-primary font-medium hover:underline ml-1"
                                            >
                                                {{ t('home_google_reviews_read_more') }}
                                            </button>
                                        </template>
                                        <template v-else-if="review.comment.length > 200">
                                            {{ review.comment }}
                                            <button
                                                @click.stop="toggleExpand(review.id)"
                                                class="text-primary font-medium hover:underline ml-1"
                                            >
                                                {{ t('home_google_reviews_read_less') }}
                                            </button>
                                        </template>
                                        <template v-else>
                                            {{ review.comment }}
                                        </template>
                                    </p>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-12">
                <p class="text-gray-500 text-lg">{{ t('home_google_reviews_no_reviews') }}</p>
            </div>

            <!-- Footer -->
            <p class="text-center text-sm text-gray-500 mt-6">
                {{ t('home_google_reviews_footer') }}
            </p>
        </div>
    </section>
</template>

<style scoped>
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>
