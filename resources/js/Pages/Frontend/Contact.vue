<script setup>
    import { useForm } from '@inertiajs/vue3';
    import FrontendLayout from '@/Layouts/FrontendLayout.vue';
    import { useTranslations } from '@/Composables/useTranslations';
    
    const { t } = useTranslations();
    
    defineProps({
        services: Array,
    });
    
    const form = useForm({
        name: '',
        email: '',
        phone: '',
        service_id: '',
        message: '',
    });
    
    const submit = () => {
        form.post(route('contact.store'), {
            onSuccess: () => {
                form.reset();
            },
        });
    };
    </script>
    
    <template>
        <FrontendLayout :title="t('contact')">
            <!-- HERO SECTION - Ultra Professional -->
            <section class="relative h-[50vh] min-h-[400px] lg:h-[60vh] lg:min-h-[500px] flex items-center overflow-hidden">
                <!-- Background Image with Parallax Effect -->
                <div class="absolute inset-0">
                    <img
                        src="/image/hero.webp"
                        alt="Contact SVS RENOV"
                        class="w-full h-full object-cover scale-105"
                    >
                    <!-- Sophisticated Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
                    <!-- Subtle Pattern Overlay -->
                    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M0 0h20v20H0z\' fill=\'none\'/%3E%3Cpath d=\'M10 0v20M0 10h20\' stroke=\'%23fff\' stroke-width=\'0.5\' opacity=\'0.1\'/%3E%3C/svg%3E');"></div>
                </div>
    
                <!-- Hero Content -->
                <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="h-1 w-16 bg-primary"></div>
                            <span class="text-primary font-semibold text-sm uppercase tracking-wider">Parlons de votre projet</span>
                        </div>
                        <h1 class="text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-black text-white leading-tight">
                            Contact<span class="text-primary">.</span>
                        </h1>
                        <p class="text-lg lg:text-xl text-white/80 max-w-2xl leading-relaxed">
                            Notre équipe est à votre écoute pour répondre à toutes vos questions et vous accompagner dans votre projet
                        </p>
                    </div>
                </div>
    
                <!-- Scroll Indicator -->
                <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 hidden lg:block">
                    <div class="flex flex-col items-center gap-2 text-white/60 animate-bounce">
                        <span class="text-xs uppercase tracking-wider">Nous contacter</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </div>
                </div>
            </section>
    
            <!-- CONTACT METHODS SECTION - Premium Cards -->
            <section class="py-16 md:py-20 lg:py-32 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Section Intro -->
                    <div class="text-center mb-16 lg:mb-20">
                        <span class="text-primary font-semibold text-sm uppercase tracking-wider">Plusieurs façons de nous joindre</span>
                        <h2 class="text-3xl lg:text-4xl font-bold text-secondary mt-4 mb-6">
                            Contactez-nous
                        </h2>
                        <div class="w-24 h-1 bg-primary mx-auto"></div>
                    </div>
    
                    <!-- Contact Methods Grid -->
                    <div class="grid md:grid-cols-3 gap-6 lg:gap-8 mb-16 lg:mb-24">
                        <!-- Phone Card -->
                        <a 
                            href="tel:+3228871021"
                            class="group bg-white rounded-2xl p-8 shadow-xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-2 border border-gray-100"
                        >
                            <div class="flex flex-col items-center text-center space-y-4">
                                <!-- Icon -->
                                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary transition-colors">
                                    <svg class="w-8 h-8 text-primary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <!-- Title -->
                                <h3 class="text-xl font-bold text-secondary group-hover:text-primary transition-colors">
                                    Téléphone
                                </h3>
                                <!-- Content -->
                                <div class="space-y-2">
                                    <p class="text-2xl font-bold text-primary">
                                        02 887 10 21
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Lun - Ven : 8h00 - 18h00
                                    </p>
                                </div>
                                <!-- Arrow -->
                                <div class="flex items-center gap-2 text-primary font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span>Appelez maintenant</span>
                                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
    
                        <!-- Email Card -->
                        <a 
                            href="mailto:info@svsrenov.be"
                            class="group bg-white rounded-2xl p-8 shadow-xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-2 border border-gray-100"
                        >
                            <div class="flex flex-col items-center text-center space-y-4">
                                <!-- Icon -->
                                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary transition-colors">
                                    <svg class="w-8 h-8 text-primary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <!-- Title -->
                                <h3 class="text-xl font-bold text-secondary group-hover:text-primary transition-colors">
                                    Email
                                </h3>
                                <!-- Content -->
                                <div class="space-y-2">
                                    <p class="text-lg font-bold text-primary break-all">
                                        info@svsrenov.be
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Réponse sous 24h
                                    </p>
                                </div>
                                <!-- Arrow -->
                                <div class="flex items-center gap-2 text-primary font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span>Envoyez un email</span>
                                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
    
                        <!-- Location Card -->
                        <div class="group bg-white rounded-2xl p-8 shadow-xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-2 border border-gray-100">
                            <div class="flex flex-col items-center text-center space-y-4">
                                <!-- Icon -->
                                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary transition-colors">
                                    <svg class="w-8 h-8 text-primary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <!-- Title -->
                                <h3 class="text-xl font-bold text-secondary group-hover:text-primary transition-colors">
                                    Localisation
                                </h3>
                                <!-- Content -->
                                <div class="space-y-2">
                                    <p class="text-lg font-bold text-secondary">
                                        Belgique
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Intervention dans toute la région
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Main Contact Section -->
                    <div class="grid lg:grid-cols-5 gap-12 lg:gap-16">
                        <!-- Left: Working Hours + Info -->
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Working Hours Card -->
                            <div class="bg-gradient-to-br from-secondary to-black text-white rounded-3xl p-8 lg:p-10 shadow-2xl">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold">
                                        Horaires d'ouverture
                                    </h3>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center pb-4 border-b border-white/20">
                                        <span class="font-semibold">Lundi - Vendredi</span>
                                        <span class="text-primary font-bold">8h00 - 18h00</span>
                                    </div>
                                    <div class="flex justify-between items-center pb-4 border-b border-white/20">
                                        <span class="font-semibold">Samedi</span>
                                        <span class="text-primary font-bold">9h00 - 14h00</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-semibold">Dimanche</span>
                                        <span class="text-white/60">Fermé</span>
                                    </div>
                                </div>
                            </div>
    
                            <!-- Why Contact Us -->
                            <div class="bg-gray-50 rounded-3xl p-8 space-y-6">
                                <h3 class="text-xl font-bold text-secondary flex items-center gap-3">
                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Pourquoi nous contacter ?
                                </h3>
                                <ul class="space-y-3">
                                    <li class="flex items-start gap-3">
                                        <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg class="w-3 h-3 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-700">Devis gratuit et sans engagement</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg class="w-3 h-3 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-700">Conseils d'experts personnalisés</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg class="w-3 h-3 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-700">Réponse rapide sous 24h</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <div class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg class="w-3 h-3 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-700">15+ ans d'expérience</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
    
                        <!-- Right: Contact Form -->
                        <div class="lg:col-span-3">
                            <div class="bg-white rounded-3xl shadow-2xl p-8 lg:p-10 border border-gray-100">
                                <div class="mb-8">
                                    <h2 class="text-3xl font-bold text-secondary mb-3">
                                        Envoyez-nous un message
                                    </h2>
                                    <p class="text-gray-600">
                                        Remplissez ce formulaire et nous vous répondrons dans les plus brefs délais
                                    </p>
                                </div>
    
                                <!-- Success Message -->
                                <Transition
                                    enter-active-class="transition duration-300 ease-out"
                                    enter-from-class="opacity-0 -translate-y-2"
                                    enter-to-class="opacity-100 translate-y-0"
                                    leave-active-class="transition duration-200 ease-in"
                                    leave-from-class="opacity-100 translate-y-0"
                                    leave-to-class="opacity-0 -translate-y-2"
                                >
                                    <div v-if="$page.props.flash?.success" class="mb-6 bg-green-50 border-2 border-green-400 text-green-700 px-6 py-4 rounded-2xl flex items-start gap-3">
                                        <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="font-semibold">Message envoyé avec succès !</p>
                                            <p class="text-sm text-green-600">{{ t($page.props.flash.success) }}</p>
                                        </div>
                                    </div>
                                </Transition>
    
                                <!-- Form -->
                                <form @submit.prevent="submit" class="space-y-6">
                                    <!-- Name -->
                                    <div>
                                        <label class="block text-sm font-bold text-secondary mb-2">
                                            {{ t('contact_name') }} <span class="text-primary">*</span>
                                        </label>
                                        <input
                                            v-model="form.name"
                                            type="text"
                                            required
                                            placeholder="Votre nom complet"
                                            class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                                            :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-500': form.errors.name }"
                                        >
                                        <Transition
                                            enter-active-class="transition duration-200 ease-out"
                                            enter-from-class="opacity-0 -translate-y-1"
                                            enter-to-class="opacity-100 translate-y-0"
                                        >
                                            <p v-if="form.errors.name" class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ form.errors.name }}
                                            </p>
                                        </Transition>
                                    </div>
    
                                    <!-- Email & Phone Grid -->
                                    <div class="grid md:grid-cols-2 gap-6">
                                        <!-- Email -->
                                        <div>
                                            <label class="block text-sm font-bold text-secondary mb-2">
                                                {{ t('contact_email') }} <span class="text-primary">*</span>
                                            </label>
                                            <input
                                                v-model="form.email"
                                                type="email"
                                                required
                                                placeholder="votre@email.com"
                                                class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                                                :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-500': form.errors.email }"
                                            >
                                            <Transition
                                                enter-active-class="transition duration-200 ease-out"
                                                enter-from-class="opacity-0 -translate-y-1"
                                                enter-to-class="opacity-100 translate-y-0"
                                            >
                                                <p v-if="form.errors.email" class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ form.errors.email }}
                                                </p>
                                            </Transition>
                                        </div>
    
                                        <!-- Phone -->
                                        <div>
                                            <label class="block text-sm font-bold text-secondary mb-2">
                                                {{ t('contact_phone') }}
                                            </label>
                                            <input
                                                v-model="form.phone"
                                                type="tel"
                                                placeholder="+32 ..."
                                                class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all"
                                            >
                                        </div>
                                    </div>
    
                                    <!-- Service -->
                                    <div>
                                        <label class="block text-sm font-bold text-secondary mb-2">
                                            {{ t('contact_service') }}
                                        </label>
                                        <div class="relative">
                                            <select
                                                v-model="form.service_id"
                                                class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all appearance-none cursor-pointer"
                                            >
                                                <option value="">{{ t('select_service') }}</option>
                                                <option v-for="service in services" :key="service.id" :value="service.id">
                                                    {{ service.title }}
                                                </option>
                                            </select>
                                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
    
                                    <!-- Message -->
                                    <div>
                                        <label class="block text-sm font-bold text-secondary mb-2">
                                            {{ t('contact_message') }} <span class="text-primary">*</span>
                                        </label>
                                        <textarea
                                            v-model="form.message"
                                            required
                                            rows="6"
                                            placeholder="Décrivez votre projet..."
                                            class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all resize-none"
                                            :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-500': form.errors.message }"
                                        ></textarea>
                                        <Transition
                                            enter-active-class="transition duration-200 ease-out"
                                            enter-from-class="opacity-0 -translate-y-1"
                                            enter-to-class="opacity-100 translate-y-0"
                                        >
                                            <p v-if="form.errors.message" class="mt-2 text-sm text-red-600 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ form.errors.message }}
                                            </p>
                                        </Transition>
                                    </div>
    
                                    <!-- Submit Button -->
                                    <button
                                        type="submit"
                                        :disabled="form.processing"
                                        class="w-full bg-primary text-white px-8 py-5 rounded-xl hover:bg-secondary transition-all duration-300 font-bold text-lg disabled:opacity-50 disabled:cursor-not-allowed shadow-xl hover:shadow-2xl hover:scale-[1.02] flex items-center justify-center gap-3 group"
                                    >
                                        <span v-if="!form.processing">Envoyer le message</span>
                                        <span v-else class="flex items-center gap-3">
                                            <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Envoi en cours...
                                        </span>
                                        <svg v-if="!form.processing" class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </button>
    
                                    <!-- Privacy Note -->
                                    <p class="text-xs text-gray-500 text-center">
                                        En soumettant ce formulaire, vous acceptez que vos données soient utilisées pour vous recontacter concernant votre demande.
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    
            <!-- QUICK CONTACT CTA -->
            <section class="py-20 lg:py-28 bg-gradient-to-br from-gray-50 to-white relative overflow-hidden">
                <!-- Decorative Background Elements -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute top-0 left-0 w-96 h-96 bg-primary rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 right-0 w-96 h-96 bg-secondary rounded-full blur-3xl"></div>
                </div>
    
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-gradient-to-r from-primary to-secondary text-white rounded-3xl p-10 lg:p-16 shadow-3xl">
                        <div class="text-center space-y-6">
                            <h2 class="text-3xl lg:text-4xl xl:text-5xl font-black">
                                Besoin d'une réponse immédiate ?
                            </h2>
                            <p class="text-xl text-white/90 max-w-2xl mx-auto">
                                Notre équipe est disponible pour répondre à toutes vos questions par téléphone
                            </p>
                            <a
                                href="tel:+3228871021"
                                class="inline-flex items-center gap-3 px-10 py-6 bg-white text-primary font-bold text-xl rounded-xl hover:bg-gray-100 transition-all shadow-2xl hover:scale-105 group"
                            >
                                <svg class="w-7 h-7 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>02 887 10 21</span>
                            </a>
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
    
    /* Smooth transitions */
    * {
        transition-property: transform, box-shadow, background-color, opacity, border-color;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Custom scrollbar for textarea */
    textarea::-webkit-scrollbar {
        width: 8px;
    }
    
    textarea::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    textarea::-webkit-scrollbar-thumb {
        background: #FDB714;
        border-radius: 10px;
    }
    
    textarea::-webkit-scrollbar-thumb:hover {
        background: #e5a510;
    }
    
    /* Loading spinner animation */
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
    
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    </style>