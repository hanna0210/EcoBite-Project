{{-- <div class="grid grid-cols-2 md:grid-cols-3 gap-2 w-20 md:w-32"> --}}
<div class="flex flex-wrap gap-2">

    @can('view-order-chat')
        @php
            $chatUrl = route('order.chats', $model->code);
        @endphp
        <x-buttons.plain wireClick="$emit('newTab', '{{ $chatUrl }}')">
            <x-lineawesome-comments-solid class="w-5 h-5" />
        </x-buttons.plain>
    @endcan
    @can('view-print-order')
        @php
            $printUrl = route('order.print', $model->code);
        @endphp
        <x-buttons.plain bgColor="bg-black" wireClick="$emit('newTab', '{{ $printUrl }}' )">
            <x-lineawesome-print-solid class="w-5 h-5" />
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
