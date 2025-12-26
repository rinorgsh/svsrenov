<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    testimonials: Array,
});

const deleteTestimonial = (id) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce témoignage ?')) {
        router.delete(route('admin.testimonials.destroy', id));
    }
};
</script>

<template>
    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <span>Gestion des Témoignages</span>
                <Link
                    :href="route('admin.testimonials.create')"
                    class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-red-700 transition-colors"
                >
                    Ajouter un témoignage
                </Link>
            </div>
        </template>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div v-if="testimonials.length === 0" class="p-6 text-center text-gray-500">
                Aucun témoignage trouvé. <Link :href="route('admin.testimonials.create')" class="text-primary hover:underline">Ajouter le premier témoignage</Link>
            </div>

            <table v-else class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entreprise</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commentaire</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="testimonial in testimonials" :key="testimonial.id">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div v-if="testimonial.client_photo" class="flex-shrink-0 h-10 w-10">
                                    <img :src="`/storage/${testimonial.client_photo}`" :alt="testimonial.client_name" class="h-10 w-10 rounded-full object-cover">
                                </div>
                                <div :class="testimonial.client_photo ? 'ml-4' : ''">
                                    <div class="text-sm font-medium text-gray-900">{{ testimonial.client_name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900">{{ testimonial.client_company || '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-900 line-clamp-2">{{ testimonial.comment_fr }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex gap-0.5">
                                <svg v-for="star in 5" :key="star" class="w-4 h-4" :class="star <= testimonial.rating ? 'text-primary' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span :class="testimonial.is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                {{ testimonial.is_published ? 'Publié' : 'Brouillon' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <Link
                                :href="route('admin.testimonials.edit', testimonial.id)"
                                class="text-primary hover:text-red-700 mr-4"
                            >
                                Modifier
                            </Link>
                            <button
                                @click="deleteTestimonial(testimonial.id)"
                                class="text-red-600 hover:text-red-900"
                            >
                                Supprimer
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
