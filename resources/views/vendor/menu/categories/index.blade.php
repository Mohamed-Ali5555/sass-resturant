<x-vendor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">Menu categories</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-end">
                <a href="{{ route('vendor.menu.categories.create') }}" class="btn-neon rounded-xl px-4 py-2 text-sm font-semibold">New category</a>
            </div>

            <div class="glass-panel overflow-hidden p-6 sm:rounded-2xl">
                <ul class="divide-y divide-cyan-500/15 text-sm">
                    @foreach ($categories as $c)
                        <li class="py-3 flex items-center justify-between gap-3">
                            <div>
                                <div class="font-medium">{{ $c->name }}</div>
                                <div class="text-xs text-gray-500">sort {{ $c->sort_order }}</div>
                            </div>
                            <div class="flex gap-3">
                                <a class="text-cyan-300 hover:text-cyan-100 hover:underline" href="{{ route('vendor.menu.categories.edit', $c) }}">Edit</a>
                                <form method="post" action="{{ route('vendor.menu.categories.destroy', $c) }}" onsubmit="return confirm('Delete category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-4">{{ $categories->links() }}</div>
            </div>
        </div>
    </div>
</x-vendor-layout>

