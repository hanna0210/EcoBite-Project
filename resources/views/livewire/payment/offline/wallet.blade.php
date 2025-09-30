<div>
    <div class="">
        <div wire:loading.flex>
            <div class="w-11/12 p-12 mx-auto mt-10 border rounded shadow md:w-6/12 lg:w-4/12">
                <svg class="w-12 h-12 mx-auto text-gray-400 md:h-24 md:w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xl font-medium text-center">{{ __('Wallet Topup') }}</p>
                <p class="text-sm text-center">{{ __('Please wait while we process your payment') }}</p>
            </div>
        </div>

        <div wire:loading.remove.saveOfflinePayment
            class="w-11/12 p-4 mx-auto mt-10 border rounded shadow md:w-6/12 lg:w-4/12 md:grid-cols-2">

            {{-- form --}}
            <div class="{{ $done ? 'hidden' : 'block' }}">
                <div class="flex items-center pb-1 my-1 border-b">
                    <div class="">
                        {{ __('Wallet Topup') }}
                    </div>
                    <div class="ml-auto text-right">
                        <p class="text-2xl font-bold">{{ currencyFormat($selectedModel->amount) }}</p>
                        <p class="text-sm font-light">{{ $selectedPaymentMethod->name }}</p>
                    </div>
                </div>
                {{-- instruction --}}
                <p class="mt-1 text-lg font-medium">{{ __('Instructions') }}</p>
                <p class="text-md">{!! nl2br(e($selectedPaymentMethod->instruction)) !!}</p>

                <p class="pt-2 mt-2 text-lg font-medium border-t">{{ __('Payment Details') }}</p>
                {{-- form --}}
                <x-form action="saveOfflinePayment" :noClass="true">
                    <x-input title="{{ __('Transaction Code') }}" name="paymentCode" />
                    <div class="my-4">
                        <span class="text-gray-700 my-2">{{ __('Transaction Photo') }}</span>
                        <x-input.filepond wire:model="photo"
                            acceptedFileTypes="['image/png', 'image/jpeg', 'image/jpg']" allowImagePreview
                            allowFileSizeValidation
                            maxFileSize="{{ setting('filelimit.max_product_digital_files_size', 2) }}mb" />
                    </div>
                    <x-buttons.primary title="{{ __('Submit') }}" />
                </x-form>
            </div>


            {{-- completed --}}
            <div class="{{ $done ? 'block' : 'hidden' }}">
                @if ($error)
                    <svg class="w-12 h-12 mx-auto text-red-500 md:h-24 md:w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                    </svg>
                @else
                    <svg class="w-12 h-12 mx-auto text-green-500 md:h-24 md:w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 0h.008v.008H12V12zm-2.25 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm3 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                @endif
                <p class="text-sm font-medium text-center">{{ $errorMessage }}</p>
            </div>

        </div>





        {{-- close --}}
        <p class="{{ $done ? 'block' : 'hidden' }} w-full p-4 text-sm text-center text-gray-500">
            {{ __('You can close this window') }}</p>
        <p class="{{ $done ? 'hidden' : 'block' }} w-full p-4 text-sm text-center text-gray-500">
            {{ __('Do not close this window') }}</p>

    </div>
</div>
