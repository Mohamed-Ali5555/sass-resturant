<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $documentTitle ?? config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&family=plus-jakarta-sans:500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-hub antialiased text-slate-100">
        <div
            x-data="{ sidebarOpen: false }"
            @keydown.escape.window="sidebarOpen = false"
            class="min-h-screen"
        >
            <div
                x-show="sidebarOpen"
                x-transition.opacity
                class="fixed inset-0 z-40 bg-slate-950/75 backdrop-blur-sm lg:hidden"
                style="display: none;"
                @click="sidebarOpen = false"
            ></div>

            <div class="flex min-h-screen">
                <aside
                    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                    class="hub-sidebar fixed inset-y-0 left-0 z-50 w-[min(100%,17.5rem)] transform transition-transform duration-200 ease-out lg:static lg:z-0 lg:w-64 lg:translate-x-0 lg:shrink-0"
                    aria-label="{{ $panelAriaLabel }}"
                >
                    @include($sidebarPartial)
                </aside>

                <div class="flex min-w-0 flex-1 flex-col">
                    <header class="sticky top-0 z-30 flex h-14 items-center justify-between gap-3 border-b border-white/10 bg-slate-950/55 px-4 backdrop-blur-xl lg:hidden">
                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-xl border border-cyan-400/25 bg-slate-950/60 p-2 text-cyan-100 shadow-glow-sm"
                            @click="sidebarOpen = true"
                            aria-label="{{ __('Open menu') }}"
                        >
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                        </button>
                        <span class="truncate text-sm font-semibold text-slate-100">{{ $mobileNavTitle ?? ($documentTitle ?? config('app.name')) }}</span>
                        <span class="w-10"></span>
                    </header>

                    <main class="hub-main flex-1 px-4 py-6 sm:px-6 lg:px-10 lg:py-8">
                        @isset($shellFlashPartial)
                            @include($shellFlashPartial)
                        @endisset

                        @isset($header)
                            <div class="hub-page-header mb-8">
                                {{ $header }}
                            </div>
                        @endisset

                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
