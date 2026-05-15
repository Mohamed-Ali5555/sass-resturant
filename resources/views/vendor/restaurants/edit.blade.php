@php
    use Illuminate\Support\Facades\Storage;
@endphp
<x-vendor-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Restaurant settings') }}</h2>
            <div class="flex flex-wrap gap-3 text-sm">
                <a href="{{ route('vendor.dashboard') }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Vendor home') }}</a>
                <a href="{{ route('vendor.restaurants.qr-print-menu', $restaurant) }}" target="_blank" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Print menu QR (A4)') }}</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <form method="post" action="{{ route('vendor.restaurants.update', $restaurant) }}" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PATCH')

                <div class="glass-panel overflow-hidden p-6">
                    <h3 class="font-semibold text-slate-50">{{ __('Basics') }}</h3>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <x-input-label for="name" :value="__('Restaurant name')" />
                            <x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name', $restaurant->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="slug" :value="__('Slug (read-only)')" />
                            <x-text-input id="slug" class="mt-1 block w-full border-cyan-400/15 bg-slate-950/50 text-slate-400" :value="$restaurant->slug" disabled />
                        </div>
                        <div>
                            <x-input-label for="currency" :value="__('Currency (ISO)')" />
                            <x-text-input id="currency" name="currency" class="mt-1 block w-full" :value="old('currency', $restaurant->currency)" required maxlength="3" />
                            <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="timezone" :value="__('Timezone')" />
                            <x-text-input id="timezone" name="timezone" class="mt-1 block w-full" :value="old('timezone', $restaurant->timezone)" placeholder="UTC" />
                            <x-input-error :messages="$errors->get('timezone')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="tax_rate_percent" :value="__('Tax %')" />
                            <x-text-input id="tax_rate_percent" name="tax_rate_percent" type="number" step="0.01" min="0" max="100" class="mt-1 block w-full" :value="old('tax_rate_percent', $restaurant->tax_rate_percent)" required />
                            <x-input-error :messages="$errors->get('tax_rate_percent')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="delivery_fee" :value="__('Default delivery fee')" />
                            <x-text-input id="delivery_fee" name="delivery_fee" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('delivery_fee', $restaurant->delivery_fee)" required />
                            <x-input-error :messages="$errors->get('delivery_fee')" class="mt-2" />
                        </div>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-6 text-sm">
                        <label class="flex items-center gap-2"><input type="hidden" name="enable_dine_in" value="0" /><input type="checkbox" name="enable_dine_in" value="1" class="rounded border-cyan-400/35 bg-slate-950/40 accent-cyan-500 dark:border-cyan-500/40" @checked(old('enable_dine_in', $restaurant->enable_dine_in)) /> {{ __('Dine-in') }}</label>
                        <label class="flex items-center gap-2"><input type="hidden" name="enable_takeaway" value="0" /><input type="checkbox" name="enable_takeaway" value="1" class="rounded border-cyan-400/35 bg-slate-950/40 accent-cyan-500 dark:border-cyan-500/40" @checked(old('enable_takeaway', $restaurant->enable_takeaway)) /> {{ __('Takeaway') }}</label>
                        <label class="flex items-center gap-2"><input type="hidden" name="enable_delivery" value="0" /><input type="checkbox" name="enable_delivery" value="1" class="rounded border-cyan-400/35 bg-slate-950/40 accent-cyan-500 dark:border-cyan-500/40" @checked(old('enable_delivery', $restaurant->enable_delivery)) /> {{ __('Delivery') }}</label>
                    </div>
                </div>

                <div class="glass-panel overflow-hidden p-6">
                    <h3 class="font-semibold text-slate-50">{{ __('Profile & contact') }}</h3>
                    @php $profile = $restaurant->profile; @endphp
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <x-input-label for="profile_address_line" :value="__('Address line')" />
                            <x-text-input id="profile_address_line" name="profile[address_line]" class="mt-1 block w-full" :value="old('profile.address_line', $profile?->address_line)" />
                            <x-input-error :messages="$errors->get('profile.address_line')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="profile_city" :value="__('City')" />
                            <x-text-input id="profile_city" name="profile[city]" class="mt-1 block w-full" :value="old('profile.city', $profile?->city)" />
                            <x-input-error :messages="$errors->get('profile.city')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="profile_country" :value="__('Country (2 letters)')" />
                            <x-text-input id="profile_country" name="profile[country]" class="mt-1 block w-full" maxlength="2" :value="old('profile.country', $profile?->country)" />
                            <x-input-error :messages="$errors->get('profile.country')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="profile_phone" :value="__('Phone')" />
                            <x-text-input id="profile_phone" name="profile[phone]" class="mt-1 block w-full" :value="old('profile.phone', $profile?->phone)" />
                            <x-input-error :messages="$errors->get('profile.phone')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="glass-panel overflow-hidden p-6">
                    <h3 class="font-semibold text-slate-50">{{ __('Logo & gallery') }}</h3>
                    <p class="mt-1 text-xs text-slate-500">{{ __('Images are stored privately under public disk; only image types up to 2 MB each.') }}</p>
                    <div class="mt-4">
                        <x-input-label for="logo" :value="__('Logo')" />
                        <input id="logo" name="logo" type="file" accept="image/*" class="mt-1 block w-full text-sm" />
                        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                        @if ($profile?->logo_path)
                            <div class="mt-2">
                                <img src="{{ Storage::disk('public')->url($profile->logo_path) }}" alt="Logo" class="h-20 rounded border object-contain" />
                            </div>
                        @endif
                    </div>
                    <div class="mt-6">
                        <x-input-label for="gallery" :value="__('Add gallery images (max 8 per request)')" />
                        <input id="gallery" name="gallery[]" type="file" accept="image/*" multiple class="mt-1 block w-full text-sm" />
                        <x-input-error :messages="$errors->get('gallery')" class="mt-2" />
                        @if ($profile?->gallery_paths && count($profile->gallery_paths))
                            <div class="mt-4 grid gap-3 sm:grid-cols-3">
                                @foreach ($profile->gallery_paths as $idx => $path)
                                    <div class="rounded border p-2 dark:border-gray-600">
                                        <img src="{{ Storage::disk('public')->url($path) }}" alt="" class="h-24 w-full object-cover" />
                                        <label class="mt-2 flex items-center gap-2 text-xs text-red-700 dark:text-red-300">
                                            <input type="checkbox" name="remove_gallery_indices[]" value="{{ $idx }}" /> {{ __('Remove') }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <x-primary-button>{{ __('Save changes') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-vendor-layout>


