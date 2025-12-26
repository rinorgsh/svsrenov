<script setup>
import { ref, computed } from 'vue';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array,
    hero: Object,
});

const selectedCategory = ref(null);
const lightboxOpen = ref(false);
const lightboxItem = ref(null);

const filteredGalleries = computed(() => {
    if (!selectedCategory.value) {
        return props.categories.flatMap(cat =>
            cat.published_galleries.map(gallery => ({
                ...gallery,
                category: cat
            }))
        );
    }

    const category = props.categories.find(cat => cat.id === selectedCategory.value);
    return category ? category.published_galleries.map(gallery => ({
        ...gallery,
        category
    })) : [];
});

const openLightbox = (item) => {
    lightboxItem.value = item;
    lightboxOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const closeLightbox = () => {
    lightboxOpen.value = false;
    lightboxItem.value = null;
    document.body.style.overflow = '';
};

const getVideoEmbedUrl = (url) => {
    if (!url) return null;

    if (url.includes('youtube.com') || url.includes('youtu.be')) {
        let videoId = null;

        // YouTube Shorts format: https://youtube.com/shorts/VIDEO_ID
        if (url.includes('/shorts/')) {
            videoId = url.split('/shorts/')[1]?.split('?')[0];
        }
        // Short URL format: https://youtu.be/VIDEO_ID
        else if (url.includes('youtu.be')) {
            videoId = url.split('youtu.be/')[1]?.split('?')[0];
        }
        // Standard format: https://www.youtube.com/watch?v=VIDEO_ID
        else if (url.includes('v=')) {
            videoId = url.split('v=')[1]?.split('&')[0];
        }
        // Embed format: https://www.youtube.com/embed/VIDEO_ID
        else if (url.includes('/embed/')) {
            videoId = url.split('/embed/')[1]?.split('?')[0];
        }

        return videoId ? `https://www.youtube.com/embed/${videoId}` : url;
    }

    if (url.includes('vimeo.com')) {
        const videoId = url.split('vimeo.com/')[1]?.split('?')[0];
        return `https://player.vimeo.com/video/${videoId}`;
    }

    return url;
};
</script>

<template>
    <FrontendLayout title="Galerie">
        <!-- HERO SECTION - Ultra Professional -->
        <section class="relative h-[50vh] min-h-[400px] lg:h-[60vh] lg:min-h-[500px] flex items-center overflow-hidden">
            <!-- Background Image with Parallax Effect -->
            <div class="absolute inset-0">
                <img
                    :src="hero?.image_url || '/image/hero.webp'"
                    alt="Galerie SVS RENOV"
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
                            <span class="text-primary font-semibold text-sm uppercase tracking-wider">Photos & Vidéos</span>
                        </div>
                        <h1 class="text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-black text-white leading-tight">
                            Galerie<span class="text-primary">.</span>
                        </h1>
                        <p class="text-lg lg:text-xl text-white/80 max-w-xl leading-relaxed">
                            Découvrez nos réalisations en images et vidéos
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

        <!-- GALLERY SECTION - Ultra Professional -->
        <section class="py-8 md:py-20 lg:py-32 bg-white">
            <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8">
                <!-- Section Intro -->
                <div class="text-center mb-8 md:mb-16 lg:mb-24">
                    <span class="text-primary font-semibold text-xs md:text-sm uppercase tracking-wider">Explorez nos réalisations</span>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-secondary mt-3 md:mt-4 mb-4 md:mb-6">
                        Notre Galerie
                    </h2>
                    <div class="w-16 md:w-24 h-1 bg-primary mx-auto mb-4 md:mb-6"></div>
                    <p class="text-sm md:text-lg text-gray-600 max-w-3xl mx-auto px-2">
                        Photos et vidéos de nos chantiers, équipements et réalisations
                    </p>
                </div>

                <!-- Category Filters -->
                <div class="flex flex-wrap gap-2 md:gap-4 justify-center mb-6 md:mb-12 lg:mb-16 px-2">
                    <button
                        @click="selectedCategory = null"
                        :class="selectedCategory === null
                            ? 'bg-primary text-white shadow-lg'
                            : 'bg-white text-gray-700 active:bg-gray-50 md:hover:bg-gray-50 shadow-md'"
                        class="px-3 md:px-8 py-2 md:py-4 rounded-full font-bold text-xs md:text-base uppercase tracking-wide transition-all duration-300 md:hover:scale-105 md:hover:shadow-2xl active:scale-95"
                    >
                        Tout
                    </button>
                    <button
                        v-for="category in categories"
                        :key="category.id"
                        @click="selectedCategory = category.id"
                        :class="selectedCategory === category.id
                            ? 'bg-primary text-white shadow-lg'
                            : 'bg-white text-gray-700 active:bg-gray-50 md:hover:bg-gray-50 shadow-md'"
                        class="px-3 md:px-8 py-2 md:py-4 rounded-full font-bold text-xs md:text-base uppercase tracking-wide transition-all duration-300 md:hover:scale-105 md:hover:shadow-2xl active:scale-95"
                    >
                        {{ category.name }}
                    </button>
                </div>

                <!-- Gallery Grid -->
                <div v-if="filteredGalleries.length > 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4 lg:gap-6">
                    <div
                        v-for="item in filteredGalleries"
                        :key="item.id"
                        @click="openLightbox(item)"
                        class="group cursor-pointer"
                    >
                        <div class="bg-white rounded-lg md:rounded-2xl overflow-hidden shadow-md md:shadow-xl md:hover:shadow-3xl transition-all duration-300 md:duration-500 active:scale-95 md:hover:-translate-y-2">
                            <!-- Image/Video Container -->
                            <div class="relative aspect-square overflow-hidden">
                                <!-- Image -->
                                <img
                                    v-if="item.type === 'image'"
                                    :src="`/storage/${item.file_path}`"
                                    :alt="item.title"
                                    class="w-full h-full object-cover md:transform md:group-hover:scale-110 md:transition-transform md:duration-700"
                                >

                                <!-- Video Thumbnail -->
                                <div v-else-if="item.type === 'video'" class="relative w-full h-full">
                                    <img
                                        v-if="item.thumbnail_path"
                                        :src="`/storage/${item.thumbnail_path}`"
                                        :alt="item.title"
                                        class="w-full h-full object-cover md:transform md:group-hover:scale-110 md:transition-transform md:duration-700"
                                    >
                                    <div v-else class="w-full h-full bg-gradient-to-br from-primary to-secondary"></div>

                                    <!-- Play Icon -->
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-12 h-12 md:w-20 md:h-20 rounded-full bg-white/95 backdrop-blur-sm flex items-center justify-center shadow-lg md:shadow-2xl md:group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6 md:w-10 md:h-10 text-primary ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Overlay - Hidden on mobile, shown on hover on desktop -->
                                <div class="hidden md:block absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500">
                                    <div class="absolute bottom-0 left-0 right-0 p-4 lg:p-5">
                                        <h3 class="text-white font-bold text-base lg:text-lg mb-1 line-clamp-1">{{ item.title }}</h3>
                                        <div class="flex items-center gap-2">
                                            <span class="text-primary text-xs lg:text-sm font-semibold">{{ item.category.name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="text-center py-20">
                    <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-600 mb-3">Aucun élément dans cette catégorie</h3>
                    <p class="text-gray-500 text-lg">Sélectionnez une autre catégorie pour voir plus de contenu</p>
                </div>
            </div>
        </section>

        <!-- Lightbox -->
        <teleport to="body">
            <transition
                enter-active-class="transition-opacity duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-300"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="lightboxOpen"
                    @click="closeLightbox"
                    class="fixed inset-0 z-50 bg-black/95 backdrop-blur-sm flex items-center justify-center p-4"
                >
                    <button
                        @click="closeLightbox"
                        class="absolute top-6 right-6 text-white/80 hover:text-white transition-colors z-10 bg-black/50 backdrop-blur-sm rounded-full p-3 hover:bg-black/70"
                    >
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <div
                        v-if="lightboxItem"
                        @click.stop
                        class="max-w-6xl w-full max-h-[90vh] flex flex-col"
                    >
                        <!-- Image -->
                        <img
                            v-if="lightboxItem.type === 'image'"
                            :src="`/storage/${lightboxItem.file_path}`"
                            :alt="lightboxItem.title"
                            class="max-w-full max-h-[80vh] object-contain rounded-xl shadow-2xl"
                        >

                        <!-- Video -->
                        <iframe
                            v-else-if="lightboxItem.type === 'video'"
                            :src="getVideoEmbedUrl(lightboxItem.video_url)"
                            class="w-full aspect-video rounded-xl shadow-2xl"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                        ></iframe>

                        <!-- Info -->
                        <div class="mt-6 text-white bg-black/50 backdrop-blur-md rounded-xl p-6">
                            <h3 class="text-2xl md:text-3xl font-bold mb-3">{{ lightboxItem.title }}</h3>
                            <p v-if="lightboxItem.description" class="text-gray-300 mb-4 text-lg leading-relaxed">{{ lightboxItem.description }}</p>
                            <span class="inline-block px-4 py-2 bg-primary rounded-full text-sm font-bold uppercase tracking-wide">
                                {{ lightboxItem.category.name }}
                            </span>
                        </div>
                    </div>
                </div>
            </transition>
        </teleport>
    </FrontendLayout>
</template>
