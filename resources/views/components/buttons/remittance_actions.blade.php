<div class="flex items-center justify-center w-32 gap-x-2">
    
    <x-buttons.show :model="$model" />
    <x-buttons.primary wireClick="$emit('initiateRemittanceCollection', {{ $model->id }})" :noMargin="true">
        <svg class="w-5 h-5 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
        </svg> {{ __("Collect") }}
    </x-buttons.primary>

</div>
