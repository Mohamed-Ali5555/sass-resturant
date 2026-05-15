<x-vendor-layout :title="__('Edit Item — ') . $restaurant->name" :mobile-title="__('Edit Item')">
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('vendor.menu.items.index') }}" class="flex h-8 w-8 items-center justify-center rounded-xl border border-white/10 text-slate-400 transition hover:border-cyan-400/30 hover:text-cyan-200">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            </a>
            <h1 class="text-xl font-bold text-slate-100">{{ __('Edit') }}: {{ $menuItem->name }}</h1>
        </div>
    </x-slot>

    @include('vendor.partials.flash')

    <div class="mx-auto max-w-2xl">
        <div class="glass-panel rounded-2xl p-6">
            <form method="post" action="{{ route('vendor.menu.items.update', $menuItem) }}" enctype="multipart/form-data" class="space-y-5">
                @csrf @method('PATCH')

                <div>
                    <label class="block text-sm font-medium text-slate-300">{{ __('Category') }} <span class="text-red-400">*</span></label>
                    <select name="category_id" class="mt-2 w-full ui-field" required>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}" @selected(old('category_id', $menuItem->category_id) == $c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300">{{ __('Name') }} <span class="text-red-400">*</span></label>
                    <input name="name" value="{{ old('name', $menuItem->name) }}" class="mt-2 w-full ui-field" required>
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300">{{ __('Description') }}</label>
                    <textarea name="description" rows="3" class="mt-2 w-full ui-field">{{ old('description', $menuItem->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300">{{ __('Price') }} ({{ $restaurant->currency }}) <span class="text-red-400">*</span></label>
                    <input name="price" type="number" step="0.01" min="0" value="{{ old('price', $menuItem->price) }}" class="mt-2 w-full ui-field" required>
                    @error('price') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Image --}}
                <div id="imageModeContainer">
                    <label class="block text-sm font-medium text-slate-300">{{ __('Image') }}</label>
                    @if ($menuItem->image)
                        <div class="mt-2 flex items-center gap-3">
                            <img src="{{ $menuItem->image }}" alt="" class="h-16 w-16 rounded-xl object-cover border border-white/10">
                            <div class="flex gap-3 text-xs">
                                <button type="button" class="image-mode-btn text-slate-400 mode-url" data-mode="url">{{ __('Change URL') }}</button>
                                <button type="button" class="image-mode-btn text-slate-400 mode-file" data-mode="file">{{ __('Upload file') }}</button>
                                <button type="button" class="image-mode-btn text-slate-400 mode-remove" data-mode="remove">{{ __('Remove') }}</button>
                            </div>
                        </div>
                    @else
                        <div class="mt-2 flex gap-3 text-xs">
                            <button type="button" class="image-mode-btn text-cyan-300 underline mode-url" data-mode="url">{{ __('URL') }}</button>
                            <button type="button" class="image-mode-btn text-slate-400 mode-file" data-mode="file">{{ __('Upload') }}</button>
                        </div>
                    @endif

                    <div class="image-mode-section image-mode-url mt-2">
                        <input id="imageUrlInput" name="image_url" value="{{ old('image_url', $menuItem->image) }}"
                            class="w-full ui-field" placeholder="https://…">
                    </div>
                    <div class="image-mode-section image-mode-file mt-2" style="display:none">
                        <input type="file" name="image_file" accept="image/*"
                            class="w-full text-sm text-slate-400 file:rounded-lg file:border-0 file:bg-cyan-500/20 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-cyan-300">
                        <p class="mt-1 text-[11px] text-slate-500">{{ __('Max 4 MB. JPG, PNG, WEBP.') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300">{{ __('Stock qty') }}</label>
                        <input type="number" name="stock_qty" value="{{ old('stock_qty', $menuItem->stock_qty) }}" min="0" class="mt-2 w-full ui-field">
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="track_inventory" value="0">
                        <input id="track_inventory" type="checkbox" name="track_inventory" value="1" class="rounded border-cyan-400/35 bg-slate-950/40 accent-cyan-500" @checked(old('track_inventory', $menuItem->track_inventory))>
                        <label for="track_inventory" class="text-sm text-slate-300">{{ __('Track inventory') }}</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="is_available" value="0">
                        <input id="is_available" type="checkbox" name="is_available" value="1" class="rounded border-cyan-400/35 bg-slate-950/40 accent-cyan-500" @checked(old('is_available', $menuItem->is_available))>
                        <label for="is_available" class="text-sm text-slate-300">{{ __('Available on menu') }}</label>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 border-t border-white/10 pt-4">
                    <div class="flex gap-3">
                        <a href="{{ route('vendor.menu.items.qr-print', $menuItem) }}" target="_blank" class="text-xs text-cyan-400 hover:underline">{{ __('Print QR card') }}</a>
                        <form method="post" action="{{ route('vendor.menu.items.destroy', $menuItem) }}" onsubmit="return confirm('{{ __('Delete this item?') }}')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs font-medium text-red-400 hover:text-red-200">{{ __('Delete') }}</button>
                        </form>
                    </div>
                    <button type="submit" class="btn-neon rounded-xl px-5 py-2 text-sm font-semibold">{{ __('Save changes') }}</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let currentMode = '{{ $menuItem->image ? 'url' : 'url' }}';
            const container = document.getElementById('imageModeContainer');
            const modeButtons = container.querySelectorAll('.image-mode-btn');
            const modeSections = container.querySelectorAll('.image-mode-section');
            const imageUrlInput = document.getElementById('imageUrlInput');

            function updateMode(newMode) {
                currentMode = newMode;

                // Update button styles
                modeButtons.forEach(btn => {
                    btn.classList.remove('text-cyan-300', 'underline', 'text-red-400');
                    btn.classList.add('text-slate-400');

                    if (btn.dataset.mode === newMode) {
                        btn.classList.remove('text-slate-400');
                        if (newMode === 'remove') {
                            btn.classList.add('text-red-400', 'underline');
                        } else {
                            btn.classList.add('text-cyan-300', 'underline');
                        }
                    }
                });

                // Show/hide sections
                modeSections.forEach(section => {
                    section.style.display = 'none';
                });
                const activeSection = container.querySelector(`.image-mode-${newMode}`);
                if (activeSection) {
                    activeSection.style.display = 'block';
                }

                // Handle remove mode
                if (newMode === 'remove') {
                    imageUrlInput.value = '';
                }
            }

            modeButtons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    updateMode(btn.dataset.mode);
                });
            });

            // Initialize
            updateMode(currentMode);
        });
    </script>
</x-vendor-layout>
