<x-vendor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Edit branch') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <form method="post" action="{{ route('vendor.branches.update', $branch) }}" class="glass-panel space-y-4 p-6">
                @csrf
                @method('PATCH')
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" class="mt-1 block w-full" :value="old('name', $branch->name)" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="slug" :value="__('Slug')" />
                    <x-text-input id="slug" name="slug" class="mt-1 block w-full" :value="old('slug', $branch->slug)" required />
                    <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="status" :value="__('Status')" />
                    <select id="status" name="status" class="mt-1 block w-full ui-field">
                        <option value="active" @selected(old('status', $branch->status) === 'active')>active</option>
                        <option value="inactive" @selected(old('status', $branch->status) === 'inactive')>inactive</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="sort_order" :value="__('Sort order')" />
                    <x-text-input id="sort_order" name="sort_order" type="number" class="mt-1 block w-full" :value="old('sort_order', $branch->sort_order)" />
                    <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
                </div>
                <div class="flex gap-3">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                    <a href="{{ route('vendor.branches.index') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-300">{{ __('Back') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-vendor-layout>


