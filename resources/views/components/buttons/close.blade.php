<div>
    <div class="visible md:invisible">
        <div class="flex items-center">
            <button id="closePageBtn"
                class="inline-flex items-center px-4 py-2 mx-auto space-x-1 text-sm font-thin text-gray-800 bg-gray-300 rounded hover:bg-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>{{ __('Close') }}</span>
            </button>
        </div>
    </div>


    @push('scripts')
        <script src="{{ asset('js/mobile-communicator.js') }}"></script>
    @endpush
</div>
