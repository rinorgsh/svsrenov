<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    galleries: Array,
    categories: Array,
});

const deleteGallery = (gallery) => {
    if (confirm(`Êtes-vous sûr de vouloir supprimer "${gallery.title}" ?`)) {
        router.delete(route('admin.gallery.destroy', gallery.id));
    }
};
</script>

<template>
    <AdminLayout>
        <template #header>
            Gestion de la Galerie
        </template>

        <!-- Header Actions -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="text-2xl font-bold text-secondary">Galerie</h2>
            <div class="flex gap-3">
                <Link
                    :href="route('admin.gallery-categories.index')"
                    class="bg-secondary hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-colors inline-flex items-center"
                >
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                    Catégories
                </Link>
                <Link
                    :href="route('admin.gallery.create')"
                    class="bg-primary hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-colors inline-flex items-center"
                >
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nouvel Élément
                </Link>
            </div>
        </div>

        <!-- Gallery List -->
        <div v-if="galleries.length === 0" class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun élément</h3>
            <p class="mt-1 text-sm text-gray-500">Commencez par créer un nouvel élément dans la galerie.</p>
            <div class="mt-6">
                <Link
                    :href="route('admin.gallery.create')"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-red-700"
                >
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nouvel Élément
                </Link>
            </div>
        </div>

        <div v-else class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aperçu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="gallery in galleries" :key="gallery.id" class="hover:bg-gray-50">
                            <!-- Preview -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="relative">
                                    <img
                                        v-if="gallery.type === 'image' && gallery.file_path"
                                        :src="`/storage/${gallery.file_path}`"
                                        :alt="gallery.title"
                                        class="h-16 w-16 object-cover rounded-lg"
                                    >
                                    <img
                                        v-else-if="gallery.type === 'video' && gallery.thumbnail_path"
                                        :src="`/storage/${gallery.thumbnail_path}`"
                                        :alt="gallery.title"
                                        class="h-16 w-16 object-cover rounded-lg"
                                    >
                                    <div v-else class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <!-- Video Icon Overlay -->
                                    <div v-if="gallery.type === 'video'" class="absolute inset-0 flex items-center justify-center">
                                        <div class="w-6 h-6 rounded-full bg-white/90 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Title -->
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ gallery.title }}</div>
                                <div v-if="gallery.description" class="text-sm text-gray-500 truncate max-w-xs">{{ gallery.description }}</div>
                            </td>

                            <!-- Type -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span v-if="gallery.type === 'image'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Image
                                </span>
                                <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                    Vidéo
                                </span>
                            </td>

                            <!-- Category -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ gallery.category?.name || 'N/A' }}</div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span v-if="gallery.is_published" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Publié
                                </span>
                                <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Brouillon
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <Link
                                    :href="route('admin.gallery.edit', gallery.id)"
                                    class="text-blue-600 hover:text-blue-900 mr-4"
                                >
                                    Modifier
                                </Link>
                                <button
                                    @click="deleteGallery(gallery)"
                                    class="text-red-600 hover:text-red-900"
                                >
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
