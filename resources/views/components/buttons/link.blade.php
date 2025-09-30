<a class="flex items-center p-2 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 border border-transparent rounded-lg bg-primary-600 active:bg-red-600 hover:bg-primary-700 focus:outline-none focus:shadow-outline-red"
    href="{{ $link ?? '#' }}" target="{{ $newTab ?? false ? '' : '_blank' }}">
    <svg class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
    </svg>
    @empty($title)
        {{ __('New') }}
    @else
        {{ $title }}
    @endempty
</a>
