<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">Subscription plans</h2>
            <a href="{{ route('admin.subscription-plans.create') }}" class="btn-neon rounded-xl px-4 py-2 text-sm font-semibold">New plan</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-panel overflow-hidden p-6 sm:rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500">
                                <th class="py-2 pr-4">Name</th>
                                <th class="py-2 pr-4">Slug</th>
                                <th class="py-2 pr-4">Interval</th>
                                <th class="py-2 pr-4">Price</th>
                                <th class="py-2 pr-4">Active</th>
                                <th class="py-2 pr-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cyan-500/15">
                            @forelse ($plans as $plan)
                                <tr>
                                    <td class="py-2 pr-4 font-medium">{{ $plan->name }}</td>
                                    <td class="py-2 pr-4">{{ $plan->slug }}</td>
                                    <td class="py-2 pr-4">{{ $plan->interval->value }}</td>
                                    <td class="py-2 pr-4">{{ $plan->currency }} {{ number_format((float) $plan->price_amount, 2) }}</td>
                                    <td class="py-2 pr-4">{{ $plan->is_active ? 'yes' : 'no' }}</td>
                                    <td class="py-2 pr-4 whitespace-nowrap">
                                        <a class="text-cyan-300 hover:text-cyan-100 hover:underline" href="{{ route('admin.subscription-plans.edit', $plan) }}">Edit</a>
                                        <form method="post" action="{{ route('admin.subscription-plans.destroy', $plan) }}" class="inline ms-3" onsubmit="return confirm('Delete this plan?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-slate-500">No plans yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $plans->links() }}</div>
            </div>
        </div>
    </div>
</x-admin-layout>


