const _cleanups = [];

function cleanup() {
    _cleanups.forEach(fn => { try { fn(); } catch (e) {} });
    _cleanups.length = 0;
}

export function cleanupEffects() {
    cleanup();
}

export function initEffects() {
    try {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        cleanup(); // remove all previous listeners first

        // Tilt 3D
        document.querySelectorAll('.tilt-3d').forEach(el => {
            const onMove = (e) => {
                const rect = el.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - 0.5;
                const y = (e.clientY - rect.top) / rect.height - 0.5;
                el.style.rotate = `${x * 12}deg ${-y * 12}deg`;
            };
            const onLeave = () => {
                el.style.rotate = '';
            };
            el.addEventListener('mousemove', onMove);
            el.addEventListener('mouseleave', onLeave);
            _cleanups.push(() => {
                el.removeEventListener('mousemove', onMove);
                el.removeEventListener('mouseleave', onLeave);
            });
        });

        // Magnetic buttons
        document.querySelectorAll('.magnetic').forEach(el => {
            let rectCache = null;
            const onEnter = () => { rectCache = el.getBoundingClientRect(); };
            const onMove = (e) => {
                if (!rectCache) return;
                const x = (e.clientX - rectCache.left - rectCache.width / 2) * 0.3;
                const y = (e.clientY - rectCache.top - rectCache.height / 2) * 0.3;
                el.style.translate = `${x}px ${y}px`;
            };
            const onLeave = () => {
                rectCache = null;
                el.style.translate = '';
            };
            el.addEventListener('mouseenter', onEnter);
            el.addEventListener('mousemove', onMove);
            el.addEventListener('mouseleave', onLeave);
            _cleanups.push(() => {
                el.removeEventListener('mouseenter', onEnter);
                el.removeEventListener('mousemove', onMove);
                el.removeEventListener('mouseleave', onLeave);
            });
        });

        // Parallax orbs (mouse-follow) — single global listener
        const orbs = document.querySelectorAll('.parallax-orb, .hero-3d-object');
        if (orbs.length) {
            const speeds = Array.from(orbs).map(orb => parseFloat(orb.dataset.speed) || 1);
            const onMouseMove = (e) => {
                const xFactor = (e.clientX / window.innerWidth - 0.5) * 40;
                const yFactor = (e.clientY / window.innerHeight - 0.5) * 40;
                orbs.forEach((orb, i) => {
                    orb.style.translate = `${xFactor * speeds[i]}px ${yFactor * speeds[i]}px`;
                });
            };
            document.addEventListener('mousemove', onMouseMove, { passive: true });
            _cleanups.push(() => document.removeEventListener('mousemove', onMouseMove));
        }

        // Scroll reveal
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
            _cleanups.push(() => observer.disconnect());
        }

        // Scroll progress bar
        const progressBar = document.querySelector('.scroll-progress');
        if (progressBar) {
            const onScroll = () => {
                const scrollTop = window.scrollY;
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                const progress = docHeight > 0 ? scrollTop / docHeight : 0;
                progressBar.style.transform = `scaleX(${progress})`;
            };
            document.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
            _cleanups.push(() => document.removeEventListener('scroll', onScroll));
        }

        // Scroll-aware navbar
        const navbar = document.querySelector('.navbar-scroll');
        if (navbar) {
            const onScroll = () => {
                if (window.scrollY > 50) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            };
            document.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
            _cleanups.push(() => document.removeEventListener('scroll', onScroll));
        }

        // Back to top
        const backToTop = document.querySelector('.back-to-top');
        if (backToTop) {
            const onScroll = () => {
                if (window.scrollY > 300) {
                    backToTop.classList.remove('opacity-0', 'invisible');
                    backToTop.classList.add('opacity-100', 'visible');
                } else {
                    backToTop.classList.add('opacity-0', 'invisible');
                    backToTop.classList.remove('opacity-100', 'visible');
                }
            };
            const onClick = () => { window.scrollTo({ top: 0, behavior: 'smooth' }); };
            document.addEventListener('scroll', onScroll, { passive: true });
            backToTop.addEventListener('click', onClick);
            onScroll();
            _cleanups.push(() => {
                document.removeEventListener('scroll', onScroll);
                backToTop.removeEventListener('click', onClick);
            });
        }

        // Ripple effect — use event delegation instead of per-element listeners
        const rippleContainer = document.querySelector('.ripple-container');
        if (rippleContainer) {
            const onClick = function(e) {
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                const ripple = document.createElement('span');
                ripple.className = 'ripple-effect';
                ripple.style.width = ripple.style.height = `${size}px`;
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                this.appendChild(ripple);
                ripple.addEventListener('animationend', () => ripple.remove());
            };
            rippleContainer.addEventListener('click', onClick);
            _cleanups.push(() => rippleContainer.removeEventListener('click', onClick));
        }

    } catch (e) {
        console.warn('Effects init failed:', e);
    }
}

// Scroll parallax — registered once globally
export function initParallax(el) {
    const img = el.querySelector('img');
    if (!img) return;
    const onScroll = () => {
        const rect = el.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        const centerY = rect.top + rect.height / 2;
        const scrollPercent = (centerY - windowHeight / 2) / windowHeight;
        img.style.transform = `translateY(${scrollPercent * -30}px) scale(1.05)`;
    };
    document.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
    _cleanups.push(() => document.removeEventListener('scroll', onScroll));
}
