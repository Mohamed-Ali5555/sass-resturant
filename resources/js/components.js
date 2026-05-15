/**
 * Vanilla JavaScript Component Utilities
 * Replaces Alpine.js functionality with plain JavaScript
 */

// Modal Management
export const Modal = {
    instances: {},

    create(name, element) {
        this.instances[name] = {
            name,
            element,
            show: false,
            focusables: [],
            previousActiveElement: null,
        };
        this.setupModalListeners(name);
    },

    open(name) {
        const modal = this.instances[name];
        if (!modal) return;

        modal.show = true;
        modal.previousActiveElement = document.activeElement;
        modal.element.style.display = 'block';
        document.body.classList.add('overflow-y-hidden');
        this.updateFocusables(name);
        this.focusFirstElement(name);
    },

    close(name) {
        const modal = this.instances[name];
        if (!modal) return;

        modal.show = false;
        modal.element.style.display = 'none';
        document.body.classList.remove('overflow-y-hidden');

        // Restore focus to previous element
        if (modal.previousActiveElement) {
            modal.previousActiveElement.focus();
        }
    },

    setupModalListeners(name) {
        const modal = this.instances[name];
        const element = modal.element;

        // Close modal on escape
        element.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.close(name);
            }
        });

        // Tab navigation within modal
        element.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                e.preventDefault();
                if (e.shiftKey) {
                    this.focusPrevious(name);
                } else {
                    this.focusNext(name);
                }
            }
        });

        // Close on backdrop click
        const backdrop = element.querySelector('[data-modal-backdrop]');
        if (backdrop) {
            backdrop.addEventListener('click', () => this.close(name));
        }

        // Close button
        const closeBtn = element.querySelector('[data-modal-close]');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => this.close(name));
        }
    },

    updateFocusables(name) {
        const modal = this.instances[name];
        const focusSelector = 'a, button, input:not([type="hidden"]), textarea, select, details, [tabindex]:not([tabindex="-1"])';
        modal.focusables = Array.from(modal.element.querySelectorAll(focusSelector))
            .filter(el => !el.hasAttribute('disabled'));
    },

    focusFirstElement(name) {
        const modal = this.instances[name];
        if (modal.focusables.length > 0) {
            setTimeout(() => modal.focusables[0].focus(), 100);
        }
    },

    focusNext(name) {
        const modal = this.instances[name];
        const current = document.activeElement;
        const currentIndex = modal.focusables.indexOf(current);
        const nextIndex = (currentIndex + 1) % modal.focusables.length;
        modal.focusables[nextIndex].focus();
    },

    focusPrevious(name) {
        const modal = this.instances[name];
        const current = document.activeElement;
        const currentIndex = modal.focusables.indexOf(current);
        const prevIndex = currentIndex - 1 < 0 ? modal.focusables.length - 1 : currentIndex - 1;
        modal.focusables[prevIndex].focus();
    },

    // Listen for window events to open/close modal
    setupGlobalListeners() {
        document.addEventListener('open-modal', (e) => {
            this.open(e.detail);
        });

        document.addEventListener('close-modal', (e) => {
            this.close(e.detail);
        });
    },
};

// Dropdown Management
export const Dropdown = {
    instances: {},

    create(element) {
        const id = Math.random().toString(36).substr(2, 9);
        this.instances[id] = {
            id,
            element,
            open: false,
        };
        this.setupDropdownListeners(id);
    },

    setupDropdownListeners(id) {
        const dropdown = this.instances[id];
        const element = dropdown.element;
        const trigger = element.querySelector('[data-dropdown-trigger]');
        const menu = element.querySelector('[data-dropdown-menu]');

        if (!trigger || !menu) return;

        // Toggle on click
        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.open = !dropdown.open;
            menu.style.display = dropdown.open ? 'block' : 'none';
        });

        // Close on menu item click
        menu.addEventListener('click', () => {
            dropdown.open = false;
            menu.style.display = 'none';
        });

        // Close on outside click
        document.addEventListener('click', () => {
            if (dropdown.open) {
                dropdown.open = false;
                menu.style.display = 'none';
            }
        });
    },
};

// Auto-hide elements after delay
export const AutoHide = {
    setup(selector, delay = 2000) {
        const elements = document.querySelectorAll(selector);
        elements.forEach(el => {
            setTimeout(() => {
                el.style.opacity = '0';
                el.style.transition = 'opacity 0.3s ease-out';
                setTimeout(() => {
                    el.style.display = 'none';
                }, 300);
            }, delay);
        });
    },
};

// Initialize all components
export function initializeComponents() {
    Modal.setupGlobalListeners();
}
