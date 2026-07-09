import * as Turbo from '@hotwired/turbo'
import './bootstrap';

import Alpine from 'alpinejs';
import { initEffects, cleanupEffects } from './effects';

let heroCleanup = null;

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('countUp', (target) => ({
        current: 0,
        target: target,
        init() {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                this.current = this.target;
                return;
            }
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.animate();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.3 });
            observer.observe(this.$el);
        },
        animate() {
            const duration = 1200;
            const start = performance.now();
            const step = (now) => {
                const elapsed = now - start;
                const progress = Math.min(elapsed / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                this.current = Math.floor(eased * this.target);
                if (progress < 1) requestAnimationFrame(step);
                else this.current = this.target;
            };
            requestAnimationFrame(step);
        }
    }));

    Alpine.store('skeleton', { loading: false });

    Alpine.data('revealOnScroll', () => ({
        visible: false,
        init() {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                this.visible = true;
                return;
            }
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.visible = true;
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
            observer.observe(this.$el);
        }
    }));
});

Alpine.start();

document.addEventListener('turbo:before-cache', () => {
    cleanupEffects();
    if (heroCleanup) {
        heroCleanup();
        heroCleanup = null;
    }
});

document.addEventListener('turbo:load', () => {
    Alpine.initTree(document.body);
    initEffects();
    window.lucide?.createIcons({ attrs: { 'aria-hidden': 'true' } });

    if (document.getElementById('hero-3d-canvas') && !heroCleanup) {
        import('./hero-3d').then(({ initHero3D }) => {
            heroCleanup = initHero3D();
        });
    }
});
