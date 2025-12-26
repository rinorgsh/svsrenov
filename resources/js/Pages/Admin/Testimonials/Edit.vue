<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    testimonial: Object,
});

const form = useForm({
    client_name: props.testimonial.client_name,
    client_company: props.testimonial.client_company || '',
    comment_fr: props.testimonial.comment_fr,
    comment_nl: props.testimonial.comment_nl || '',
    rating: props.testimonial.rating,
    client_photo: null,
    order: props.testimonial.order,
    is_published: props.testimonial.is_published,
});

const photoPreview = ref(props.testimonial.client_photo ? `/storage/${props.testimonial.client_photo}` : null);

const handlePhotoChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.client_photo = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            photoPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.transform((data) => ({
        ...data,
        _method: 'PUT',
    })).post(route('admin.testimonials.update', props.testimonial.id));
};
</script>

<template>
    <AdminLayout>
        <template #header>
            Modifier le témoignage
        </template>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Client Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom du client *</label>
                    <input
                        type="text"
                        v-model="form.client_name"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        required
                    >
                    <div v-if="form.errors.client_name" class="text-red-600 text-sm mt-1">{{ form.errors.client_name }}</div>
                </div>

                <!-- Client Company -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Entreprise</label>
                    <input
                        type="text"
                        v-model="form.client_company"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    >
                    <div v-if="form.errors.client_company" class="text-red-600 text-sm mt-1">{{ form.errors.client_company }}</div>
                </div>

                <!-- Comment FR -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Commentaire (Français) *</label>
                    <textarea
                        v-model="form.comment_fr"
                        rows="4"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                        required
                    ></textarea>
                    <div v-if="form.errors.comment_fr" class="text-red-600 text-sm mt-1">{{ form.errors.comment_fr }}</div>
                </div>

                <!-- Comment NL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Commentaire (Néerlandais)</label>
                    <textarea
                        v-model="form.comment_nl"
                        rows="4"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    ></textarea>
                    <div v-if="form.errors.comment_nl" class="text-red-600 text-sm mt-1">{{ form.errors.comment_nl }}</div>
                </div>

                <!-- Rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Note *</label>
                    <div class="flex gap-4 items-center">
                        <input
                            type="range"
                            v-model.number="form.rating"
                            min="1"
                            max="5"
                            class="flex-1"
                        >
                        <div class="flex gap-0.5">
                            <svg v-for="star in 5" :key="star" class="w-6 h-6" :class="star <= form.rating ? 'text-primary' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <span class="text-lg font-semibold text-gray-700">{{ form.rating }}/5</span>
                    </div>
                    <div v-if="form.errors.rating" class="text-red-600 text-sm mt-1">{{ form.errors.rating }}</div>
                </div>

                <!-- Client Photo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Photo du client</label>
                    <input
                        type="file"
                        @change="handlePhotoChange"
                        accept="image/*"
                        class="w-full"
                    >
                    <img v-if="photoPreview" :src="photoPreview" class="mt-2 h-32 w-32 rounded-full object-cover">
                    <div v-if="form.errors.client_photo" class="text-red-600 text-sm mt-1">{{ form.errors.client_photo }}</div>
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
                        :href="route('admin.testimonials.index')"
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
