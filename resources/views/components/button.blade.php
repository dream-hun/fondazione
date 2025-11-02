@props([
    'type' => 'button',
    'variant' => 'primary', // primary | secondary | outline | link
    'size' => 'md', // sm | md | lg
    'disabled' => false,
])

@php
    $base =
        'inline-flex items-center justify-center font-semibold rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary/40 disabled:opacity-60 disabled:cursor-not-allowed';

    $sizes =
        [
            'sm' => 'text-sm px-3 py-2',
            'md' => 'text-sm px-4 py-2.5',
            'lg' => 'text-base px-5 py-3',
        ][$size] ?? 'text-sm px-4 py-2.5';

    $variants =
        [
            'primary' => 'bg-primary text-white hover:bg-secondary shadow-sm hover:shadow-md',
            'secondary' => 'bg-gray-100 text-slate-900 hover:bg-gray-200',
            'outline' => 'border border-slate-300 text-slate-900 hover:border-primary hover:text-primary',
            'link' => 'text-primary hover:underline px-0 py-0',
        ][$variant] ?? 'bg-primary text-white hover:bg-secondary';

    $classes = trim("$base $sizes $variants");
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @disabled($disabled)>
    {{ $slot }}
    @if ($variant === 'link')
        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6m0 0v6m0-6L10 16" />
        </svg>
    @endif
</button>
