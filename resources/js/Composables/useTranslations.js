import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export function useTranslations() {
    const page = usePage();

    const locale = computed(() => page.props.locale);
    const translations = computed(() => page.props.translations || {});

    const t = (key) => {
        return translations.value[key] || key;
    };

    return {
        locale,
        translations,
        t
    };
}
