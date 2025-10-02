<div class="flex items-center justify-center w-32 gap-x-2">
    
    <x-buttons.show :model="$model" />
    <x-buttons.primary wireClick="$emit('initiateRemittanceCollection', {{ $model->id }})" :noMargin="true">
        <svg class="w-5 h-5 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg> {{ __("Collect") }}
    </x-buttons.primary>

</div>
