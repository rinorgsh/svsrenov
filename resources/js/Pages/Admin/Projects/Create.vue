<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    services: Array,
});

const form = useForm({
    service_id: '',
    title_fr: '',
    title_nl: '',
    description_fr: '',
    description_nl: '',
    location: '',
    image_before: null,
    image_after: null,
    completion_date: '',
    is_featured: false,
    is_published: true,
    order: 1,
});

const imageBeforePreview = ref(null);
const imageAfterPreview = ref(null);

const handleImageBeforeChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image_before = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imageBeforePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const handleImageAfterChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image_after = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imageAfterPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.post(route('admin.projects.store'), {
        forceFormData: true,
    });
};
</script>

<template>
    <AdminLayout>
        <template #header>
            Nouveau Projet
        </template>

        <div class="max-w-4xl">
            <form @submit.prevent="submit" class="bg-white rounded-lg shadow-md p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Service -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Service <span class="text-red-500">*</span>
                        </label>
                        <select
                            v-model="form.service_id"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                        >
                            <option value="">Sélectionnez un service</option>
                            <option v-for="service in services" :key="service.id" :value="service.id">
                                {{ service.title_fr }}
                            </option>
                        </select>
                        <div v-if="form.errors.service_id" class="mt-1 text-sm text-red-600">{{ form.errors.service_id }}</div>
                    </div>

                    <!-- Title FR -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Titre (Français) <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.title_fr"
                            type="text"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="Nettoyage de Façade - Immeuble Résidentiel"
                        >
                        <div v-if="form.errors.title_fr" class="mt-1 text-sm text-red-600">{{ form.errors.title_fr }}</div>
                    </div>

                    <!-- Title NL -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Titre (Néerlandais) <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.title_nl"
                            type="text"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="Gevelreiniging - Residentieel Gebouw"
                        >
                        <div v-if="form.errors.title_nl" class="mt-1 text-sm text-red-600">{{ form.errors.title_nl }}</div>
                    </div>

                    <!-- Description FR -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description (Français) <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            v-model="form.description_fr"
                            required
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="Description détaillée du projet..."
                        ></textarea>
                        <div v-if="form.errors.description_fr" class="mt-1 text-sm text-red-600">{{ form.errors.description_fr }}</div>
                    </div>

                    <!-- Description NL -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description (Néerlandais) <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            v-model="form.description_nl"
                            required
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="Gedetailleerde beschrijving van het project..."
                        ></textarea>
                        <div v-if="form.errors.description_nl" class="mt-1 text-sm text-red-600">{{ form.errors.description_nl }}</div>
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Localisation <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.location"
                            type="text"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="Bruxelles"
                        >
                        <div v-if="form.errors.location" class="mt-1 text-sm text-red-600">{{ form.errors.location }}</div>
                    </div>

                    <!-- Completion Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Date de réalisation
                        </label>
                        <input
                            v-model="form.completion_date"
                            type="date"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                        >
                        <div v-if="form.errors.completion_date" class="mt-1 text-sm text-red-600">{{ form.errors.completion_date }}</div>
                    </div>

                    <!-- Image Before -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Image AVANT
                        </label>
                        <input
                            type="file"
                            @change="handleImageBeforeChange"
                            accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                        >
                        <p class="mt-1 text-xs text-gray-500">JPEG, PNG, JPG ou WEBP (max 2MB)</p>
                        <div v-if="form.errors.image_before" class="mt-1 text-sm text-red-600">{{ form.errors.image_before }}</div>

                        <div v-if="imageBeforePreview" class="mt-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Aperçu AVANT :</p>
                            <img :src="imageBeforePreview" alt="Preview Before" class="h-60 rounded-lg shadow-md">
                        </div>
                    </div>

                    <!-- Image After -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Image APRÈS
                        </label>
                        <input
                            type="file"
                            @change="handleImageAfterChange"
                            accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                        >
                        <p class="mt-1 text-xs text-gray-500">JPEG, PNG, JPG ou WEBP (max 2MB)</p>
                        <div v-if="form.errors.image_after" class="mt-1 text-sm text-red-600">{{ form.errors.image_after }}</div>

                        <div v-if="imageAfterPreview" class="mt-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Aperçu APRÈS :</p>
                            <img :src="imageAfterPreview" alt="Preview After" class="h-60 rounded-lg shadow-md">
                        </div>
                    </div>

                    <!-- Order -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Ordre d'affichage
                        </label>
                        <input
                            v-model.number="form.order"
                            type="number"
                            min="1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                        >
                        <p class="mt-1 text-xs text-gray-500">Plus le nombre est petit, plus il apparaît en premier</p>
                        <div v-if="form.errors.order" class="mt-1 text-sm text-red-600">{{ form.errors.order }}</div>
                    </div>

                    <!-- Checkboxes -->
                    <div class="space-y-3">
                        <label class="flex items-center cursor-pointer">
                            <input
                                v-model="form.is_featured"
                                type="checkbox"
                                class="h-5 w-5 text-primary border-gray-300 rounded focus:ring-primary"
                            >
                            <span class="ml-3 text-sm font-medium text-gray-700">
                                ⭐ Projet en vedette (affiché sur la page d'accueil)
                            </span>
                        </label>

                        <label class="flex items-center cursor-pointer">
                            <input
                                v-model="form.is_published"
                                type="checkbox"
                                class="h-5 w-5 text-primary border-gray-300 rounded focus:ring-primary"
                            >
                            <span class="ml-3 text-sm font-medium text-gray-700">Projet publié</span>
                        </label>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="mt-8 flex gap-4">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="bg-primary hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition-colors disabled:opacity-50"
                    >
                        {{ form.processing ? 'Création...' : 'Créer le projet' }}
                    </button>
                    <a
                        :href="route('admin.projects.index')"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-8 rounded-lg shadow-md transition-colors"
                    >
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
