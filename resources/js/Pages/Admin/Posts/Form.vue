<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    post: Object,
    services: Array,
});

const isEdit = computed(() => !!props.post);
const lang = ref('fr');

const form = useForm({
    slug: props.post?.slug ?? '',
    title_fr: props.post?.title_fr ?? '',
    title_nl: props.post?.title_nl ?? '',
    excerpt_fr: props.post?.excerpt_fr ?? '',
    excerpt_nl: props.post?.excerpt_nl ?? '',
    content_fr: props.post?.content_fr ?? '',
    content_nl: props.post?.content_nl ?? '',
    service_id: props.post?.service_id ?? '',
    is_published: props.post?.is_published ?? false,
    published_at: props.post?.published_at ?? '',
    cover_image: null,
});

const coverPreview = ref(props.post?.cover ?? null);

const onCoverChange = (event) => {
    const file = event.target.files[0];
    if (!file) return;
    form.cover_image = file;
    coverPreview.value = URL.createObjectURL(file);
};

const submit = () => {
    if (isEdit.value) {
        form.transform((data) => ({ ...data, _method: 'PUT' }))
            .post(route('admin.posts.update', props.post.id), { forceFormData: true });
    } else {
        form.post(route('admin.posts.store'), { forceFormData: true });
    }
};

const inputClass = 'w-full rounded-lg border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50';
</script>

<template>
    <AdminLayout>
        <template #header>{{ isEdit ? 'Modifier l\'article' : 'Nouvel article' }}</template>

        <form class="grid gap-6 lg:grid-cols-3" @submit.prevent="submit">
            <!-- Contenu -->
            <div class="space-y-6 rounded-lg bg-white p-6 shadow-md lg:col-span-2">
                <div class="flex gap-2 border-b border-gray-200 pb-4">
                    <button
                        v-for="l in ['fr', 'nl']"
                        :key="l"
                        type="button"
                        class="rounded-full px-4 py-1.5 text-sm font-semibold uppercase"
                        :class="lang === l ? 'bg-secondary text-white' : 'bg-gray-100 text-gray-600'"
                        @click="lang = l"
                    >
                        {{ l }}{{ l === 'fr' ? ' *' : '' }}
                    </button>
                    <p v-if="lang === 'nl'" class="ml-2 self-center text-xs text-gray-500">
                        Optionnel : si vide, la version FR est affichée.
                    </p>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Titre</label>
                    <input v-model="form[`title_${lang}`]" type="text" :class="inputClass" :required="lang === 'fr'">
                    <p v-if="form.errors[`title_${lang}`]" class="mt-1 text-sm text-red-600">{{ form.errors[`title_${lang}`] }}</p>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Résumé <span class="font-normal text-gray-400">(affiché dans les listes et sur Google, ~160 caractères)</span></label>
                    <textarea v-model="form[`excerpt_${lang}`]" rows="2" maxlength="500" :class="inputClass"></textarea>
                    <p class="mt-1 text-right text-xs text-gray-400">{{ (form[`excerpt_${lang}`] || '').length }} / 160</p>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Contenu</label>
                    <textarea v-model="form[`content_${lang}`]" rows="22" :class="[inputClass, 'font-mono text-sm']" :required="lang === 'fr'"></textarea>
                    <p v-if="form.errors[`content_${lang}`]" class="mt-1 text-sm text-red-600">{{ form.errors[`content_${lang}`] }}</p>
                    <details class="mt-2 text-xs text-gray-500">
                        <summary class="cursor-pointer font-medium">Aide mise en forme (Markdown)</summary>
                        <div class="mt-2 grid grid-cols-2 gap-x-6 gap-y-1 rounded bg-gray-50 p-3 font-mono">
                            <span>## Titre de section</span><span>Grand intertitre</span>
                            <span>### Sous-titre</span><span>Petit intertitre</span>
                            <span>**texte**</span><span><strong>gras</strong></span>
                            <span>- élément</span><span>liste à puces</span>
                            <span>1. élément</span><span>liste numérotée</span>
                            <span>[texte](https://…)</span><span>lien</span>
                            <span>&gt; citation</span><span>encadré</span>
                            <span>(ligne vide)</span><span>nouveau paragraphe</span>
                        </div>
                    </details>
                </div>
            </div>

            <!-- Réglages -->
            <div class="space-y-6">
                <div class="space-y-5 rounded-lg bg-white p-6 shadow-md">
                    <label class="flex items-center gap-3">
                        <input v-model="form.is_published" type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary">
                        <span class="text-sm font-medium text-gray-700">Publié sur le site</span>
                    </label>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">Date de publication</label>
                        <input v-model="form.published_at" type="date" :class="inputClass">
                        <p class="mt-1 text-xs text-gray-400">Vide = aujourd'hui. Une date future programme l'article.</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">Adresse (slug)</label>
                        <div class="flex items-center rounded-lg border border-gray-300 text-sm">
                            <span class="pl-3 text-gray-400">/blog/</span>
                            <input v-model="form.slug" type="text" class="w-full border-0 bg-transparent py-2 pl-1 text-sm focus:ring-0" placeholder="généré depuis le titre">
                        </div>
                        <p v-if="form.errors.slug" class="mt-1 text-sm text-red-600">{{ form.errors.slug }}</p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">Service lié</label>
                        <select v-model="form.service_id" :class="inputClass">
                            <option value="">Aucun</option>
                            <option v-for="service in services" :key="service.id" :value="service.id">{{ service.title_fr }}</option>
                        </select>
                    </div>
                </div>

                <div class="rounded-lg bg-white p-6 shadow-md">
                    <label class="mb-2 block text-sm font-medium text-gray-700">Image de couverture</label>
                    <img v-if="coverPreview" :src="coverPreview" alt="" class="mb-3 aspect-[16/10] w-full rounded-lg object-cover">
                    <input type="file" accept="image/jpeg,image/png,image/webp" class="w-full text-sm" @change="onCoverChange">
                    <p v-if="form.errors.cover_image" class="mt-1 text-sm text-red-600">{{ form.errors.cover_image }}</p>
                </div>

                <div class="flex gap-3">
                    <Link :href="route('admin.posts.index')" class="flex-1 rounded-lg bg-gray-100 px-4 py-3 text-center font-medium text-gray-700 hover:bg-gray-200">
                        Annuler
                    </Link>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="flex-1 rounded-lg bg-primary px-4 py-3 font-medium text-white hover:bg-primary/90 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Enregistrement…' : 'Enregistrer' }}
                    </button>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
