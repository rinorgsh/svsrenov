<script setup>
    import { Link } from '@inertiajs/vue3';
    import { ref } from 'vue';

    const currentYear = new Date().getFullYear();

    // Réseaux sociaux
    const socialLinks = [
        { name: 'Facebook', href: 'https://www.facebook.com/p/SVS-Renov-61558432052856/', icon: 'facebook' },
        { name: 'Instagram', href: 'https://www.instagram.com/svsrenov_be/', icon: 'instagram' },
    ];
    </script>

    <template>
    <footer class="bg-secondary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                <!-- Logo & Description -->
                <div class="flex flex-col items-center md:items-start space-y-4">
                    <Link :href="route('home')">
                        <img src="/image/logo.png" alt="SVS RENOV" class="h-24 w-24" />
                    </Link>
                    <p class="text-gray-300 text-sm text-center md:text-left max-w-xs">
                        Spécialiste en rénovation de façades en Belgique
                    </p>
                </div>

                <!-- Contact Info -->
                <div class="flex flex-col items-center md:items-start space-y-4">
                    <h3 class="text-lg font-bold text-white">Contact</h3>
                    <div class="flex flex-col space-y-3 text-gray-300 text-sm">
                        <a href="tel:+32472640679" class="hover:text-primary transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            0472 64 06 79
                        </a>
                        <a href="mailto:info@svsrenov.be" class="hover:text-primary transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            info@svsrenov.be
                        </a>
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Vilvoordsesteenweg<br>Meise, Belgium</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>TVA: BE1011.945.471</span>
                        </div>
                    </div>
                </div>

                <!-- Social & Links -->
                <div class="flex flex-col items-center md:items-start space-y-4">
                    <h3 class="text-lg font-bold text-white">Suivez-nous</h3>
                    <div class="flex space-x-4 text-2xl">
                        <a
                            v-for="social in socialLinks"
                            :key="social.name"
                            :href="social.href"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-gray-300 hover:bg-primary hover:text-white transition-all"
                            :aria-label="social.name"
                        >
                            <i v-if="social.icon === 'facebook'" class="fab fa-facebook-f text-lg"></i>
                            <i v-if="social.icon === 'instagram'" class="fab fa-instagram text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Separator -->
            <div class="border-t border-gray-700 mt-8 pt-8">
                <p class="text-gray-400 text-sm text-center">&copy; {{ currentYear }} SVS RENOV. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    </template>
    
    <style>
    /* FontAwesome pour les icônes sociales */
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
    </style>
    