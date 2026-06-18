import './bootstrap';

import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';
import { initEffects } from './effects';

window.Alpine = Alpine;

Alpine.start();

function initApp() {
    initEffects();
    createIcons({ icons, attrs: { 'aria-hidden': 'true' } });
}

if (document.readyState === 'complete') {
    initApp();
} else {
    document.addEventListener('DOMContentLoaded', initApp);
}
