@props([
    'name' => null,
    'type' => 'text',
    'placeholder' => null,
    'disabled' => false,
])

<div class="relative flex items-center w-full">
    <input
        {{ $attributes->merge(['class' => 'w-full text-slate-900 text-sm border border-slate-300 px-4 py-3 pr-8 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary placeholder:text-slate-400']) }}
        @if ($name) name="{{ $name }}" @endif type="{{ $type }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif @disabled($disabled) />
</div>
