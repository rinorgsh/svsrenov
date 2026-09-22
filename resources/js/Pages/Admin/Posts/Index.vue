<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    posts: Array,
});

const deletePost = (id) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
        router.delete(route('admin.posts.destroy', id));
    }
};
</script>

<template>
    <AdminLayout>
        <template #header>Blog</template>

        <div class="mb-6 flex items-center justify-between">
            <p class="text-gray-600">{{ posts.length }} article(s)</p>
            <Link
                :href="route('admin.posts.create')"
                class="rounded-lg bg-primary px-4 py-2 font-medium text-white transition-colors hover:bg-primary/90"
            >
                + Nouvel article
            </Link>
        </div>

        <div class="overflow-hidden rounded-lg bg-white shadow-md">
            <div v-if="!posts.length" class="p-12 text-center text-gray-500">
                Aucun article pour l'instant. Commencez par en écrire un !
            </div>
            <table v-else class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Article</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">NL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="post in posts" :key="post.id">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <img v-if="post.cover" :src="post.cover" alt="" class="h-12 w-16 rounded object-cover">
                                <div v-else class="h-12 w-16 rounded bg-gray-100"></div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ post.title_fr }}</p>
                                    <p class="text-xs text-gray-400">/blog/{{ post.slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span v-if="post.has_nl" class="text-green-600">✓</span>
                            <span v-else class="text-gray-400" title="Sans traduction, la version FR est affichée en NL">—</span>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex rounded-full px-2 py-1 text-xs font-semibold"
                                :class="post.is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                            >
                                {{ post.is_published ? 'Publié' : 'Brouillon' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ post.published_at || '—' }}</td>
                        <td class="space-x-3 whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <a
                                v-if="post.is_published"
                                :href="route('blog.show', post.slug)"
                                target="_blank"
                                class="text-gray-500 hover:text-gray-900"
                            >Voir</a>
                            <Link :href="route('admin.posts.edit', post.id)" class="text-primary hover:text-primary/80">Modifier</Link>
                            <button class="text-red-600 hover:text-red-800" @click="deletePost(post.id)">Supprimer</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
