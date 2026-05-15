<x-vendor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Edit table') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <form method="post" action="{{ route('vendor.tables.update', $table) }}" class="glass-panel space-y-4 p-6">
                @csrf
                @method('PATCH')
                <div>
                    <x-input-label for="label" :value="__('Label')" />
                    <x-text-input id="label" name="label" class="mt-1 block w-full" :value="old('label', $table->label)" required />
                    <x-input-error :messages="$errors->get('label')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="table_code" :value="__('Table code')" />
                    <x-text-input id="table_code" name="table_code" class="mt-1 block w-full" :value="old('table_code', $table->table_code)" />
                    <x-input-error :messages="$errors->get('table_code')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="branch_id" :value="__('Branch')" />
                    <select id="branch_id" name="branch_id" class="mt-1 block w-full ui-field">
                        <option value="">{{ __('— none —') }}</option>
                        @foreach ($branches as $b)
                            <option value="{{ $b->id }}" @selected(old('branch_id', $table->branch_id) == $b->id)>{{ $b->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
                </div>
                <div class="flex gap-3">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                    <a href="{{ route('vendor.tables.index') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-300">{{ __('Back') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-vendor-layout>


