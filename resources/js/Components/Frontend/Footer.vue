<script setup>
    import { Link } from '@inertiajs/vue3';
    import { ref } from 'vue';
    
    const currentYear = new Date().getFullYear();
    
    // Réseaux sociaux
    const socialLinks = [
        { name: 'Facebook', href: 'https://www.facebook.com/', icon: 'facebook' },
        { name: 'Instagram', href: 'https://www.instagram.com/', icon: 'instagram' },
        { name: 'LinkedIn', href: 'https://www.linkedin.com/', icon: 'linkedin' },
    ];
    </script>
    
    <template>
    <footer class="bg-secondary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex flex-col items-center">
            <!-- Logo -->
            <Link :href="route('home')" class="mb-6">
                <img src="/image/logo.png" alt="SVS RENOV" class="h-24 w-24 sm:h-28 sm:w-28" />
            </Link>
    
            <!-- Contact -->
            <div class="flex flex-col items-center space-y-2 mb-6 text-gray-300 text-sm sm:text-base">
                <a href="tel:+32123456789" class="hover:text-primary transition-colors">+32 123 456 789</a>
                <a href="mailto:info@svsrenov.be" class="hover:text-primary transition-colors">info@svsrenov.be</a>
            </div>
    
            <!-- Réseaux sociaux -->
            <div class="flex space-x-6 mb-6 text-2xl">
                <a
                    v-for="social in socialLinks"
                    :key="social.name"
                    :href="social.href"
                    target="_blank"
                    class="text-gray-300 hover:text-primary transition-colors"
                    aria-label="social.name"
                >
                    <i v-if="social.icon === 'facebook'" class="fab fa-facebook-f"></i>
                    <i v-if="social.icon === 'instagram'" class="fab fa-instagram"></i>
                    <i v-if="social.icon === 'linkedin'" class="fab fa-linkedin-in"></i>
                </a>
            </div>
    
            <!-- Copyright -->
            <p class="text-gray-400 text-sm">&copy; {{ currentYear }} SVS RENOV. Tous droits réservés.</p>
        </div>
    </footer>
    </template>
    
    <style>
    /* FontAwesome pour les icônes sociales */
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
    </style>
    