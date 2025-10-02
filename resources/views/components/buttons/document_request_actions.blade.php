<div class="flex items-center gap-x-2">
    <x-buttons.show :model="$model" />
    {{-- upload icon --}}
    @if ($model->status == 'pending')
        <x-buttons.plain title="{{ __('Upload') }}" bgColor="bg-primary-600 space-x-1"
            wireClick="$emit('initiateDocumentUpload','{{ $model->id ?? ($id ?? '') }}')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
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
