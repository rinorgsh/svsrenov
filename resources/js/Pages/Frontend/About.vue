<script setup>
import { Link } from '@inertiajs/vue3';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();
</script>

<template>
    <FrontendLayout :title="t('about')">
        <!-- HERO SECTION -->
        <section class="relative h-[50vh] min-h-[400px] lg:h-[60vh] lg:min-h-[500px] flex items-center overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img
                    src="/image/hero.webp"
                    alt="À propos SVS RENOV"
                    class="w-full h-full object-cover scale-105"
                >
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
            </div>

            <!-- Hero Content -->
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
                    <!-- Title Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="h-1 w-16 bg-primary"></div>
                            <span class="text-primary font-semibold text-sm uppercase tracking-wider">{{ t('about_hero_subtitle') }}</span>
                        </div>
                        <h1 class="text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-black text-white leading-tight">
                            {{ t('about_hero_title_1') }}<span class="text-primary">.</span>
                        </h1>
                        <p class="text-lg lg:text-xl text-white/80 max-w-xl leading-relaxed">
                            {{ t('about_hero_description') }}
                        </p>
                    </div>

                    <!-- CTA Button - Desktop -->
                    <Link
                        :href="route('contact.index')"
                        class="hidden lg:inline-flex items-center gap-3 px-10 py-5 bg-primary text-white font-bold text-lg hover:bg-opacity-90 transition-all shadow-2xl hover:shadow-primary/50 hover:scale-105 group"
                    >
                        <span>{{ t('contact_us') }}</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </Link>
                </div>
            </div>
        </section>

        <!-- STORY SECTION -->
        <section class="py-20 lg:py-32 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                    <!-- Content -->
                    <div class="space-y-8">
                        <div class="space-y-4">
                            <span class="text-primary font-semibold text-sm uppercase tracking-wider">{{ t('about_story_subtitle') }}</span>
                            <h2 class="text-4xl lg:text-5xl font-black text-secondary leading-tight">
                                {{ t('about_story_title') }}
                            </h2>
                            <div class="w-24 h-1 bg-primary"></div>
                        </div>

                        <!-- Introduction -->
                        <div class="prose prose-lg max-w-none">
                            <p class="text-gray-700 leading-relaxed text-lg">
                                {{ t('about_story_intro') }}
                            </p>
                        </div>

                        <!-- Values -->
                        <div class="grid sm:grid-cols-2 gap-6 pt-6">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-secondary mb-1">{{ t('about_value_quality_title') }}</h3>
                                    <p class="text-gray-600 text-sm">{{ t('about_value_quality_desc') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-secondary mb-1">{{ t('about_value_experience_title') }}</h3>
                                    <p class="text-gray-600 text-sm">{{ t('about_value_experience_desc') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-secondary mb-1">{{ t('about_value_passion_title') }}</h3>
                                    <p class="text-gray-600 text-sm">{{ t('about_value_passion_desc') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-secondary mb-1">{{ t('about_value_service_title') }}</h3>
                                    <p class="text-gray-600 text-sm">{{ t('about_value_service_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="relative">
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                            <img
                                src="/image/logo_black.jpg"
                                alt="SVS Rénov"
                                class="w-full h-[600px] object-cover"
                            >
                            
                        </div>
                        <!-- Decorative Element -->
                        <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-primary/10 rounded-2xl -z-10"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- WHY CHOOSE US SECTION -->
        <section class="py-20 lg:py-32 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-primary font-semibold text-sm uppercase tracking-wider">{{ t('about_why_subtitle') }}</span>
                    <h2 class="text-4xl lg:text-5xl font-black text-secondary mt-4 mb-6">
                        {{ t('about_why_title') }}
                    </h2>
                    <div class="w-24 h-1 bg-primary mx-auto"></div>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-shadow">
                        <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-secondary mb-3">{{ t('about_feature_expertise_title') }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ t('about_feature_expertise_desc') }}</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-shadow">
                        <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-secondary mb-3">{{ t('about_feature_quality_title') }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ t('about_feature_quality_desc') }}</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-shadow">
                        <div class="w-16 h-16 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-secondary mb-3">{{ t('about_feature_availability_title') }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ t('about_feature_availability_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA SECTION -->
        <section class="py-20 lg:py-32 bg-gradient-to-br from-secondary to-secondary/90 text-white relative overflow-hidden">
            <!-- Decorative Background -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-primary rounded-full blur-3xl"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center space-y-8">
                    <div class="space-y-4">
                        <h2 class="text-4xl lg:text-5xl xl:text-6xl font-black leading-tight">
                            {{ t('about_cta_title') }}
                        </h2>
                        <p class="text-lg lg:text-xl text-white/90 max-w-2xl mx-auto">
                            {{ t('about_cta_description') }}
                        </p>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-4">
                        <a
                            href="tel:+32472640679"
                            class="inline-flex items-center gap-3 px-10 py-5 bg-primary text-white font-bold text-lg hover:bg-opacity-90 transition-all shadow-2xl hover:shadow-primary/50 hover:scale-105 group"
                        >
                            <svg class="w-6 h-6 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>0472 64 06 79</span>
                        </a>

                        <Link
                            :href="route('contact.index')"
                            class="inline-flex items-center gap-3 px-10 py-5 bg-white text-secondary font-bold text-lg hover:bg-gray-100 transition-all shadow-2xl hover:scale-105 group"
                        >
                            <span>{{ t('request_quote') }}</span>
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </FrontendLayout>
</template>
