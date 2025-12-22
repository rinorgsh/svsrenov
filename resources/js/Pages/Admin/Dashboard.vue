<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    stats: Object,
    recent_projects: Array,
    recent_contact_requests: Array,
});
</script>

<template>
    <AdminLayout>
        <template #header>
            Dashboard
        </template>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Services Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-primary">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Services</p>
                        <p class="text-3xl font-bold text-secondary mt-1">{{ stats.active_services }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ stats.total_services }} total</p>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-full p-3">
                        <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Projects Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Projets</p>
                        <p class="text-3xl font-bold text-secondary mt-1">{{ stats.published_projects }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ stats.total_projects }} total</p>
                    </div>
                    <div class="bg-blue-500 bg-opacity-10 rounded-full p-3">
                        <svg class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Featured Projects Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Projets en vedette</p>
                        <p class="text-3xl font-bold text-secondary mt-1">{{ stats.featured_projects }}</p>
                        <p class="text-xs text-gray-500 mt-1">Affichés sur l'accueil</p>
                    </div>
                    <div class="bg-yellow-500 bg-opacity-10 rounded-full p-3">
                        <svg class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Contact Requests Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Demandes contact</p>
                        <p class="text-3xl font-bold text-secondary mt-1">{{ stats.unread_contact_requests }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ stats.total_contact_requests }} total</p>
                    </div>
                    <div class="bg-green-500 bg-opacity-10 rounded-full p-3">
                        <svg class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <Link
                :href="route('admin.services.create')"
                class="bg-gradient-to-r from-primary to-red-700 text-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow group"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold mb-2">Nouveau Service</h3>
                        <p class="text-white text-opacity-90">Ajouter un nouveau service</p>
                    </div>
                    <svg class="h-12 w-12 text-white text-opacity-50 group-hover:text-opacity-100 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
            </Link>

            <Link
                :href="route('admin.projects.create')"
                class="bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow group"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold mb-2">Nouveau Projet</h3>
                        <p class="text-white text-opacity-90">Ajouter une nouvelle réalisation</p>
                    </div>
                    <svg class="h-12 w-12 text-white text-opacity-50 group-hover:text-opacity-100 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
            </Link>
        </div>

        <!-- Recent Projects -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-secondary">Projets récents</h2>
                <Link :href="route('admin.projects.index')" class="text-primary hover:text-red-700 font-medium text-sm">
                    Voir tous →
                </Link>
            </div>

            <div v-if="recent_projects.length === 0" class="text-center py-8 text-gray-500">
                Aucun projet pour le moment
            </div>

            <div v-else class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projet</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Localisation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="project in recent_projects" :key="project.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ project.title_fr }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ project.service?.title_fr }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ project.location }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span v-if="project.is_published" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Publié
                                </span>
                                <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Brouillon
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <Link :href="route('admin.projects.edit', project.id)" class="text-primary hover:text-red-700">
                                    Modifier
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
