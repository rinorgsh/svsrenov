<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    hero: Object,
});

const form = useForm({
    page: props.hero.page,
    image: null,
    title_fr: props.hero.title_fr || '',
    title_nl: props.hero.title_nl || '',
    subtitle_fr: props.hero.subtitle_fr || '',
    subtitle_nl: props.hero.subtitle_nl || '',
    is_active: props.hero.is_active,
});

const imagePreview = ref(props.hero.image_path ? `/storage/${props.hero.image_path}` : null);
const imageInfo = ref(null);

// Fonction pour formater la taille du fichier
const formatFileSize = (bytes) => {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
};

const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        imageInfo.value = {
            name: file.name,
            size: formatFileSize(file.size),
            type: file.type
        };
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.transform((data) => ({
        ...data,
        _method: 'PUT',
    })).post(route('admin.hero.update', props.hero.id));
};
</script>

<template>
    <AdminLayout>
        <template #header>
            Modifier le Hero - {{ hero.page }}
        </template>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Page (readonly) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Page</label>
                    <input
                        type="text"
                        v-model="form.page"
                        class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-100"
                        readonly
                    >
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Image Hero <span class="text-xs text-gray-500">(Max 10 Mo - Dimensions recommandées : 1920x1080 ou similaire)</span>
                    </label>
                    <input
                        type="file"
                        @change="handleImageChange"
                        accept="image/*"
                        class="w-full"
                    >
                    <div v-if="imageInfo" class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-800"><strong>Fichier :</strong> {{ imageInfo.name }}</p>
                        <p class="text-sm text-blue-800"><strong>Taille :</strong> {{ imageInfo.size }}</p>
                    </div>
                    <img v-if="imagePreview" :src="imagePreview" class="mt-4 h-48 w-full object-cover rounded-lg">
                    <div v-if="form.errors.image" class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm text-red-600 font-semibold">❌ {{ form.errors.image }}</p>
                    </div>
                </div>

                <!-- Title FR -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Titre (Français)</label>
                    <input
                        type="text"
                        v-model="form.title_fr"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    >
                    <div v-if="form.errors.title_fr" class="text-red-600 text-sm mt-1">{{ form.errors.title_fr }}</div>
                </div>

                <!-- Title NL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Titre (Néerlandais)</label>
                    <input
                        type="text"
                        v-model="form.title_nl"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    >
                    <div v-if="form.errors.title_nl" class="text-red-600 text-sm mt-1">{{ form.errors.title_nl }}</div>
                </div>

                <!-- Subtitle FR -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sous-titre (Français)</label>
                    <textarea
                        v-model="form.subtitle_fr"
                        rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    ></textarea>
                    <div v-if="form.errors.subtitle_fr" class="text-red-600 text-sm mt-1">{{ form.errors.subtitle_fr }}</div>
                </div>

                <!-- Subtitle NL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sous-titre (Néerlandais)</label>
                    <textarea
                        v-model="form.subtitle_nl"
                        rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    ></textarea>
                    <div v-if="form.errors.subtitle_nl" class="text-red-600 text-sm mt-1">{{ form.errors.subtitle_nl }}</div>
                </div>

                <!-- Active Status -->
                <div>
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            v-model="form.is_active"
                            class="rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        >
                        <span class="ml-2 text-sm text-gray-700">Actif</span>
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-4">
                    <Link
                        :href="route('admin.hero.index')"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
                    >
                        Annuler
                    </Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-red-700 transition-colors disabled:opacity-50"
                    >
                        {{ form.processing ? 'Enregistrement...' : 'Enregistrer' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
