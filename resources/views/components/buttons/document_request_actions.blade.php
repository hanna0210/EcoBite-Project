<div class="flex items-center gap-x-2">
    <x-buttons.show :model="$model" />
    {{-- upload icon --}}
    @if ($model->status == 'pending')
        <x-buttons.plain title="{{ __('Upload') }}" bgColor="bg-primary-600 space-x-1"
            wireClick="$emit('initiateDocumentUpload','{{ $model->id ?? ($id ?? '') }}')">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
            </svg>
            <span>{{ __('Upload') }}</span>
        </x-buttons.plain>
        {{-- only is status is pending --}}

        {{-- approve button --}}
        <x-buttons.plain title="{{ __('Approve') }}" bgColor="bg-green-500"
            wireClick="initiateActivate({{ $model->id ?? ($id ?? '') }})">
            {{ __('Approve') }}
        </x-buttons.plain>
        {{-- reject button --}}
        <x-buttons.plain title="{{ __('Reject') }}" bgColor="bg-red-500"
            wireClick="initiateDeactivate({{ $model->id ?? ($id ?? '') }})">
            {{ __('Reject') }}
        </x-buttons.plain>
    @endif

</div>
