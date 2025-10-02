<div class="flex items-center gap-x-2">
    @production
        @hasanyrole('admin')
            @if (!$model->hasAnyRole('client', 'driver'))
                <x-buttons.loginas :model="$model" hint="{{ __('Login As User') }}" />
            @endif
        @endhasanyrole
    @endproduction

    {{-- details --}}
    <x-buttons.plain title="{{ __('Details') }}" bgColor="bg-primary-500"
        onClick="window.open('{{ route('users.details', ['id' => $model->id]) }}')">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
    </x-buttons.plain>

    @if ($model->id != \Auth::id())
        @can('assign-permissions')
            @php
                $link = route('users.assign-permissions', ['id' => $model->id]);
            @endphp
            <x-buttons.plain title="{{ __('Assign permission') }}" onClick="window.open('{{ $link }}', '_blank')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </x-buttons.plain>
        @endcan
        <x-buttons.show :model="$model" />
        @hasanyrole('admin')
            @if ($model->hasAnyRole('city-admin'))
                <x-buttons.assign :model="$model" />
            @endif
        @endhasanyrole
        <x-buttons.edit :model="$model" />
        @if ($model->is_active)
            <x-buttons.deactivate :model="$model" />
        @else
            <x-buttons.activate :model="$model" />
        @endif

        <x-buttons.delete :model="$model" />
    @else
        <span class="text-xs italic font-thin text-gray-400">{{ __('Current Account') }}</span>
    @endif

</div>
