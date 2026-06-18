export function initEffects() {
    try {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        document.querySelectorAll('.tilt-3d').forEach(el => {
            el.addEventListener('mousemove', (e) => {
                const rect = el.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - 0.5;
                const y = (e.clientY - rect.top) / rect.height - 0.5;
                el.style.rotate = `${x * 12}deg ${-y * 12}deg`;
            });
            el.addEventListener('mouseleave', () => {
                el.style.rotate = '';
            });
        });

        document.querySelectorAll('.magnetic').forEach(el => {
            let rectCache = null;
            el.addEventListener('mouseenter', () => {
                rectCache = el.getBoundingClientRect();
            });
            el.addEventListener('mousemove', (e) => {
                if (!rectCache) return;
                const x = (e.clientX - rectCache.left - rectCache.width / 2) * 0.3;
                const y = (e.clientY - rectCache.top - rectCache.height / 2) * 0.3;
                el.style.translate = `${x}px ${y}px`;
            });
            el.addEventListener('mouseleave', () => {
                rectCache = null;
                el.style.translate = '';
            });
        });

        const orbs = document.querySelectorAll('.parallax-orb');
        if (orbs.length) {
            const speeds = Array.from(orbs).map(orb => parseFloat(orb.dataset.speed) || 1);
            document.addEventListener('mousemove', (e) => {
                const xFactor = (e.clientX / window.innerWidth - 0.5) * 30;
                const yFactor = (e.clientY / window.innerHeight - 0.5) * 30;
                orbs.forEach((orb, i) => {
                    orb.style.translate = `${xFactor * speeds[i]}px ${yFactor * speeds[i]}px`;
                });
            });
        }

        const revealEls = document.querySelectorAll('.reveal');
        if (revealEls.length) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
            revealEls.forEach(el => observer.observe(el));
        }
    } catch (e) {
        console.warn('Effects init failed:', e);
    }
}
