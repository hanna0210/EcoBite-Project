<div class="flex items-center gap-x-2">
    {{-- details --}}
    <x-buttons.plain title="{{ __('Details') }}" bgColor="bg-primary-500"
        onClick="window.open('{{ route('users.details', ['id' => $model->id]) }}')">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
    </x-buttons.plain>

    {{-- TODO: View driver location on map --}}

    @if ($model->id != \Auth::id())

        <x-buttons.show :model="$model" />
        @hasanyrole('admin')
            @if ($model->hasAnyRole('city-admin'))
                <x-buttons.assign :model="$model" />
            @endif
        @endhasanyrole
        @can('edit-driver')
            <x-buttons.edit :model="$model" />

            @if ($model->is_active)
                <x-buttons.deactivate :model="$model" />
            @else
                <x-buttons.activate :model="$model" />
            @endif
        @endcan
        @can('delete-driver')
            <x-buttons.delete :model="$model" />
        @endcan
    @else
        <span class="text-xs italic font-thin text-gray-400">{{ __('Current Account') }}</span>
    @endif

</div>
