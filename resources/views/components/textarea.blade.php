@props([
    'name' => null,
    'rows' => 4,
    'placeholder' => null,
    'disabled' => false,
])

<div class="relative">
    <textarea
        {{ $attributes->merge(['class' => 'w-full text-slate-900 text-sm border border-slate-300 px-4 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary placeholder:text-slate-400']) }}
        @if ($name) name="{{ $name }}" @endif rows="{{ $rows }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif @disabled($disabled)>{{ $slot }}</textarea>
</div>
