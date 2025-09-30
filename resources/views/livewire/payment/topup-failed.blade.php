@section('title', __('Wallet Topup'))
<div class="">
    <div class="w-11/12 p-12 mx-auto mt-20 border rounded shadow md:w-6/12 lg:w-4/12">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-12 h-12 mx-auto text-yellow-400 md:h-24 md:w-24">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
</svg>
        <p class="text-xl font-medium text-center">{{__('Failed')}}</p>
        <p class="text-sm text-center">{{ $msg ?? '' }}</p>
    </div>

    {{-- close --}}
    <p class="w-full p-4 text-sm text-center text-gray-500">{{__('You may close this window')}}</p>
</div>
