<button
    class="flex items-center p-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 border border-transparent rounded-lg bg-cyan-600 active:bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:shadow-outline-blue"
    wire:click="$emitUp('initiateLoginAs', {{ $model->id }} ) " title="{{ $hint ?? __('Login As Manager') }}">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
    </svg>
</button>
