@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
@endphp

<div
    id="modal-{{ $name }}"
    data-modal-name="{{ $name }}"
    data-modal-backdrop
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
    style="display: {{ $show ? 'block' : 'none' }};"
>
    <div
        data-modal-backdrop
        class="fixed inset-0 transform transition-all"
        style="background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px);"
    ></div>

    <div
        class="glass-panel mb-6 overflow-hidden rounded-2xl shadow-glow transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
    >
        {{ $slot }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('modal-{{ $name }}');
        if (!modal) return;

        const modalState = {
            isOpen: {{ $show ? 'true' : 'false' }},
            previousActiveElement: null,
            focusables: [],
        };

        function updateFocusables() {
            const focusSelector = 'a, button, input:not([type="hidden"]), textarea, select, details, [tabindex]:not([tabindex="-1"])';
            modalState.focusables = Array.from(modal.querySelectorAll(focusSelector))
                .filter(el => !el.hasAttribute('disabled') && !el.hasAttribute('data-modal-backdrop'));
        }

        function openModal() {
            if (modalState.isOpen) return;
            modalState.isOpen = true;
            modalState.previousActiveElement = document.activeElement;
            modal.style.display = 'block';
            document.body.classList.add('overflow-y-hidden');
            updateFocusables();
            setTimeout(() => {
                if (modalState.focusables.length > 0) {
                    modalState.focusables[0].focus();
                }
            }, 100);
        }

        function closeModal() {
            if (!modalState.isOpen) return;
            modalState.isOpen = false;
            modal.style.display = 'none';
            document.body.classList.remove('overflow-y-hidden');
            if (modalState.previousActiveElement) {
                modalState.previousActiveElement.focus();
            }
        }

        function focusNext() {
            const current = document.activeElement;
            const currentIndex = modalState.focusables.indexOf(current);
            const nextIndex = (currentIndex + 1) % modalState.focusables.length;
            modalState.focusables[nextIndex].focus();
        }

        function focusPrevious() {
            const current = document.activeElement;
            const currentIndex = modalState.focusables.indexOf(current);
            const prevIndex = currentIndex - 1 < 0 ? modalState.focusables.length - 1 : currentIndex - 1;
            modalState.focusables[prevIndex].focus();
        }

        // Backdrop click
        const backdrop = modal.querySelector('[data-modal-backdrop]');
        if (backdrop) {
            backdrop.addEventListener('click', (e) => {
                if (e.target === backdrop) {
                    closeModal();
                }
            });
        }

        // Keyboard events
        document.addEventListener('keydown', (e) => {
            if (!modalState.isOpen) return;

            if (e.key === 'Escape') {
                closeModal();
            } else if (e.key === 'Tab') {
                e.preventDefault();
                if (e.shiftKey) {
                    focusPrevious();
                } else {
                    focusNext();
                }
            }
        });

        // Listen for window events
        window.addEventListener('open-modal', (e) => {
            if (e.detail === '{{ $name }}') {
                openModal();
            }
        });

        window.addEventListener('close-modal', (e) => {
            if (e.detail === '{{ $name }}') {
                closeModal();
            }
        });

        // Allow triggering via data attributes
        window['openModal_{{ $name }}'] = openModal;
        window['closeModal_{{ $name }}'] = closeModal;
    });
</script>
