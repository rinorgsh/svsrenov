<script setup>
import { computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import PageHero from '@/Components/Frontend/PageHero.vue';
import { useTranslations } from '@/Composables/useTranslations';

const { t } = useTranslations();
const page = usePage();

const props = defineProps({
    services: { type: Array, default: () => [] },
    hero: Object,
    googleReviewStats: Object,
});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    service_id: '',
    message: '',
    website: '', // honeypot anti-spam, doit rester vide
});

const submit = () => {
    form.post(route('contact.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

const success = computed(() => page.props.flash?.success);
const rating = computed(() => (props.googleReviewStats?.average_rating ?? 0).toFixed(1).replace('.', ','));

const reasons = computed(() => [
    t('contact_free_quote_label'),
    t('contact_fast_response'),
    t('contact_expert_advice'),
    t('contact_years_experience'),
]);

const inputClass = (field) => [
    'w-full rounded-2xl border-0 bg-surface-2 px-4 py-3.5 text-fg ring-1 ring-inset transition placeholder:text-fg-soft focus:bg-white focus:ring-2 focus:ring-primary',
    form.errors[field] ? 'ring-red-400' : 'ring-gray-200',
];
</script>

<template>
    <FrontendLayout :title="t('contact')">
        <PageHero
            :image="hero?.image_url"
            fallback="/image/camionette.jpeg"
            :eyebrow="t('contact_us_title')"
            :title="t('seo_contact_title')"
            :lead="t('contact_page_lead')"
        />

        <section class="theme-light bg-surface-2 py-16 md:py-24">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-12 lg:gap-12 lg:px-8">
                <!-- Formulaire -->
                <div class="rounded-[2rem] bg-surface-3 p-6 ring-1 ring-line/10 sm:p-10 lg:col-span-7 lg:shadow-xl lg:shadow-black/5">
                    <h2 class="text-3xl font-extrabold text-fg">{{ t('contact_form_title') }}</h2>
                    <p class="mt-2 text-fg-muted">{{ t('contact_form_subtitle') }}</p>

                    <div
                        v-if="success"
                        class="mt-6 flex items-start gap-3 rounded-2xl bg-green-50 px-5 py-4 text-green-800 ring-1 ring-green-200"
                        role="status"
                    >
                        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        <div>
                            <p class="font-semibold">{{ t('contact_message_success') }}</p>
                            <p class="text-sm">{{ t('contact_fast_response') }}</p>
                        </div>
                    </div>

                    <form class="relative mt-8 space-y-5" novalidate @submit.prevent="submit">
                        <!-- Honeypot anti-spam (invisible pour les humains) -->
                        <div class="absolute -left-[9999px] h-px w-px overflow-hidden" aria-hidden="true">
                            <label for="website">Website</label>
                            <input id="website" v-model="form.website" type="text" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div>
                            <label for="name" class="mb-2 block text-sm font-semibold text-fg">{{ t('contact_name') }} *</label>
                            <input id="name" v-model="form.name" type="text" autocomplete="name" required :placeholder="t('contact_name_placeholder')" :class="inputClass('name')">
                            <p v-if="form.errors.name" class="mt-1.5 text-sm text-red-600">{{ form.errors.name }}</p>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="email" class="mb-2 block text-sm font-semibold text-fg">{{ t('contact_email') }} *</label>
                                <input id="email" v-model="form.email" type="email" autocomplete="email" required :placeholder="t('contact_email_placeholder')" :class="inputClass('email')">
                                <p v-if="form.errors.email" class="mt-1.5 text-sm text-red-600">{{ form.errors.email }}</p>
                            </div>
                            <div>
                                <label for="phone" class="mb-2 block text-sm font-semibold text-fg">{{ t('contact_phone') }}</label>
                                <input id="phone" v-model="form.phone" type="tel" autocomplete="tel" :placeholder="t('contact_phone_placeholder')" :class="inputClass('phone')">
                                <p v-if="form.errors.phone" class="mt-1.5 text-sm text-red-600">{{ form.errors.phone }}</p>
                            </div>
                        </div>

                        <div>
                            <label for="service" class="mb-2 block text-sm font-semibold text-fg">{{ t('contact_service') }}</label>
                            <select id="service" v-model="form.service_id" :class="inputClass('service_id')">
                                <option value="">{{ t('select_service') }}</option>
                                <option v-for="service in services" :key="service.id" :value="service.id">{{ service.title }}</option>
                            </select>
                            <p v-if="form.errors.service_id" class="mt-1.5 text-sm text-red-600">{{ form.errors.service_id }}</p>
                        </div>

                        <div>
                            <label for="message" class="mb-2 block text-sm font-semibold text-fg">{{ t('contact_message') }} *</label>
                            <textarea id="message" v-model="form.message" rows="6" required :placeholder="t('contact_message_placeholder')" :class="inputClass('message')"></textarea>
                            <p v-if="form.errors.message" class="mt-1.5 text-sm text-red-600">{{ form.errors.message }}</p>
                        </div>

                        <div class="flex flex-col gap-4 pt-2 sm:flex-row sm:items-center sm:justify-between">
                            <p class="text-xs text-fg-soft">{{ t('contact_required_hint') }} · {{ t('contact_privacy') }}</p>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-primary px-8 py-4 font-semibold text-white shadow-lg shadow-primary/25 transition-colors hover:bg-secondary disabled:opacity-60"
                            >
                                {{ form.processing ? t('contact_sending') : t('contact_send_message') }}
                                <svg v-if="!form.processing" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Coordonnées -->
                <aside class="space-y-6 lg:col-span-5">
                    <div class="rounded-[2rem] bg-secondary p-8 text-white">
                        <h2 class="mb-6 text-2xl font-extrabold">{{ t('contact_details_title') }}</h2>
                        <ul class="space-y-5">
                            <li>
                                <a href="tel:+32472640679" class="group flex items-center gap-4">
                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-primary">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                    </span>
                                    <span>
                                        <span class="block text-sm text-fg-soft">{{ t('contact_call_now') }}</span>
                                        <span class="block text-lg font-bold group-hover:underline">0472 64 06 79</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:info@svsrenov.be" class="group flex items-center gap-4">
                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/10">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                    </span>
                                    <span>
                                        <span class="block text-sm text-fg-soft">{{ t('contact_send_email') }}</span>
                                        <span class="block text-lg font-bold group-hover:underline">info@svsrenov.be</span>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a
                                    href="https://www.google.com/maps/search/?api=1&query=Vilvoordsesteenweg+1860+Meise"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="group flex items-center gap-4"
                                >
                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/10">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    </span>
                                    <span>
                                        <span class="block text-sm text-fg-soft">{{ t('contact_location') }}</span>
                                        <span class="block font-bold group-hover:underline">Vilvoordsesteenweg, 1860 Meise</span>
                                    </span>
                                </a>
                            </li>
                        </ul>

                        <div class="mt-8 border-t border-white/10 pt-6">
                            <h3 class="mb-3 text-sm font-bold uppercase tracking-wider text-fg-soft">{{ t('contact_opening_hours') }}</h3>
                            <dl class="space-y-2 text-sm">
                                <div class="flex justify-between gap-4"><dt>{{ t('contact_monday_friday') }}</dt><dd class="font-semibold">8h00 – 18h00</dd></div>
                                <div class="flex justify-between gap-4"><dt>{{ t('contact_saturday') }}</dt><dd class="font-semibold">9h00 – 14h00</dd></div>
                                <div class="flex justify-between gap-4 text-fg-soft"><dt>{{ t('contact_sunday') }}</dt><dd>{{ t('contact_closed') }}</dd></div>
                            </dl>
                        </div>
                    </div>

                    <!-- Confiance -->
                    <div class="rounded-[2rem] bg-surface-2 p-8">
                        <div v-if="googleReviewStats?.total_count" class="mb-6 flex flex-wrap items-center gap-3">
                            <svg class="h-7 w-7 shrink-0" viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                            <span class="text-2xl font-extrabold text-fg">{{ rating }}<span class="text-amber-400">★</span></span>
                            <span class="text-sm text-fg-soft">{{ t('reviews_based_on') }} {{ googleReviewStats.total_count }} {{ t('reviews_count_label') }}</span>
                        </div>
                        <h3 class="mb-4 font-bold text-fg">{{ t('contact_why_title') }}</h3>
                        <ul class="space-y-3">
                            <li v-for="reason in reasons" :key="reason" class="flex items-center gap-3 text-fg-muted">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-primary text-white">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                </span>
                                {{ reason }}
                            </li>
                        </ul>
                    </div>
                </aside>
            </div>
        </section>
    </FrontendLayout>
</template>
