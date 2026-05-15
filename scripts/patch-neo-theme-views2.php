<?php

declare(strict_types=1);

$root = dirname(__DIR__).DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'views';
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));

$pairs = [
    'mt-1 block w-full rounded-md border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-900' => 'mt-1 block w-full ui-field text-sm',
    'mt-1 rounded-md border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-900' => 'mt-1 ui-field text-sm',
    'mt-1 block w-64 rounded-md border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-900' => 'mt-1 block w-64 ui-field text-sm',
    'mt-1 block rounded-md border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-900' => 'mt-1 block ui-field text-sm',
    'w-full rounded-md border-gray-300 text-xs dark:border-gray-700 dark:bg-gray-900' => 'w-full ui-field text-xs',
    'rounded-md border-gray-300 text-sm dark:border-gray-700 dark:bg-gray-900' => 'ui-field text-sm',
    'w-20 rounded-md border border-gray-300 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-950' => 'ui-field w-20 border px-2 py-1 text-sm',
    'inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-900' => 'inline-flex items-center rounded-xl border border-cyan-400/30 px-4 py-2 text-sm text-cyan-100 transition hover:border-cyan-300/50 hover:bg-cyan-500/15',
    'rounded border-gray-300 dark:border-gray-700' => 'rounded border-cyan-400/35 bg-slate-950/40 accent-cyan-500 dark:border-cyan-500/40',
    'rounded border-gray-300' => 'rounded border-cyan-400/35 bg-slate-950/40 accent-cyan-500',
    'rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900' => 'ui-field',
    'rounded-md border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-900' => 'ui-field border px-3 py-2 text-sm',
    'rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900' => 'glass-panel p-4',
    'p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg' => 'glass-panel p-4 shadow-glow sm:rounded-2xl sm:p-8',
    'bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg' => 'glass-panel overflow-hidden shadow-glow sm:rounded-2xl',
    'rounded-lg border border-gray-200 bg-white p-6 text-sm text-gray-700 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200' => 'glass-panel p-6 text-sm text-slate-200',
    'rounded-md border border-gray-100 p-3 sm:grid-cols-12 dark:border-gray-700' => 'rounded-xl border border-cyan-500/10 bg-slate-950/30 p-3 backdrop-blur-sm sm:grid-cols-12',
    'flex flex-wrap items-end gap-3 rounded-md border border-gray-100 p-3 dark:border-gray-700' => 'flex flex-wrap items-end gap-3 rounded-xl border border-cyan-500/10 bg-slate-950/30 p-3 backdrop-blur-sm',
    'rounded-md border border-gray-100 p-3 text-sm dark:border-gray-700 dark:bg-gray-900/40' => 'rounded-xl border border-cyan-500/10 bg-slate-950/40 p-3 text-sm backdrop-blur-sm',
    'rounded-md border border-gray-100 p-4 dark:border-gray-700' => 'rounded-xl border border-cyan-500/10 bg-slate-950/30 p-4 backdrop-blur-sm',
    'mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-900' => 'ui-field mt-1 w-full border px-3 py-2 text-sm',
    'rounded-md bg-gray-900 px-3 py-1 text-xs font-semibold text-white hover:bg-gray-700 dark:bg-gray-100 dark:text-gray-900 dark:hover:bg-white' => 'rounded-lg bg-gradient-to-r from-cyan-600 to-teal-600 px-3 py-1 text-xs font-semibold text-white shadow-glow-sm hover:from-cyan-500 hover:to-teal-500',
    'rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-900' => 'rounded-xl border border-cyan-400/30 bg-cyan-500/10 px-4 py-2 text-sm font-semibold text-cyan-100 transition hover:border-cyan-300/50 hover:bg-cyan-500/20',
    'mt-1 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-900' => 'ui-field mt-1 w-full border px-3 py-2 text-sm',
    'rounded bg-gray-100 px-1 py-0.5 text-[11px] dark:bg-gray-800' => 'rounded bg-slate-900/80 px-1 py-0.5 text-[11px] text-cyan-200/90 ring-1 ring-cyan-400/20',
];

foreach ($rii as $file) {
    if (! $file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }
    $path = $file->getPathname();
    if (str_contains($path, 'welcome.blade.php')) {
        continue;
    }
    $content = file_get_contents($path);
    if ($content === false) {
        continue;
    }
    $new = str_replace(array_keys($pairs), array_values($pairs), $content);
    if ($new !== $content) {
        file_put_contents($path, $new);
        fwrite(STDERR, "patched2: {$path}\n");
    }
}
