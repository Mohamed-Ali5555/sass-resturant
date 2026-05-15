@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 glass-panel border border-cyan-400/25 shadow-glow'])

@php
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

$width = match ($width) {
    '48' => 'w-48',
    default => $width,
};

$dropdownId = 'dropdown-' . uniqid();
@endphp

<div class="relative" id="{{ $dropdownId }}">
    <div data-dropdown-trigger>
        {{ $trigger }}
    </div>

    <div data-dropdown-menu
            class="absolute z-50 mt-2 {{ $width }} rounded-xl shadow-glow {{ $alignmentClasses }}"
            style="display: none;">
        <div class="rounded-xl ring-1 ring-cyan-400/10 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropdown = document.getElementById('{{ $dropdownId }}');
        if (!dropdown) return;

        const trigger = dropdown.querySelector('[data-dropdown-trigger]');
        const menu = dropdown.querySelector('[data-dropdown-menu]');
        let isOpen = false;

        function toggleOpen() {
            isOpen = !isOpen;
            menu.style.display = isOpen ? 'block' : 'none';
        }

        function closeMenu() {
            isOpen = false;
            menu.style.display = 'none';
        }

        // Toggle on trigger click
        if (trigger) {
            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleOpen();
            });

            // Make the trigger clickable
            const buttons = trigger.querySelectorAll('button, a');
            buttons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleOpen();
                });
            });
        }

        // Close on menu item click
        if (menu) {
            menu.addEventListener('click', (e) => {
                if (e.target !== menu) {
                    closeMenu();
                }
            });
        }

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target) && isOpen) {
                closeMenu();
            }
        });

        // Close on escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isOpen) {
                closeMenu();
            }
        });
    });
</script>
