<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">#{{ $ticket->id }} — {{ $ticket->subject }}</h2>
            <a href="{{ route('admin.support-tickets.index') }}" class="text-sm text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Back') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="glass-panel p-6 text-sm text-slate-200">
                <dl class="grid gap-2 sm:grid-cols-2">
                    <div><span class="text-slate-500">{{ __('From') }}:</span> {{ $ticket->user?->name }} ({{ $ticket->user?->email }})</div>
                    <div><span class="text-slate-500">{{ __('Restaurant') }}:</span> {{ $ticket->restaurant?->name ?? '—' }}</div>
                    <div><span class="text-slate-500">{{ __('Priority') }}:</span> {{ $ticket->priority }}</div>
                    <div><span class="text-slate-500">{{ __('Status') }}:</span> {{ $ticket->status }}</div>
                </dl>
            </div>

            <div class="glass-panel p-6">
                <h3 class="font-semibold text-slate-50">{{ __('Update status') }}</h3>
                <form method="post" action="{{ route('admin.support-tickets.status', $ticket) }}" class="mt-4 flex flex-wrap items-end gap-3">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label for="status" class="block text-xs text-slate-500">{{ __('Status') }}</label>
                        <select id="status" name="status" class="mt-1 ui-field text-sm" required>
                            @foreach (['open', 'pending', 'resolved', 'closed'] as $st)
                                <option value="{{ $st }}" @selected(old('status', $ticket->status) === $st)>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="priority" class="block text-xs text-slate-500">{{ __('Priority') }}</label>
                        <select id="priority" name="priority" class="mt-1 ui-field text-sm">
                            @foreach (['low', 'normal', 'high', 'urgent'] as $pr)
                                <option value="{{ $pr }}" @selected(old('priority', $ticket->priority) === $pr)>{{ $pr }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-primary-button type="submit">{{ __('Save') }}</x-primary-button>
                </form>
            </div>

            <div class="glass-panel p-6">
                <h3 class="font-semibold text-slate-50">{{ __('Thread') }}</h3>
                <ul class="mt-4 space-y-4">
                    @foreach ($ticket->messages as $msg)
                        <li class="rounded-xl border border-cyan-500/10 bg-slate-950/40 p-3 text-sm backdrop-blur-sm">
                            <div class="flex flex-wrap justify-between gap-2 text-xs text-slate-500">
                                <span>{{ $msg->user?->email ?? __('System') }} @if ($msg->is_staff_reply) <span class="rounded-full bg-cyan-500/20 px-2 py-0.5 text-[11px] font-medium text-cyan-100 ring-1 ring-cyan-400/25">{{ __('Staff') }}</span> @endif</span>
                                <span>{{ $msg->created_at?->format('Y-m-d H:i') }}</span>
                            </div>
                            <div class="mt-2 whitespace-pre-wrap text-slate-100">{{ $msg->body }}</div>
                        </li>
                    @endforeach
                </ul>

                <form method="post" action="{{ route('admin.support-tickets.reply', $ticket) }}" class="mt-6 space-y-3">
                    @csrf
                    <div>
                        <x-input-label for="body" :value="__('Staff reply')" />
                        <textarea id="body" name="body" rows="4" class="mt-1 block w-full ui-field text-sm" required>{{ old('body') }}</textarea>
                        <x-input-error :messages="$errors->get('body')" class="mt-2" />
                    </div>
                    <x-primary-button type="submit">{{ __('Send reply') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>


