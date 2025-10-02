@section('title', __('Order Payment'))
<div class="">
    <div class="w-11/12 p-12 mx-auto mt-20 text-center border rounded shadow md:w-6/12 lg:w-4/12">
        @if ($error)
        <svg class="w-12 h-12 mx-auto text-red-500 md:h-24 md:w-24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <p class="text-xl font-medium text-center">{{__('Payment Failed')}}</p>
        <p>{{ $errorMessage }}</p>
        @else
        <svg class="w-12 h-12 mx-auto text-green-500 md:h-24 md:w-24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-xl font-medium text-center">{{__('Payment Successful')}}</p>
        <p>{{__('Order Payment was successful')}}</p>
        @endif

    </div>

    {{-- close --}}
    <p class="w-full p-4 text-sm text-center text-gray-500">{{__('You may close this window')}}</p>
    <x-buttons.close />
</div>
