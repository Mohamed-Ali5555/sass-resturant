<x-vendor-layout :title="__('Promotions — ') . $restaurant->name" :mobile-title="__('Promotions')">
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-slate-100">{{ __('Promotions & Coupons') }}</h1>
                <p class="mt-0.5 text-sm text-slate-400">{{ __('Create discount codes for your customers.') }}</p>
            </div>
            <a href="{{ route('vendor.promotions.create') }}" class="btn-neon inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                {{ __('New coupon') }}
            </a>
        </div>
    </x-slot>

    @include('vendor.partials.flash')

    <div class="mx-auto max-w-5xl">
        @if ($coupons->isEmpty())
            <div class="glass-panel flex flex-col items-center justify-center gap-3 rounded-2xl p-16 text-center">
                <svg class="h-12 w-12 text-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L9.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>
                <p class="text-slate-400">{{ __('No coupons yet.') }}</p>
                <a href="{{ route('vendor.promotions.create') }}" class="btn-neon rounded-xl px-4 py-2 text-sm font-semibold">{{ __('Create first coupon') }}</a>
            </div>
        @else
            <div class="glass-panel overflow-hidden rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-white/10 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                <th class="px-5 py-3">{{ __('Code') }}</th>
                                <th class="px-5 py-3">{{ __('Discount') }}</th>
                                <th class="px-5 py-3">{{ __('Used') }}</th>
                                <th class="px-5 py-3">{{ __('Validity') }}</th>
                                <th class="px-5 py-3">{{ __('Status') }}</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach ($coupons as $coupon)
                                <tr class="transition hover:bg-white/[0.02]">
                                    <td class="px-5 py-3">
                                        <span class="font-mono text-sm font-bold tracking-widest text-cyan-300">{{ $coupon->code }}</span>
                                    </td>
                                    <td class="px-5 py-3 text-slate-200">
                                        @if ($coupon->discount_type === 'percent')
                                            {{ $coupon->percent_off }}% {{ __('off') }}
                                        @else
                                            {{ $restaurant->currency }} {{ number_format((float) $coupon->amount_off, 2) }} {{ __('off') }}
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-slate-400">
                                        {{ $coupon->times_used }}
                                        @if ($coupon->max_redemptions)
                                            / {{ $coupon->max_redemptions }}
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-slate-400 text-xs">
                                        @if ($coupon->starts_at || $coupon->ends_at)
                                            {{ $coupon->starts_at?->format('M d, Y') ?? '∞' }}
                                            → {{ $coupon->ends_at?->format('M d, Y') ?? '∞' }}
                                        @else
                                            {{ __('No limit') }}
                                        @endif
                                    </td>
                                    <td class="px-5 py-3">
                                        @if ($coupon->is_active)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-500/15 px-2.5 py-0.5 text-xs font-medium text-emerald-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>{{ __('Active') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-500/20 px-2.5 py-0.5 text-xs font-medium text-slate-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-slate-500"></span>{{ __('Inactive') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 whitespace-nowrap text-right">
                                        <a href="{{ route('vendor.promotions.edit', $coupon) }}" class="text-xs font-medium text-cyan-400 hover:text-cyan-200 hover:underline">{{ __('Edit') }}</a>
                                        <form method="post" action="{{ route('vendor.promotions.destroy', $coupon) }}" class="ml-3 inline" onsubmit="return confirm('{{ __('Delete this coupon?') }}')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs font-medium text-red-400 hover:text-red-200 hover:underline">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-3">{{ $coupons->links() }}</div>
            </div>
        @endif
    </div>
</x-vendor-layout>
