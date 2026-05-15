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
            id="hubShellContainer"
            class="min-h-screen"
        >
            <div
                id="hubSidebarBackdrop"
                class="fixed inset-0 z-40 bg-slate-950/75 backdrop-blur-sm lg:hidden"
                style="display: none;"
            ></div>

            <div class="flex min-h-screen">
                <aside
                    id="hubSidebarElement"
                    class="hub-sidebar fixed inset-y-0 left-0 z-50 w-[min(100%,17.5rem)] transform transition-transform duration-200 ease-out lg:static lg:z-0 lg:w-60 lg:translate-x-0 lg:shrink-0 -translate-x-full"
                    aria-label="{{ __('Main navigation') }}"
                >
                    @include('layouts.partials.hub-sidebar')
                </aside>

                <div class="flex min-w-0 flex-1 flex-col">
                    <header class="sticky top-0 z-30 flex h-14 items-center justify-between gap-3 border-b border-white/10 bg-slate-950/55 px-4 backdrop-blur-xl lg:hidden">
                        <button
                            type="button"
                            id="hubSidebarToggle"
                            class="inline-flex items-center justify-center rounded-xl border border-cyan-400/25 bg-slate-950/60 p-2 text-cyan-100 shadow-glow-sm"
                            aria-label="{{ __('Open menu') }}"
                        >
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                        </button>
                        <span class="truncate text-sm font-semibold text-slate-100">{{ $mobileNavTitle ?? ($documentTitle ?? config('app.name')) }}</span>
                        <span class="w-10"></span>
                    </header>

                    <main class="hub-main flex-1 px-4 py-6 sm:px-6 lg:px-10 lg:py-8">
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

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const sidebarToggle = document.getElementById('hubSidebarToggle');
                const sidebarElement = document.getElementById('hubSidebarElement');
                const sidebarBackdrop = document.getElementById('hubSidebarBackdrop');
                let isSidebarOpen = false;

                function openSidebar() {
                    isSidebarOpen = true;
                    sidebarElement.classList.remove('-translate-x-full');
                    sidebarElement.classList.add('translate-x-0');
                    sidebarBackdrop.style.display = 'block';
                }

                function closeSidebar() {
                    isSidebarOpen = false;
                    sidebarElement.classList.remove('translate-x-0');
                    sidebarElement.classList.add('-translate-x-full');
                    sidebarBackdrop.style.display = 'none';
                }

                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', openSidebar);
                }

                if (sidebarBackdrop) {
                    sidebarBackdrop.addEventListener('click', closeSidebar);
                }

                // Close on escape key
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && isSidebarOpen) {
                        closeSidebar();
                    }
                });
            });
        </script>
    </body>
</html>
