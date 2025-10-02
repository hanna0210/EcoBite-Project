<div>
    <hr />
    @if (count($menu ?? []) > 6)
        <x-menu-item title="{{ __('Installed Extensions') }}" route="marketplace">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
        </x-menu-item>
    @else
        @foreach ($menu as $navItem)
            @if (Route::has($navItem->route))
                @if (empty($navItem->roles ?? '') && empty($navItem->permissions ?? ''))
                    <x-menu-item title="{{ $navItem->name }}" route="{{ $navItem->route }}">
                        {{ svg($navItem->icon)->class('w-5 h-5') }}
                    </x-menu-item>
                @else
                    @if ($navItem->permissions == null || empty($navItem->permissions))
                        @hasanyrole($navItem->roles)
                            <x-menu-item title="{{ $navItem->name }}" route="{{ $navItem->route }}">
                                {{ svg($navItem->icon)->class('w-5 h-5') }}
                            </x-menu-item>
                        @endhasanyrole
                    @elseif($navItem->permissions != null && !empty($navItem->permissions))
                        @can($navItem->permissions)
                            <x-menu-item title="{{ $navItem->name }}" route="{{ $navItem->route }}">
                                {{ svg($navItem->icon)->class('w-5 h-5') }}
                            </x-menu-item>
                        @endcan
                    @endif
                @endif
            @endif
        @endforeach
    @endif
</div>
