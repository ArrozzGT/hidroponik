export function initEffects() {
    try {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        // Tilt 3D
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

        // Magnetic buttons
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

        // Parallax orbs (mouse-follow)
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
        }

        // Scroll parallax
        window.initParallax = function(el) {
            const img = el.querySelector('img');
            if (!img) return;
            const onScroll = () => {
                const rect = el.getBoundingClientRect();
                const windowHeight = window.innerHeight;
                const centerY = rect.top + rect.height / 2;
                const scrollPercent = (centerY - windowHeight / 2) / windowHeight;
                if (img) {
                    img.style.transform = `translateY(${scrollPercent * -30}px) scale(1.05)`;
                }
            };
            document.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        };

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
            document.addEventListener('scroll', onScroll, { passive: true });
            backToTop.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        // Ripple effect
        document.querySelectorAll('.ripple-container').forEach(el => {
            el.addEventListener('click', function(e) {
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
            });
        });

    } catch (e) {
        console.warn('Effects init failed:', e);
    }
}
