<button
    class="flex items-center p-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 border border-transparent rounded-lg bg-cyan-600 active:bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:shadow-outline-blue"
    wire:click="$emitUp('initiateLoginAs', {{ $model->id }} ) " title="{{ $hint ?? __('Login As Manager') }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
    </svg>
</button>
