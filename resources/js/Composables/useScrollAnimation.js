import { onMounted, onUnmounted } from 'vue';

export function useScrollAnimation() {
    let observer = null;

    const initScrollAnimation = () => {
        // Options pour l'Intersection Observer
        const options = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1 // L'élément doit être visible à 10% pour déclencher l'animation
        };

        // Callback quand un élément entre dans le viewport
        const callback = (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Ajouter la classe visible pour déclencher l'animation
                    entry.target.classList.add('is-visible');

                    // Optionnel: arrêter d'observer après l'animation (pour n'animer qu'une fois)
                    // observer.unobserve(entry.target);
                }
            });
        };

        // Créer l'observer
        observer = new IntersectionObserver(callback, options);

        // Observer tous les éléments avec la classe 'scroll-animate'
        const elements = document.querySelectorAll('.scroll-animate');
        elements.forEach(el => observer.observe(el));
    };

    const cleanupScrollAnimation = () => {
        if (observer) {
            observer.disconnect();
        }
    };

    onMounted(() => {
        // Petit délai pour s'assurer que le DOM est prêt
        setTimeout(() => {
            initScrollAnimation();
        }, 100);
    });

    onUnmounted(() => {
        cleanupScrollAnimation();
    });

    return {
        initScrollAnimation,
        cleanupScrollAnimation
    };
}
