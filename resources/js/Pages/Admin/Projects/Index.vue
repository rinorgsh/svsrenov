<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    projects: Array,
});

const deleteProject = (project) => {
    if (confirm(`Êtes-vous sûr de vouloir supprimer le projet "${project.title_fr}" ?`)) {
        router.delete(route('admin.projects.destroy', project.id));
    }
};
</script>

<template>
    <AdminLayout>
        <template #header>
            Gestion des Projets
        </template>

        <!-- Header Actions -->
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-secondary">Liste des Projets</h2>
            <Link
                :href="route('admin.projects.create')"
                class="bg-primary hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-colors inline-flex items-center"
            >
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nouveau Projet
            </Link>
        </div>

        <!-- Projects List -->
        <div v-if="projects.length === 0" class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun projet</h3>
            <p class="mt-1 text-sm text-gray-500">Commencez par créer un nouveau projet.</p>
            <div class="mt-6">
                <Link
                    :href="route('admin.projects.create')"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-red-700"
                >
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nouveau Projet
                </Link>
            </div>
        </div>

        <div v-else class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Images</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projet</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Localisation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="project in projects" :key="project.id" class="hover:bg-gray-50">
                            <!-- Images -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex gap-2">
                                    <div class="relative">
                                        <img
                                            v-if="project.image_before"
                                            :src="project.image_before"
                                            :alt="`${project.title_fr} - Avant`"
                                            class="h-16 w-16 object-cover rounded-lg"
                                        >
                                        <div v-else class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <span class="absolute -bottom-1 -right-1 bg-black text-white text-xs px-1 rounded">Avant</span>
                                    </div>
                                    <div class="relative">
                                        <img
                                            v-if="project.image_after"
                                            :src="project.image_after"
                                            :alt="`${project.title_fr} - Après`"
                                            class="h-16 w-16 object-cover rounded-lg"
                                        >
                                        <div v-else class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <span class="absolute -bottom-1 -right-1 bg-primary text-white text-xs px-1 rounded">Après</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Project Info -->
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ project.title_fr }}</div>
                                <div class="text-sm text-gray-500">{{ project.title_nl }}</div>
                                <div class="flex gap-2 mt-1">
                                    <span v-if="project.is_featured" class="px-2 py-0.5 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">
                                        ⭐ Vedette
                                    </span>
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded bg-gray-100 text-gray-800">
                                        #{{ project.order }}
                                    </span>
                                </div>
                            </td>

                            <!-- Service -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ project.service?.title_fr }}</div>
                            </td>

                            <!-- Location -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ project.location }}</div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span v-if="project.is_published" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Publié
                                </span>
                                <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Brouillon
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex gap-2 justify-end">
                                    <Link
                                        :href="route('admin.projects.edit', project.id)"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition-colors"
                                    >
                                        Modifier
                                    </Link>
                                    <button
                                        @click="deleteProject(project)"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition-colors"
                                    >
                                        Supprimer
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
