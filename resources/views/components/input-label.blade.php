@props([
    'for' => null,
    'value' => null,
    'required' => false,
])

<label @if ($for) for="{{ $for }}" @endif
    {{ $attributes->merge(['class' => 'text-slate-900 text-sm font-medium mb-2 block']) }}>
    {{ $value ?? $slot }}
    @if ($required)
        <span class="text-primary">*</span>
    @endif
    @if ($attributes->get('hint'))
        <span class="ml-2 text-xs text-slate-500">{{ $attributes->get('hint') }}</span>
    @endif
</label>
