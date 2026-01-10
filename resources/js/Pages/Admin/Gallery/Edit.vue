<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    gallery: Object,
    categories: Array,
});

const form = useForm({
    gallery_category_id: props.gallery.gallery_category_id,
    title: props.gallery.title,
    description: props.gallery.description,
    type: props.gallery.type,
    file: null,
    video_url: props.gallery.video_url,
    thumbnail: null,
    order: props.gallery.order,
    is_published: props.gallery.is_published,
});

const filePreview = ref(props.gallery.file_path ? `/storage/${props.gallery.file_path}` : null);
const thumbnailPreview = ref(props.gallery.thumbnail_path ? `/storage/${props.gallery.thumbnail_path}` : null);

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.file = file;
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
        const reader = new FileReader();
        reader.onload = (e) => {
            thumbnailPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.transform((data) => ({
        ...data,
        _method: 'PUT',
    })).post(route('admin.gallery.update', props.gallery.id));
};
</script>

<template>
    <AdminLayout>
        <template #header>
            Modifier un élément de la galerie
        </template>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Type (read-only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <div class="text-gray-900">
                        {{ form.type === 'image' ? 'Image' : 'Vidéo' }}
                    </div>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Titre</label>
                    <input
                        type="text"
                        v-model="form.title"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                    <input
                        type="file"
                        @change="handleFileChange"
                        accept="image/*"
                        class="w-full"
                    >
                    <img v-if="filePreview" :src="filePreview" class="mt-2 h-32 object-cover rounded-lg">
                    <div v-if="form.errors.file" class="text-red-600 text-sm mt-1">{{ form.errors.file }}</div>
                </div>

                <!-- Video URL (if type is video) -->
                <div v-if="form.type === 'video'">
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL de la vidéo (YouTube/Vimeo) *</label>
                    <input
                        type="text"
                        v-model="form.video_url"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        placeholder="https://www.youtube.com/watch?v=..."
                        :required="form.type === 'video'"
                    >
                    <div v-if="form.errors.video_url" class="text-red-600 text-sm mt-1">{{ form.errors.video_url }}</div>

                    <!-- Thumbnail for video -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Miniature</label>
                        <input
                            type="file"
                            @change="handleThumbnailChange"
                            accept="image/*"
                            class="w-full"
                        >
                        <img v-if="thumbnailPreview" :src="thumbnailPreview" class="mt-2 h-32 object-cover rounded-lg">
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
                        <span class="ml-2 text-sm text-gray-700">Publié</span>
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
