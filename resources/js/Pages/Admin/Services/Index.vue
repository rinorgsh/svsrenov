<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    services: Array,
});

const deleteService = (service) => {
    if (confirm(`Êtes-vous sûr de vouloir supprimer le service "${service.title_fr}" ?`)) {
        router.delete(route('admin.services.destroy', service.id));
    }
};
</script>

<template>
    <AdminLayout>
        <template #header>
            Gestion des Services
        </template>

        <!-- Header Actions -->
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-secondary">Liste des Services</h2>
            <Link
                :href="route('admin.services.create')"
                class="bg-primary hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition-colors inline-flex items-center"
            >
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nouveau Service
            </Link>
        </div>

        <!-- Services Grid -->
        <div v-if="services.length === 0" class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun service</h3>
            <p class="mt-1 text-sm text-gray-500">Commencez par créer un nouveau service.</p>
            <div class="mt-6">
                <Link
                    :href="route('admin.services.create')"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-red-700"
                >
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nouveau Service
                </Link>
            </div>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-for="service in services"
                :key="service.id"
                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow"
            >
                <!-- Service Image -->
                <div class="h-48 bg-gray-200 relative">
                    <img
                        v-if="service.image"
                        :src="service.image"
                        :alt="service.title_fr"
                        class="w-full h-full object-cover"
                    >
                    <div v-else class="flex items-center justify-center h-full bg-gradient-to-br from-gray-300 to-gray-400">
                        <svg class="h-16 w-16 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <!-- Order Badge -->
                    <div class="absolute top-3 left-3 bg-primary text-white rounded-full h-10 w-10 flex items-center justify-center font-bold text-sm shadow-lg">
                        {{ service.order }}
                    </div>

                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        <span v-if="service.is_active" class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500 text-white shadow-lg">
                            Actif
                        </span>
                        <span v-else class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-500 text-white shadow-lg">
                            Inactif
                        </span>
                    </div>
                </div>

                <!-- Service Content -->
                <div class="p-6">
                    <div class="mb-3">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ service.slug }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-secondary mb-2">{{ service.title_fr }}</h3>
                    <p class="text-gray-600 text-sm mb-1">{{ service.title_nl }}</p>
                    <p class="text-gray-700 text-sm line-clamp-3 mt-3">{{ service.description_fr }}</p>
                </div>

                <!-- Actions -->
                <div class="px-6 pb-6 flex gap-3">
                    <Link
                        :href="route('admin.services.edit', service.id)"
                        class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-center text-sm"
                    >
                        Modifier
                    </Link>
                    <button
                        @click="deleteService(service)"
                        class="flex-1 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-sm"
                    >
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
