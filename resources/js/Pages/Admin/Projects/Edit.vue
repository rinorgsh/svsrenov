<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    project: Object,
    services: Array,
});

// === Additional gallery images ===
const galleryImages = ref([...(props.project.images || [])]);
const uploadQueue = ref([]); // { id, name, progress, error }
const dragIndex = ref(null);
const fileInput = ref(null);
const isDragOver = ref(false);

const triggerFilePicker = () => fileInput.value?.click();

const handleFilesSelected = (e) => {
    const files = Array.from(e.target.files || []);
    files.forEach(uploadFile);
    e.target.value = '';
};

const handleDrop = (e) => {
    e.preventDefault();
    isDragOver.value = false;
    const files = Array.from(e.dataTransfer.files || []).filter(f => f.type.startsWith('image/'));
    files.forEach(uploadFile);
};

const uploadFile = (file) => {
    const ticket = { id: Math.random().toString(36).slice(2), name: file.name, progress: 0, error: null };
    uploadQueue.value.push(ticket);

    const data = new FormData();
    data.append('image', file);

    axios.post(route('admin.projects.images.store', props.project.id), data, {
        onUploadProgress: (p) => {
            if (p.total) ticket.progress = Math.round((p.loaded / p.total) * 100);
        },
    }).then((res) => {
        galleryImages.value.push(res.data.image);
        uploadQueue.value = uploadQueue.value.filter(t => t.id !== ticket.id);
    }).catch((err) => {
        ticket.error = err.response?.data?.message || 'Erreur d\'upload';
        ticket.progress = 0;
    });
};

const removeGalleryImage = (img) => {
    if (!confirm('Supprimer cette photo ?')) return;
    axios.delete(route('admin.projects.images.destroy', [props.project.id, img.id]))
        .then(() => {
            galleryImages.value = galleryImages.value.filter(i => i.id !== img.id);
        });
};

const saveCaption = (img) => {
    axios.put(route('admin.projects.images.update', [props.project.id, img.id]), {
        caption_fr: img.caption_fr,
        caption_nl: img.caption_nl,
    });
};

const onDragStart = (index) => { dragIndex.value = index; };
const onDragOverItem = (e, index) => {
    e.preventDefault();
    if (dragIndex.value === null || dragIndex.value === index) return;
    const moved = galleryImages.value.splice(dragIndex.value, 1)[0];
    galleryImages.value.splice(index, 0, moved);
    dragIndex.value = index;
};
const onDragEnd = () => {
    dragIndex.value = null;
    axios.post(route('admin.projects.images.reorder', props.project.id), {
        ids: galleryImages.value.map(i => i.id),
    });
};
const dismissError = (ticket) => {
    uploadQueue.value = uploadQueue.value.filter(t => t.id !== ticket.id);
};

const form = useForm({
    service_id: props.project.service_id,
    services: props.project.services || [],
    title_fr: props.project.title_fr,
    title_nl: props.project.title_nl,
    description_fr: props.project.description_fr,
    description_nl: props.project.description_nl,
    location: props.project.location,
    image_before: null,
    image_after: null,
    completion_date: props.project.completion_date || '',
    is_featured: props.project.is_featured,
    is_published: props.project.is_published,
    order: props.project.order,
});

const newService = ref('');

const addService = () => {
    if (newService.value.trim() && !form.services.includes(newService.value.trim())) {
        form.services.push(newService.value.trim());
        newService.value = '';
    }
};

const removeService = (index) => {
    form.services.splice(index, 1);
};

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
    form.transform((data) => ({
        ...data,
        _method: 'PUT'
    })).post(route('admin.projects.update', props.project.id), {
        forceFormData: true,
    });
};
</script>

