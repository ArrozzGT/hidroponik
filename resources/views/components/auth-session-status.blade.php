@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-primary-600 bg-primary-50 border border-primary-100 rounded-2xl px-5 py-3']) }}>
        {{ $status }}
    </div>
@endif
