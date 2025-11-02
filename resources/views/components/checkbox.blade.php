@props([
    'id' => null,
    'name' => null,
    'checked' => false,
    'disabled' => false,
])

<label class="inline-flex items-center select-none">
    <input type="checkbox"
        {{ $attributes->merge(['class' => 'h-4 w-4 shrink-0 text-primary focus:ring-primary border-slate-300 rounded']) }}
        @if ($id) id="{{ $id }}" @endif
        @if ($name) name="{{ $name }}" @endif @checked($checked)
        @disabled($disabled) />
    <span class="ml-3 block text-sm text-slate-900">{{ $slot }}</span>
</label>
