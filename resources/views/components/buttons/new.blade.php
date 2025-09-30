<button
    class="flex items-center p-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 border border-transparent rounded-lg bg-primary-600 active:bg-red-600 hover:bg-primary-700 focus:outline-none focus:shadow-outline-red"
    wire:click="$emitUp('showCreateModal')">
    <svg class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
    </svg>
@empty($title)
    {{ __('New') }}
@else
    {{ $title }}
    @endempty
</button>
