<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    category: Object,
});

const form = useForm({
    name: props.category.name,
    slug: props.category.slug,
    description: props.category.description,
    order: props.category.order,
    is_active: props.category.is_active,
});

const submit = () => {
    form.put(route('admin.gallery-categories.update', props.category.id));
};
</script>

<template>
    <AdminLayout>
        <template #header>
            Modifier la Catégorie
        </template>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                    <input type="text" v-model="form.name" class="w-full border-gray-300 rounded-lg" required>
                    <div v-if="form.errors.name" class="text-red-600 text-sm mt-1">{{ form.errors.name }}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug (optionnel)</label>
                    <input type="text" v-model="form.slug" class="w-full border-gray-300 rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea v-model="form.description" rows="3" class="w-full border-gray-300 rounded-lg"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ordre</label>
                    <input type="number" v-model.number="form.order" class="w-full border-gray-300 rounded-lg">
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" v-model="form.is_active" class="rounded border-gray-300 text-primary">
                        <span class="ml-2 text-sm text-gray-700">Actif</span>
                    </label>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-4">
                    <Link :href="route('admin.gallery-categories.index')" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Annuler
                    </Link>
                    <button type="submit" :disabled="form.processing" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-red-700">
                        {{ form.processing ? 'Enregistrement...' : 'Enregistrer' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
