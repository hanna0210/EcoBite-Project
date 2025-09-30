<div>
    <hr />
    @if (count($menu ?? []) > 6)
        <x-menu-item title="{{ __('Installed Extensions') }}" route="marketplace">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
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
