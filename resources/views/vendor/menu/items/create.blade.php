<x-vendor-layout :title="__('New Item — ') . $restaurant->name" :mobile-title="__('New Item')">
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('vendor.menu.items.index') }}" class="flex h-8 w-8 items-center justify-center rounded-xl border border-white/10 text-slate-400 transition hover:border-cyan-400/30 hover:text-cyan-200">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            </a>
            <h1 class="text-xl font-bold text-slate-100">{{ __('New menu item') }}</h1>
        </div>
    </x-slot>

    @include('vendor.partials.flash')

    <div class="mx-auto max-w-2xl">
        <div class="glass-panel rounded-2xl p-6">
            <form method="post" action="{{ route('vendor.menu.items.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-300">{{ __('Category') }} <span class="text-red-400">*</span></label>
                    <select name="category_id" class="mt-2 w-full ui-field" required>
                        <option value="">{{ __('— Select category —') }}</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}" @selected(old('category_id') == $c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300">{{ __('Name') }} <span class="text-red-400">*</span></label>
                    <input name="name" value="{{ old('name') }}" class="mt-2 w-full ui-field" required>
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300">{{ __('Description') }}</label>
                    <textarea name="description" rows="3" class="mt-2 w-full ui-field">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300">{{ __('Price') }} ({{ $restaurant->currency }}) <span class="text-red-400">*</span></label>
                    <input name="price" type="number" step="0.01" min="0" value="{{ old('price') }}" class="mt-2 w-full ui-field" required>
                    @error('price') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                {{-- Image --}}
                <div x-data="{ mode: 'url' }">
                    <label class="block text-sm font-medium text-slate-300">{{ __('Image') }}</label>
                    <div class="mt-2 flex gap-3 text-xs">
                        <button type="button" @click="mode='url'" :class="mode==='url' ? 'text-cyan-300 underline' : 'text-slate-400'">{{ __('URL') }}</button>
                        <button type="button" @click="mode='file'" :class="mode==='file' ? 'text-cyan-300 underline' : 'text-slate-400'">{{ __('Upload file') }}</button>
                    </div>
                    <div x-show="mode==='url'" class="mt-2">
                        <input name="image_url" value="{{ old('image_url') }}" class="w-full ui-field" placeholder="https://…">
                    </div>
                    <div x-show="mode==='file'" class="mt-2">
                        <input type="file" name="image_file" accept="image/*"
                            class="w-full text-sm text-slate-400 file:rounded-lg file:border-0 file:bg-cyan-500/20 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-cyan-300">
                        <p class="mt-1 text-[11px] text-slate-500">{{ __('Max 4 MB. JPG, PNG, WEBP.') }}</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="track_inventory" value="0">
                        <input id="track_inventory" type="checkbox" name="track_inventory" value="1" class="rounded border-cyan-400/35 bg-slate-950/40 accent-cyan-500" @checked(old('track_inventory'))>
                        <label for="track_inventory" class="text-sm text-slate-300">{{ __('Track inventory') }}</label>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300">{{ __('Stock qty') }}</label>
                        <input type="number" name="stock_qty" value="{{ old('stock_qty') }}" min="0" class="mt-2 w-full ui-field">
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="is_available" value="0">
                        <input id="is_available" type="checkbox" name="is_available" value="1" class="rounded border-cyan-400/35 bg-slate-950/40 accent-cyan-500" @checked(old('is_available', true))>
                        <label for="is_available" class="text-sm text-slate-300">{{ __('Available on menu') }}</label>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 border-t border-white/10 pt-4">
                    <a href="{{ route('vendor.menu.items.index') }}" class="text-sm text-slate-400 hover:text-slate-200">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn-neon rounded-xl px-5 py-2 text-sm font-semibold">{{ __('Create item') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-vendor-layout>
