import { useTranslations } from '@/Composables/useTranslations';

export function useDate() {
    const { locale } = useTranslations();

    const formatDate = (iso) => {
        if (!iso) return '';
        return new Intl.DateTimeFormat(locale.value === 'nl' ? 'nl-BE' : 'fr-BE', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        }).format(new Date(iso));
    };

    return { formatDate };
}
