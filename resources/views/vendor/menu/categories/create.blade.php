<x-vendor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">New category</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-panel overflow-hidden p-6 sm:rounded-2xl">
                <form method="post" action="{{ route('vendor.menu.categories.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-sm font-medium">Name</label>
                        <input name="name" value="{{ old('name') }}" class="mt-1 w-full ui-field" required>
                    </div>
                    <div>
                        <label class="text-sm font-medium">Sort order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="mt-1 w-full ui-field">
                    </div>
                    <button class="btn-neon rounded-xl px-4 py-2 text-sm font-semibold">Save</button>
                </form>
            </div>
        </div>
    </div>
</x-vendor-layout>

