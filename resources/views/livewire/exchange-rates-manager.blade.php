<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">{{ __('Exchange Rates Manager') }}</h3>
            <button wire:click="toggleForm"
                class="px-4 py-2 bg-primary-500 text-theme rounded-md hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
                {{ $showForm ? __('Hide Form') : __('Update Rates') }}
            </button>
        </div>
    </div>

    <div class="p-6">
        <!-- Date Selector -->
        <div class="mb-6">
            <label for="effectiveDate" class="block text-sm font-medium text-gray-700 mb-2">
                {{ __('Effective Date') }}
            </label>
            <div class="flex items-center gap-2">
                <input type="date" id="effectiveDate" wire:model="effectiveDate"
                    class="block w-48 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <button wire:click="loadRatesForDate"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                    {{ __('Load Rates') }}
                </button>
            </div>
            @error('effectiveDate')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Exchange Rates Table -->
        <div class="overflow-hidden border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Currency') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Code') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Symbol') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Exchange Rate') }}
                        </th>
                        @if ($showForm)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Actions') }}
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($exchangeRates as $index => $rate)
                        <tr class="{{ $rate['is_base'] ? 'bg-primary-100' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $rate['currency_name'] }}
                                        @if ($rate['is_base'])
                                            <span
                                                class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-200 text-primary-800">
                                                {{ __('Base') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $rate['currency_code'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $rate['currency_symbol'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($showForm && $editingRateId === $index)
                                    <div class="flex items-center gap-2">
                                        <input type="number" step="0.00000001"
                                            wire:model.defer="exchangeRates.{{ $index }}.rate"
                                            onkeydown="if(event.key === 'Enter') { @this.updateRate({{ $index }}, this.value); }"
                                            class="block w-32 px-3 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 {{ $rate['is_base'] ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                            {{ $rate['is_base'] ? 'readonly' : '' }}>
                                        <button
                                            onclick="@this.updateRate({{ $index }}, this.previousElementSibling.value)"
                                            class="text-green-600 hover:text-green-800 p-1"
                                            title="{{ __('Save') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    @error("exchangeRates.{$index}.rate")
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                @else
                                    <div class="flex items-center justify-between">
                                        <span
                                            class="text-sm font-mono {{ $rate['is_base'] ? 'text-primary-600 font-semibold' : 'text-gray-900' }}">
                                            {{ $rate['rate'] ? number_format($rate['rate'], 8) : __('Not Set') }}
                                        </span>
                                        @if ($showForm && !$rate['is_base'])
                                            <button wire:click="editRate({{ $index }})"
                                                class="ml-2 text-primary-600 hover:text-primary-800 p-1"
                                                title="{{ __('Edit') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            @if ($showForm)
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if (!$rate['is_base'] && $rate['id'])
                                        <button wire:click="deleteRate({{ $rate['currency_id'] }})"
                                            class="text-red-600 hover:text-red-800 p-1" title="{{ __('Delete') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Action Buttons -->
        @if ($showForm)
            <div class="mt-6 flex items-center justify-end gap-3">
                <button wire:click="toggleForm"
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                    {{ __('Cancel') }}
                </button>
                <button wire:click="saveRates"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                    {{ __('Save All Rates') }}
                </button>
            </div>
        @endif

        <!-- Info Note -->
        <div class="mt-4 p-4 bg-primary-100 border border-primary-200 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-primary-700">
                        <strong>{{ __('Note:') }}</strong>
                        {{ __('The base currency (highlighted in blue) always has a rate of 1.0 and cannot be modified. All other rates represent the conversion rate from the base currency to that currency.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div wire:loading.flex class="absolute inset-0 bg-white bg-opacity-75 items-center justify-center rounded-lg">
        <div class="flex items-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="text-primary">{{ __('Loading...') }}</span>
        </div>
    </div>
</div>
