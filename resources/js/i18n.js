import { createI18n } from 'vue-i18n';

export function createAppI18n(locale, messages) {
    return createI18n({
        legacy: false,
        locale: locale,
        fallbackLocale: 'fr',
        messages: {
            [locale]: messages
        }
    });
}
