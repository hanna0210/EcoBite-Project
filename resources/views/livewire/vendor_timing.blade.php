<div>
    <x-modal-lg confirmText="{{ __('Save') }}" action="saveDays" :clickAway="false">
        <p class="text-xl font-semibold">{{ __('Set vendor open/close time') }}</p>
        <div class="space-y-1">
            <p class="text-red-500 text-sm">{{ __('Note') }}</p>
            <p class="text-xs text-gray-600">
                {{ __('Vendor must setup open and close time before order scheduling can work, even if the vendor enabled the option to allow customer to schedule order.') }}
            </p>
            <p class="text-xs text-gray-600">
                {{ __('Vendor also need to setup open/close time for system to auto close/open vendor to accept order.') }}
            </p>
        </div>
        <div class="flex items-center py-3 mt-5 gap-2 border-t border-b">
            <div class="w-4/12">{{ __('Day') }}</div>
            <div class="w-4/12">
                {{ __('Openning Time') }}
            </div>
            <div class="w-4/12 pl-2">
                {{ __('Closing Time') }}
            </div>
        </div>
        @if (!empty($workingDays))
            @foreach ($workingDays as $key => $workingDay)
                <div class="flex items-start my-1 pb-3 gap-2 border-b">
                    <div class="w-4/12">
                        <x-select :options="$days ?? []" name="workingDays.{{ $key }}.day_id"
                            selected="{{ $workingDays[$key]['day_id'] }}" />
                    </div>
                    <div class="w-4/12">
                        <x-input title="" type="time" name="workingDays.{{ $key }}.open"
                            noMargin="true" />
                    </div>
                    <div class="w-4/12 pl-2">
                        <x-input title="" type="time" name="workingDays.{{ $key }}.close"
                            noMargin="true" />
                    </div>
                    <div class="flex items-center ml-2 space-x-2">
                        <x-buttons.plain title="{{ __('Delete') }}" wireClick="removeDay('{{ $key }}')"
                            bgColor="bg-red-500">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </x-buttons.plain>
                    </div>
                </div>
            @endforeach
        @endif
        <x-buttons.primary title="{{ __('New') }}" type="button" wireClick="addNewTiming" />
    </x-modal-lg>
</div>
