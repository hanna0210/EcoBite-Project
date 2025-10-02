{{-- <div class="grid grid-cols-2 md:grid-cols-3 gap-2 w-20 md:w-32"> --}}
<div class="flex flex-wrap gap-2">

    @can('view-order-chat')
        @php
            $chatUrl = route('order.chats', $model->code);
        @endphp
        <x-buttons.plain wireClick="$emit('newTab', '{{ $chatUrl }}')">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4l4 4 4-4h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
            </svg>
        </x-buttons.plain>
    @endcan
    @can('view-print-order')
        @php
            $printUrl = route('order.print', $model->code);
        @endphp
        <x-buttons.plain bgColor="bg-black" wireClick="$emit('newTab', '{{ $printUrl }}' )">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
            </svg>
        </x-buttons.plain>
    @endcan
    <x-buttons.show :model="$model" />
    @if (canI('edit-order'))
        @if (
            !in_array($model->status, ['failed', 'delivered', 'cancelled']) &&
                (!in_array($model->payment_status, ['review']) || empty($model->payment)))
            <x-buttons.edit :model="$model" />
        @endif
    @endif
    @if (canI('review-order-payment'))
        @if (in_array($model->payment_status, ['review']) && !empty($model->payment))
            <x-buttons.review :model="$model" />
        @endif
    @endif
</div>
