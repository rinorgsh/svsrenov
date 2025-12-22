<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    slug: '',
    icon: '',
    title_fr: '',
    title_nl: '',
    description_fr: '',
    description_nl: '',
    long_description_fr: '',
    long_description_nl: '',
    image: null,
    order: 1,
    is_active: true,
});

const imagePreview = ref(null);

const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.post(route('admin.services.store'), {
        forceFormData: true,
    });
};
</script>

<template>
    <AdminLayout>
        <template #header>
            Nouveau Service
        </template>

        <div class="max-w-4xl">
            <form @submit.prevent="submit" class="bg-white rounded-lg shadow-md p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Slug <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="form.slug"
                            type="text"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="nettoyage"
                        >
                        <p class="mt-1 text-xs text-gray-500">URL-friendly (ex: nettoyage-facade)</p>
                        <div v-if="form.errors.slug" class="mt-1 text-sm text-red-600">{{ form.errors.slug }}</div>
                    </div>

                    <!-- Icon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Icône
                        </label>
                        <input
                            v-model="form.icon"
                            type="text"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="🧹"
                        >
                        <p class="mt-1 text-xs text-gray-500">Emoji ou classe d'icône</p>
                        <div v-if="form.errors.icon" class="mt-1 text-sm text-red-600">{{ form.errors.icon }}</div>
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
                            placeholder="Nettoyage de façade"
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
                            placeholder="Gevelreiniging"
                        >
                        <div v-if="form.errors.title_nl" class="mt-1 text-sm text-red-600">{{ form.errors.title_nl }}</div>
                    </div>

                    <!-- Description FR -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description courte (Français) <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            v-model="form.description_fr"
                            required
                            rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="Une brève description du service..."
                        ></textarea>
                        <div v-if="form.errors.description_fr" class="mt-1 text-sm text-red-600">{{ form.errors.description_fr }}</div>
                    </div>

                    <!-- Description NL -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description courte (Néerlandais) <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            v-model="form.description_nl"
                            required
                            rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="Een korte beschrijving van de dienst..."
                        ></textarea>
                        <div v-if="form.errors.description_nl" class="mt-1 text-sm text-red-600">{{ form.errors.description_nl }}</div>
                    </div>

                    <!-- Long Description FR -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description longue (Français)
                        </label>
                        <textarea
                            v-model="form.long_description_fr"
                            rows="5"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="Description détaillée du service..."
                        ></textarea>
                        <div v-if="form.errors.long_description_fr" class="mt-1 text-sm text-red-600">{{ form.errors.long_description_fr }}</div>
                    </div>

                    <!-- Long Description NL -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description longue (Néerlandais)
                        </label>
                        <textarea
                            v-model="form.long_description_nl"
                            rows="5"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="Gedetailleerde beschrijving van de dienst..."
                        ></textarea>
                        <div v-if="form.errors.long_description_nl" class="mt-1 text-sm text-red-600">{{ form.errors.long_description_nl }}</div>
                    </div>

                    <!-- Image Upload -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Image
                        </label>
                        <input
                            type="file"
                            @change="handleImageChange"
                            accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                        >
                        <p class="mt-1 text-xs text-gray-500">JPEG, PNG, JPG ou WEBP (max 2MB)</p>
                        <div v-if="form.errors.image" class="mt-1 text-sm text-red-600">{{ form.errors.image }}</div>

                        <!-- Image Preview -->
                        <div v-if="imagePreview" class="mt-4">
                            <img :src="imagePreview" alt="Preview" class="h-40 rounded-lg shadow-md">
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

                    <!-- Is Active -->
                    <div class="flex items-center">
                        <label class="flex items-center cursor-pointer">
                            <input
                                v-model="form.is_active"
                                type="checkbox"
                                class="h-5 w-5 text-primary border-gray-300 rounded focus:ring-primary"
                            >
                            <span class="ml-3 text-sm font-medium text-gray-700">Service actif</span>
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
                        {{ form.processing ? 'Création...' : 'Créer le service' }}
                    </button>
                    <a
                        :href="route('admin.services.index')"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-8 rounded-lg shadow-md transition-colors"
                    >
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
