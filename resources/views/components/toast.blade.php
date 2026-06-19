<div x-data="toast()"
     x-init="init()"
     @notify.window="show($event.detail)"
     class="fixed bottom-6 right-6 z-[100] flex flex-col gap-2 pointer-events-none">
    <template x-for="(t, i) in toasts" :key="i">
        <div x-show="t.visible"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-4 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="translate-y-4 opacity-0"
             class="pointer-events-auto flex items-center gap-3 px-5 py-4 rounded-xl shadow-lg border max-w-sm"
             :class="{
                 'bg-emerald-50 border-emerald-200 text-emerald-800': t.type === 'success',
                 'bg-red-50 border-red-200 text-red-800': t.type === 'error',
                 'bg-amber-50 border-amber-200 text-amber-800': t.type === 'warning',
                 'bg-blue-50 border-blue-200 text-blue-800': t.type === 'info',
             }">
            <i :data-lucide="t.icon" class="w-5 h-5 shrink-0" aria-hidden="true"></i>
            <p class="text-sm font-medium" x-text="t.message"></p>
            <button @click="remove(i)" class="ml-auto shrink-0 opacity-60 hover:opacity-100 transition-opacity">
                <i data-lucide="x" class="w-4 h-4" aria-hidden="true"></i>
            </button>
        </div>
    </template>
</div>

<script>
    function toast() {
        return {
            toasts: [],
            init() {
                const msg = document.querySelector('[data-toast]');
                if (msg) {
                    this.show({ type: msg.dataset.toast, message: msg.dataset.message });
                    msg.remove();
                }
            },
            show(detail) {
                const icons = { success: 'check-circle', error: 'alert-circle', warning: 'alert-triangle', info: 'info' };
                this.toasts.push({
                    type: detail.type || 'info',
                    message: detail.message,
                    icon: icons[detail.type] || 'info',
                    visible: true,
                });
                setTimeout(() => { if (this.toasts.length) this.toasts[this.toasts.length - 1].visible = false; }, 4000);
                setTimeout(() => this.toasts.shift(), 4300);
            },
            remove(i) { this.toasts[i].visible = false; setTimeout(() => this.toasts.splice(i, 1), 300); },
        };
    }
</script>
