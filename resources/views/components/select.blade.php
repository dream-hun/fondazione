@props([
    'name' => null,
    'placeholder' => null,
    'disabled' => false,
    'options' => [], // [['value' => '', 'label' => '']]
    'optionValue' => 'value',
    'optionLabel' => 'label',
])

<div class="relative flex items-center">
    <select
        {{ $attributes->merge(['class' => 'w-full text-slate-900 text-sm border border-slate-300 px-4 py-3 pr-8 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary']) }}
        @if ($name) name="{{ $name }}" @endif @disabled($disabled)>
        @if ($placeholder)
            <option value="" disabled selected>{{ $placeholder }}</option>
        @endif
        @forelse($options as $option)
            <option value="{{ is_array($option) ? $option[$optionValue] ?? '' : $option }}">
                {{ is_array($option) ? $option[$optionLabel] ?? '' : $option }}
            </option>
        @empty
            {{ $slot }}
        @endforelse
    </select>
</div>
