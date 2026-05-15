<?php

declare(strict_types=1);

$root = dirname(__DIR__).DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'views';
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));

$pairs = [
    'overflow-hidden rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800' => 'glass-panel overflow-hidden p-6',
    'space-y-4 rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800' => 'glass-panel space-y-4 p-6',
    'space-y-3 rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800' => 'glass-panel space-y-3 p-6',
    'rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800' => 'glass-panel p-6',
    'rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800' => 'glass-panel p-4',
    'rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900' => 'glass-panel p-4',
    'rounded-lg border border-gray-200 bg-white p-6 text-sm shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200' => 'glass-panel p-6 text-sm text-slate-200',
    'mb-6 flex flex-wrap gap-2 rounded-lg border border-gray-200 bg-white p-3 text-sm shadow-sm dark:border-gray-700 dark:bg-gray-800' => 'glass-panel mb-6 flex flex-wrap gap-2 p-3 text-sm',
    'mb-4 flex flex-wrap items-end gap-3 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800' => 'glass-panel mb-4 flex flex-wrap items-end gap-3 p-4',
    'mb-4 flex flex-wrap items-end gap-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800' => 'glass-panel mb-4 flex flex-wrap items-end gap-3 p-4',
    'bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6' => 'glass-panel overflow-hidden p-6 sm:rounded-2xl',
    'rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500' => 'btn-neon rounded-xl px-4 py-2 text-sm font-semibold',
    'text-indigo-600 hover:underline' => 'text-cyan-300 hover:text-cyan-100 hover:underline',
    'divide-y divide-gray-200 dark:divide-gray-700' => 'divide-y divide-cyan-500/15',
    'divide-gray-200 dark:divide-gray-700' => 'divide-cyan-500/15',
    'text-gray-800 dark:text-gray-200' => 'text-slate-100',
    'text-gray-900 dark:text-gray-100' => 'text-slate-50',
    'text-gray-700 dark:text-gray-200' => 'text-slate-200',
    'text-gray-700 dark:text-gray-300' => 'text-slate-300',
    'text-gray-600 dark:text-gray-300' => 'text-slate-400',
    'text-gray-600 dark:text-gray-400' => 'text-slate-400',
    'text-gray-500 dark:text-gray-400' => 'text-slate-500',
    'border-gray-200 dark:border-gray-700' => 'border-cyan-500/15',
    'border-gray-300 dark:border-gray-600' => 'border-cyan-500/20',
    'border-gray-200 dark:border-gray-600' => 'border-cyan-500/15',
    'border-gray-100 dark:border-gray-700' => 'border-cyan-500/10',
    'border-gray-200 dark:border-gray-800' => 'border-cyan-500/15',
    'border-red-200 bg-red-50' => 'border-rose-400/30 bg-rose-500/10',
    'dark:border-red-900 dark:bg-red-950 dark:text-red-100' => 'border-rose-400/25 bg-rose-950/40 text-rose-100',
    'border-green-200 bg-green-50' => 'border-emerald-400/30 bg-emerald-500/10',
    'dark:border-green-900 dark:bg-green-950 dark:text-green-100' => 'border-emerald-400/25 bg-emerald-950/40 text-emerald-100',
    'border-amber-200 bg-amber-50' => 'border-amber-400/30 bg-amber-500/10',
    'dark:border-amber-900 dark:bg-amber-950 dark:text-amber-100' => 'border-amber-400/25 bg-amber-950/40 text-amber-100',
    'text-indigo-600' => 'text-cyan-300',
    'ring-indigo-500' => 'ring-cyan-400',
    'ring-indigo-600' => 'ring-cyan-500',
    'focus:ring-indigo-500' => 'focus:ring-cyan-400',
    'focus:ring-indigo-600' => 'focus:ring-cyan-500',
    'focus:border-indigo-500' => 'focus:border-cyan-400',
    'focus:border-indigo-600' => 'focus:border-cyan-500',
    'border-indigo-400' => 'border-cyan-400',
    'text-indigo-700' => 'text-cyan-200',
    'text-indigo-800' => 'text-cyan-100',
    'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-100' => 'bg-cyan-500/20 text-cyan-50 shadow-glow-sm',
    'text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700' => 'text-slate-300 hover:bg-cyan-500/10 dark:text-slate-200 dark:hover:bg-cyan-500/10',
];

foreach ($rii as $file) {
    if (! $file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }
    $path = $file->getPathname();
    $content = file_get_contents($path);
    if ($content === false) {
        continue;
    }
    $new = str_replace(array_keys($pairs), array_values($pairs), $content);
    if ($new !== $content) {
        file_put_contents($path, $new);
        fwrite(STDERR, "patched: {$path}\n");
    }
}
