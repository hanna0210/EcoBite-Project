<div class="flex items-center gap-x-2">


    @hasanyrole('admin|city-admin')
        <x-buttons.assign :model="$model" />
        <x-buttons.loginas :model="$model" />
    @endhasanyrole
    <x-buttons.time :model="$model" />
    <x-buttons.show :model="$model" />
    <x-buttons.edit :model="$model" />

    @can('manage-vendor-status')
        @if ($model->is_active)
            <x-buttons.deactivate :model="$model" />
        @else
            <x-buttons.activate :model="$model" />
        @endif

        <x-buttons.delete :model="$model" />
    @endcan

    @role('manager')
        @if ($model->is_active)
            <x-buttons.deactivate :model="$model" />
        @endif
    @endrole


    @php
        $bgColor = 'bg-red-500';
        $title = __('Go Offline');
        $action = 'goOffline';
        if (!$model->is_open) {
            $bgColor = 'bg-green-500';
            $title = __('Go Online');
            $action = 'goOnline';
        }
    @endphp

    <x-buttons.plain :bgColor="$bgColor" :title="$title" wireClick="{{ $action }}('{{ $model->id }}')">
        @if ($model->is_open)
            <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"></path>
            </svg>
        @else
            <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9m0 0l3-3m-3 3l-3-3"></path>
            </svg>
        @endif
    </x-buttons.plain>



</div>
