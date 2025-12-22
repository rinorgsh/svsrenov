<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    categories: Array,
});

const deleteCategory = (category) => {
    if (confirm(`Êtes-vous sûr de vouloir supprimer "${category.name}" ?`)) {
        router.delete(route('admin.gallery-categories.destroy', category.id));
    }
};
</script>

<template>
    <AdminLayout>
        <template #header>
            Gestion des Catégories de Galerie
        </template>

        <div class="mb-6 flex items-center justify-between">
            <Link
                :href="route('admin.gallery.index')"
                class="text-primary hover:text-red-700 inline-flex items-center"
            >
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la galerie
            </Link>
            <Link
                :href="route('admin.gallery-categories.create')"
                class="bg-primary hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-colors inline-flex items-center"
            >
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nouvelle Catégorie
            </Link>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Éléments</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="category in categories" :key="category.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ category.name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ category.slug }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ category.galleries_count || 0 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span v-if="category.is_active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Actif
                            </span>
                            <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Inactif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <Link :href="route('admin.gallery-categories.edit', category.id)" class="text-blue-600 hover:text-blue-900 mr-4">
                                Modifier
                            </Link>
                            <button @click="deleteCategory(category)" class="text-red-600 hover:text-red-900">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
