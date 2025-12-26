<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    heroes: Array,
});
</script>

<template>
    <AdminLayout>
        <template #header>
            Gestion des Heroes
        </template>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div v-if="heroes.length === 0" class="p-6 text-center text-gray-500">
                Aucun hero trouvé.
            </div>

            <table v-else class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Page</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre (FR)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="hero in heroes" :key="hero.id">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-medium text-gray-900 capitalize">{{ hero.page }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img v-if="hero.image_path" :src="`/storage/${hero.image_path}`" alt="Hero" class="h-16 w-24 object-cover rounded">
                            <span v-else class="text-gray-400">Pas d'image</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-900">{{ hero.title_fr || '-' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span :class="hero.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                {{ hero.is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <Link
                                :href="route('admin.hero.edit', hero.id)"
                                class="text-primary hover:text-red-700 mr-4"
                            >
                                Modifier
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
