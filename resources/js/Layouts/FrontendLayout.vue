<script setup>
import { Head } from '@inertiajs/vue3';
import Header from '@/Components/Frontend/Header.vue';
import Footer from '@/Components/Frontend/Footer.vue';

defineProps({
    title: String,
});
</script>

<template>
    <div class="min-h-screen bg-white flex flex-col overflow-x-hidden">
        <Head :title="title || 'SVS RENOV'" />

        <Header />

        <main class="flex-grow overflow-x-hidden w-full">
            <slot />
        </main>

        <Footer />
    </div>
</template>
