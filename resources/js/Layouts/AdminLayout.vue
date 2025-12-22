<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const sidebarOpen = ref(true);

const user = computed(() => page.props.auth.user);

const navigation = [
    { name: 'Dashboard', href: route('admin.dashboard'), icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
    { name: 'Services', href: route('admin.services.index'), icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10' },
    { name: 'Projets', href: route('admin.projects.index'), icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z' },
    { name: 'Galerie', href: route('admin.gallery.index'), icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z' },
];

const isActive = (href) => {
    return page.url.startsWith(href);
};

const logout = () => {
    if (confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
        window.location.href = route('logout');
    }
};
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <div
            :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="fixed inset-y-0 left-0 bg-secondary shadow-lg transition-all duration-300 z-50"
        >
            <!-- Logo -->
            <div class="flex items-center justify-center h-20 px-4 bg-primary">
                <Link :href="route('admin.dashboard')" class="flex items-center">
                    <img v-if="sidebarOpen" src="/image/logo.png" alt="SVS RENOV" class="h-16 w-16">
                    <img v-else src="/image/logo.png" alt="SVS RENOV" class="h-12 w-12">
                </Link>
            </div>

            <!-- Navigation -->
            <nav class="mt-8 px-4">
                <Link
                    v-for="item in navigation"
                    :key="item.name"
                    :href="item.href"
                    :class="[
                        isActive(item.href)
                            ? 'bg-primary text-white'
                            : 'text-gray-300 hover:bg-gray-700 hover:text-white',
                        'group flex items-center px-4 py-3 text-sm font-medium rounded-md mb-2 transition-colors'
                    ]"
                >
                    <svg class="flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon" />
                    </svg>
                    <span v-if="sidebarOpen" class="ml-3">{{ item.name }}</span>
                </Link>
            </nav>

            <!-- User Info & Logout -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-700">
                <div v-if="sidebarOpen" class="flex items-center mb-3">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-primary flex items-center justify-center text-white font-bold">
                            {{ user?.name?.charAt(0).toUpperCase() || 'A' }}
                        </div>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ user?.name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ user?.email }}</p>
                    </div>
                </div>

                <Link
                    :href="route('home')"
                    class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors mb-2"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span v-if="sidebarOpen" class="ml-3">Voir le site</span>
                </Link>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="w-full flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-red-600 hover:text-white rounded-md transition-colors"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span v-if="sidebarOpen" class="ml-3">Déconnexion</span>
                </Link>
            </div>

            <!-- Toggle Button -->
            <button
                @click="sidebarOpen = !sidebarOpen"
                class="absolute -right-3 top-20 bg-primary text-white rounded-full p-1.5 shadow-lg hover:bg-opacity-90 transition-all"
            >
                <svg v-if="sidebarOpen" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <svg v-else class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- Main Content -->
        <div :class="sidebarOpen ? 'ml-64' : 'ml-20'" class="transition-all duration-300">
            <!-- Top Bar -->
            <div class="bg-white shadow-sm h-20 flex items-center justify-between px-8">
                <h1 class="text-2xl font-bold text-secondary">
                    <slot name="header">Administration</slot>
                </h1>
            </div>

            <!-- Page Content -->
            <main class="p-8">
                <slot />
            </main>
        </div>
    </div>
</template>
