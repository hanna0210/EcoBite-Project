@section('title', __('Wallet Topup Payment'))
<div class="">
    <div class="w-11/12 p-12 mx-auto mt-20 text-center border rounded shadow md:w-6/12 lg:w-4/12">
        @if ($error)
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-12 h-12 mx-auto text-red-500 md:h-24 md:w-24">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
</svg>
            <p class="text-xl font-medium text-center">{{ __('Payment Failed') }}</p>
            <p>{{ $errorMessage }}</p>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-12 h-12 mx-auto text-green-500 md:h-24 md:w-24">
  <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
</svg>
            <p class="text-xl font-medium text-center">{{ __('Payment Successful') }}</p>
            <p>{{ __('Wallet Topup Payment was successful') }}</p>
        @endif

    </div>

    {{-- close --}}
    <p class="w-full p-4 text-sm text-center text-gray-500">{{ __('You may close this window') }}</p>
    <x-buttons.close />
</div>