<template>
    <AdminLayout>
        <template #header>
            Modifier le Projet
        </template>

        <div class="max-w-4xl">
            <form @submit.prevent="submit" class="bg-white rounded-lg shadow-md p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Services (Tags) -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Services
                        </label>

                        <!-- Input to add new service -->
                        <div class="flex gap-2 mb-3">
                            <input
                                v-model="newService"
                                @keydown.enter.prevent="addService"
                                type="text"
                                placeholder="Entrez un service (ex: Nettoyage, Peinture...)"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                            >
                            <button
                                type="button"
                                @click="addService"
                                class="px-6 py-2 bg-primary text-white font-semibold rounded-lg hover:bg-red-700 transition-colors"
                            >
                                Ajouter
                            </button>
                        </div>

                        <!-- Display added services as tags -->
                        <div v-if="form.services.length > 0" class="flex flex-wrap gap-2">
                            <div
                                v-for="(service, index) in form.services"
                                :key="index"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary font-medium rounded-full"
                            >
                                <span>{{ service }}</span>
                                <button
                                    type="button"
                                    @click="removeService(index)"
                                    class="text-primary hover:text-red-700 font-bold"
                                >
                                    ×
                                </button>
                            </div>
                        </div>

                        <p class="mt-2 text-xs text-gray-500">
                            Appuyez sur Entrée ou cliquez sur "Ajouter" pour ajouter un service
                        </p>
                        <div v-if="form.errors.services" class="mt-1 text-sm text-red-600">{{ form.errors.services }}</div>
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

                    <!-- Current Images -->
                    <div v-if="project.image_before || project.image_after" class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Images actuelles
                        </label>
                        <div class="flex gap-4">
                            <div v-if="project.image_before">
                                <p class="text-xs text-gray-500 mb-1">AVANT</p>
                                <img :src="project.image_before" :alt="`${project.title_fr} - Avant`" class="h-40 rounded-lg shadow-md">
                            </div>
                            <div v-if="project.image_after">
                                <p class="text-xs text-gray-500 mb-1">APRÈS</p>
                                <img :src="project.image_after" :alt="`${project.title_fr} - Après`" class="h-40 rounded-lg shadow-md">
                            </div>
                        </div>
                    </div>

                    <!-- Image Before -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ project.image_before ? 'Changer l\'image AVANT' : 'Ajouter une image AVANT' }}
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
                            <p class="text-sm font-medium text-gray-700 mb-2">Nouvelle image AVANT :</p>
                            <img :src="imageBeforePreview" alt="Preview Before" class="h-60 rounded-lg shadow-md">
                        </div>
                    </div>

                    <!-- Image After -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ project.image_after ? 'Changer l\'image APRÈS' : 'Ajouter une image APRÈS' }}
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
                            <p class="text-sm font-medium text-gray-700 mb-2">Nouvelle image APRÈS :</p>
                            <img :src="imageAfterPreview" alt="Preview After" class="h-60 rounded-lg shadow-md">
                        </div>
                    </div>

                    <!-- Additional Photos Gallery -->
                    <div class="md:col-span-2 border-t pt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Photos supplémentaires
                        </label>
                        <p class="text-xs text-gray-500 mb-4">
                            Ces photos apparaissent dans la fenêtre qui s'ouvre quand un visiteur clique sur le projet. Glissez-déposez plusieurs images d'un coup.
                        </p>

                        <!-- Drop zone -->
                        <div
                            @click="triggerFilePicker"
                            @dragover.prevent="isDragOver = true"
                            @dragleave.prevent="isDragOver = false"
                            @drop="handleDrop"
                            :class="[
                                'border-2 border-dashed rounded-lg p-6 text-center cursor-pointer transition-colors',
                                isDragOver ? 'border-primary bg-primary/5' : 'border-gray-300 hover:border-primary hover:bg-gray-50'
                            ]"
                        >
                            <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold text-primary">Cliquez pour choisir</span> ou glissez-déposez des images
                            </p>
                            <p class="text-xs text-gray-400 mt-1">JPEG, PNG, JPG, WEBP · max 4 Mo par image</p>
                            <input ref="fileInput" type="file" multiple accept="image/*" @change="handleFilesSelected" class="hidden">
                        </div>

                        <!-- Upload queue -->
                        <div v-if="uploadQueue.length > 0" class="mt-4 space-y-2">
                            <div v-for="ticket in uploadQueue" :key="ticket.id" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg text-sm">
                                <div class="flex-1 min-w-0">
                                    <p class="truncate font-medium text-gray-700">{{ ticket.name }}</p>
                                    <div v-if="!ticket.error" class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                        <div class="bg-primary h-1.5 rounded-full transition-all" :style="{ width: ticket.progress + '%' }"></div>
                                    </div>
                                    <p v-else class="text-red-600 text-xs mt-1">{{ ticket.error }}</p>
                                </div>
                                <button v-if="ticket.error" type="button" @click="dismissError(ticket)" class="text-gray-400 hover:text-gray-600">×</button>
                                <span v-else class="text-xs text-gray-500 w-10 text-right">{{ ticket.progress }}%</span>
                            </div>
                        </div>

                        <!-- Thumbnails grid -->
                        <div v-if="galleryImages.length > 0" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div
                                v-for="(img, index) in galleryImages"
                                :key="img.id"
                                draggable="true"
                                @dragstart="onDragStart(index)"
                                @dragover="onDragOverItem($event, index)"
                                @dragend="onDragEnd"
                                class="relative group bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden cursor-move"
                            >
                                <img :src="img.path" :alt="img.caption_fr || 'Photo'" class="w-full h-32 object-cover">

                                <button
                                    type="button"
                                    @click="removeGalleryImage(img)"
                                    class="absolute top-1 right-1 w-7 h-7 flex items-center justify-center bg-red-600 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity shadow-md hover:bg-red-700"
                                    title="Supprimer"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>

                                <div class="absolute top-1 left-1 w-6 h-6 flex items-center justify-center bg-black/60 text-white rounded text-xs font-bold">
                                    {{ index + 1 }}
                                </div>

                                <div class="p-2 space-y-1">
                                    <input
                                        v-model="img.caption_fr"
                                        @blur="saveCaption(img)"
                                        type="text"
                                        placeholder="Légende FR (optionnel)"
                                        class="w-full text-xs px-2 py-1 border border-gray-200 rounded focus:ring-1 focus:ring-primary focus:border-primary"
                                    >
                                    <input
                                        v-model="img.caption_nl"
                                        @blur="saveCaption(img)"
                                        type="text"
                                        placeholder="Légende NL (optionnel)"
                                        class="w-full text-xs px-2 py-1 border border-gray-200 rounded focus:ring-1 focus:ring-primary focus:border-primary"
                                    >
                                </div>
                            </div>
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
                        {{ form.processing ? 'Mise à jour...' : 'Mettre à jour' }}
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
