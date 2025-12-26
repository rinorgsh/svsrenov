<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    categories: Array,
});

const form = useForm({
    gallery_category_id: '',
    title: '',
    description: '',
    type: 'image',
    file: null,
    video_url: '',
    thumbnail: null,
    order: 0,
    is_published: true,
});

const filePreview = ref(null);
const thumbnailPreview = ref(null);
const fileInfo = ref(null);
const thumbnailInfo = ref(null);

// Fonction pour formater la taille du fichier
const formatFileSize = (bytes) => {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
};

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.file = file;
        fileInfo.value = {
            name: file.name,
            size: formatFileSize(file.size),
            type: file.type
        };
        const reader = new FileReader();
        reader.onload = (e) => {
            filePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const handleThumbnailChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.thumbnail = file;
        thumbnailInfo.value = {
            name: file.name,
            size: formatFileSize(file.size),
            type: file.type
        };
        const reader = new FileReader();
        reader.onload = (e) => {
            thumbnailPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    // Créer une copie des données et retirer les champs non pertinents selon le type
    const data = { ...form.data() };

    if (form.type === 'video') {
        // Pour une vidéo, on ne veut pas envoyer 'file'
        delete data.file;
        // Si pas de thumbnail, ne pas l'envoyer
        if (!data.thumbnail) {
            delete data.thumbnail;
        }
    } else if (form.type === 'image') {
        // Pour une image, on ne veut pas envoyer 'video_url' ni 'thumbnail'
        delete data.video_url;
        delete data.thumbnail;
    }

    // Soumettre avec les données nettoyées
    form.transform(() => data).post(route('admin.gallery.store'));
};
</script>

<template>
    <AdminLayout>
        <template #header>
            Ajouter un élément à la galerie
        </template>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Type Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="radio" v-model="form.type" value="image" class="mr-2">
                            <span>Image</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" v-model="form.type" value="video" class="mr-2">
                            <span>Vidéo</span>
                        </label>
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie *</label>
                    <select
                        v-model="form.gallery_category_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        required
                    >
                        <option value="">Sélectionner une catégorie</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                    <div v-if="form.errors.gallery_category_id" class="text-red-600 text-sm mt-1">{{ form.errors.gallery_category_id }}</div>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Titre *</label>
                    <input
                        type="text"
                        v-model="form.title"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        required
                    >
                    <div v-if="form.errors.title" class="text-red-600 text-sm mt-1">{{ form.errors.title }}</div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea
                        v-model="form.description"
                        rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    ></textarea>
                </div>

                <!-- Image Upload (if type is image) -->
                <div v-if="form.type === 'image'">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image * <span class="text-xs text-gray-500">(Max 10 Mo)</span></label>
                    <input
                        type="file"
                        @change="handleFileChange"
                        accept="image/*"
                        class="w-full"
                        :required="form.type === 'image'"
                    >
                    <div v-if="fileInfo" class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-800"><strong>Fichier :</strong> {{ fileInfo.name }}</p>
                        <p class="text-sm text-blue-800"><strong>Taille :</strong> {{ fileInfo.size }}</p>
                    </div>
                    <img v-if="filePreview" :src="filePreview" class="mt-2 h-32 object-cover rounded-lg">
                    <div v-if="form.errors.file" class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm text-red-600 font-semibold">❌ {{ form.errors.file }}</p>
                    </div>
                </div>

                <!-- Video URL (if type is video) -->
                <div v-if="form.type === 'video'">
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL de la vidéo (YouTube/Vimeo) *</label>
                    <input
                        type="text"
                        v-model="form.video_url"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        placeholder="https://www.youtube.com/watch?v=... ou https://youtube.com/shorts/..."
                        :required="form.type === 'video'"
                    >
                    <p class="text-xs text-gray-500 mt-1">✅ Supporte : YouTube (normal et Shorts), Vimeo</p>
                    <div v-if="form.errors.video_url" class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm text-red-600 font-semibold">❌ {{ form.errors.video_url }}</p>
                    </div>

                    <!-- Thumbnail for video -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Miniature (optionnel)
                            <span class="text-xs text-gray-500">(Max 10 Mo - Laissez vide pour utiliser la miniature YouTube)</span>
                        </label>
                        <input
                            type="file"
                            @change="handleThumbnailChange"
                            accept="image/*"
                            class="w-full"
                        >
                        <div v-if="thumbnailInfo" class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-800"><strong>Fichier :</strong> {{ thumbnailInfo.name }}</p>
                            <p class="text-sm text-blue-800"><strong>Taille :</strong> {{ thumbnailInfo.size }}</p>
                        </div>
                        <img v-if="thumbnailPreview" :src="thumbnailPreview" class="mt-2 h-32 object-cover rounded-lg">
                        <div v-if="form.errors.thumbnail" class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm text-red-600 font-semibold">❌ {{ form.errors.thumbnail }}</p>
                        </div>
                    </div>
                </div>

                <!-- Order -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ordre d'affichage</label>
                    <input
                        type="number"
                        v-model.number="form.order"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    >
                </div>

                <!-- Published Status -->
                <div>
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            v-model="form.is_published"
                            class="rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        >
                        <span class="ml-2 text-sm text-gray-700">Publier immédiatement</span>
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-4">
                    <Link
                        :href="route('admin.gallery.index')"
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
