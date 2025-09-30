<ul class="mt-6">


    {{-- dashboard --}}
    <x-menu-item title="{{ __('Dashboard') }}" route="dashboard">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
        </svg>
    </x-menu-item>

    {{-- modules --}}
    @can('view-vendor-types')
        {{-- Vendor Types --}}
        <x-menu-item title="{{ __('Modules') }}" route="vendor.types">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
            </svg>
        </x-menu-item>
    @endcan

    @can('view-banners')
        <x-menu-item title="{{ __('Banners') }}" route="banners">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
        </x-menu-item>
    @endcan

    @can('view-flash-sales')
        <x-menu-item title="{{ __('Flash Sales') }}" route="flash.sales">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.547 5.975 5.975 0 01-2.133-1A3.75 3.75 0 0012 18z" />
            </svg>
        </x-menu-item>
    @endcan

    <x-hr />
    {{-- Vendors --}}
    @can('view-vendors')
        <x-group-menu-item routePath="vendors*" title="{{ __('Vendor Mangt.') }}" icon="heroicon-o-cube">


            @can('view-zones')
                <x-menu-item title="{{ __('Zones') }}" route="zones">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                    </svg>
                </x-menu-item>
            @endcan
            @can('set-vendor-fees')
                <x-menu-item title="{{ __('Fees') }}" route="vendor.fees">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 21 4 C 19.207031 4 17.582031 4.335938 16.3125 4.96875 C 15.042969 5.601563 14 6.632813 14 8 L 14 12 C 14 12.128906 14.042969 12.253906 14.0625 12.375 C 13.132813 12.132813 12.101563 12 11 12 C 9.207031 12 7.582031 12.335938 6.3125 12.96875 C 5.042969 13.601563 4 14.632813 4 16 L 4 24 C 4 25.367188 5.042969 26.398438 6.3125 27.03125 C 7.582031 27.664063 9.207031 28 11 28 C 12.792969 28 14.417969 27.664063 15.6875 27.03125 C 16.957031 26.398438 18 25.367188 18 24 L 18 23.59375 C 18.917969 23.835938 19.921875 24 21 24 C 22.792969 24 24.417969 23.664063 25.6875 23.03125 C 26.957031 22.398438 28 21.367188 28 20 L 28 8 C 28 6.632813 26.957031 5.601563 25.6875 4.96875 C 24.417969 4.335938 22.792969 4 21 4 Z M 21 6 C 22.523438 6 23.878906 6.328125 24.78125 6.78125 C 25.683594 7.234375 26 7.710938 26 8 C 26 8.289063 25.683594 8.765625 24.78125 9.21875 C 23.878906 9.671875 22.523438 10 21 10 C 19.476563 10 18.121094 9.671875 17.21875 9.21875 C 16.316406 8.765625 16 8.289063 16 8 C 16 7.710938 16.316406 7.234375 17.21875 6.78125 C 18.121094 6.328125 19.476563 6 21 6 Z M 16 10.84375 C 16.105469 10.902344 16.203125 10.976563 16.3125 11.03125 C 17.582031 11.664063 19.207031 12 21 12 C 22.792969 12 24.417969 11.664063 25.6875 11.03125 C 25.796875 10.976563 25.894531 10.902344 26 10.84375 L 26 12 C 26 12.289063 25.683594 12.765625 24.78125 13.21875 C 23.878906 13.671875 22.523438 14 21 14 C 19.476563 14 18.121094 13.671875 17.21875 13.21875 C 16.316406 12.765625 16 12.289063 16 12 Z M 11 14 C 12.523438 14 13.878906 14.328125 14.78125 14.78125 C 15.683594 15.234375 16 15.710938 16 16 C 16 16.289063 15.683594 16.765625 14.78125 17.21875 C 13.878906 17.671875 12.523438 18 11 18 C 9.476563 18 8.121094 17.671875 7.21875 17.21875 C 6.316406 16.765625 6 16.289063 6 16 C 6 15.710938 6.316406 15.234375 7.21875 14.78125 C 8.121094 14.328125 9.476563 14 11 14 Z M 26 14.84375 L 26 16 C 26 16.289063 25.683594 16.765625 24.78125 17.21875 C 23.878906 17.671875 22.523438 18 21 18 C 19.863281 18 18.835938 17.8125 18 17.53125 L 18 16 C 18 15.871094 17.957031 15.746094 17.9375 15.625 C 18.867188 15.867188 19.898438 16 21 16 C 22.792969 16 24.417969 15.664063 25.6875 15.03125 C 25.796875 14.976563 25.894531 14.902344 26 14.84375 Z M 6 18.84375 C 6.105469 18.902344 6.203125 18.976563 6.3125 19.03125 C 7.582031 19.664063 9.207031 20 11 20 C 12.792969 20 14.417969 19.664063 15.6875 19.03125 C 15.796875 18.976563 15.894531 18.902344 16 18.84375 L 16 20 C 16 20.289063 15.683594 20.765625 14.78125 21.21875 C 13.878906 21.671875 12.523438 22 11 22 C 9.476563 22 8.121094 21.671875 7.21875 21.21875 C 6.316406 20.765625 6 20.289063 6 20 Z M 26 18.84375 L 26 20 C 26 20.289063 25.683594 20.765625 24.78125 21.21875 C 23.878906 21.671875 22.523438 22 21 22 C 19.863281 22 18.835938 21.839844 18 21.5625 L 18 19.625 C 18.917969 19.867188 19.917969 20 21 20 C 22.792969 20 24.417969 19.664063 25.6875 19.03125 C 25.796875 18.976563 25.894531 18.902344 26 18.84375 Z M 6 22.84375 C 6.105469 22.902344 6.203125 22.976563 6.3125 23.03125 C 7.582031 23.664063 9.207031 24 11 24 C 12.792969 24 14.417969 23.664063 15.6875 23.03125 C 15.796875 22.976563 15.894531 22.902344 16 22.84375 L 16 24 C 16 24.289063 15.683594 24.765625 14.78125 25.21875 C 13.878906 25.671875 12.523438 26 11 26 C 9.476563 26 8.121094 25.671875 7.21875 25.21875 C 6.316406 24.765625 6 24.289063 6 24 Z"/></svg>
                </x-menu-item>
            @endcan

            <x-menu-item title="{{ __('Vendors') }}" route="vendors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
            </x-menu-item>

            @can('view-favourites')
                <x-menu-item title="{{ __('Favourites') }}" route="vendor.favourites">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>
                </x-menu-item>
            @endcan

            {{-- vendors documents --}}
            @can('view-vendor-documents')
                <x-menu-item title="{{ __('Document Requests') }}" route="vendors.documents">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 6 3 L 6 29 L 26 29 L 26 9.59375 L 25.71875 9.28125 L 19.71875 3.28125 L 19.40625 3 Z M 8 5 L 18 5 L 18 11 L 24 11 L 24 27 L 8 27 Z M 20 6.4375 L 22.5625 9 L 20 9 Z M 11 13 L 11 15 L 21 15 L 21 13 Z M 11 17 L 11 19 L 21 19 L 21 17 Z M 11 21 L 11 23 L 21 23 L 21 21 Z"/></svg>
                </x-menu-item>
            @endcan

        </x-group-menu-item>
    @endcan


    @hasanyrole('manager')
        @showDeliveryBoys
        <x-hr />
        <x-menu-item title="{{ __('Delivery Boys') }}" route="my.drivers">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
        </x-menu-item>
        <x-menu-item title="{{ __('Delivery Settings') }}" route="my.driver.settings">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </x-menu-item>
        @endshowDeliveryBoys
    @endhasanyrole



    @can('view-categories')
        <x-group-menu-item routePath="categories*" title="{{ __('Categories') }}" icon="heroicon-o-bookmark">

            <x-menu-item title="{{ __('Categories') }}" route="categories">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h1.372c.516 0 .966.351 1.082.852l1.106 4.423a1.875 1.875 0 01-1.725 2.27H4.5A2.25 2.25 0 012.25 12.75zm0 0V17.25A2.25 2.25 0 004.5 19.5h9.75a2.25 2.25 0 002.25-2.25v-4.5M7.5 9.75H4.5A2.25 2.25 0 002.25 12v3m15-3h-1.5a2.25 2.25 0 00-2.25 2.25v4.5m0 0a2.25 2.25 0 002.25 2.25H19.5a2.25 2.25 0 002.25-2.25V12a2.25 2.25 0 00-2.25-2.25H18m-1.5 0v3" />
                </svg>
            </x-menu-item>
             <x-menu-item title="{{ __('SubCategories') }}" route="subcategories">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                 </svg>
             </x-menu-item>
        </x-group-menu-item>
    @endcan

     @can('view-tags')
         <x-menu-item title="{{ __('Tags') }}" route="tags">
             <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
             </svg>
         </x-menu-item>
     @endcan

    {{-- Products --}}
    @showProduct
    <x-group-menu-item routePath="product/*" title="{{ __('Items') }}" icon="heroicon-o-archive">

         <x-menu-item title="{{ __('Items') }}" route="products">
             <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
             </svg>
         </x-menu-item>

        @can('view-product-requests')
             <x-menu-item title="{{ __('Item Requests') }}" route="products.requests">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c-1.171-1.025-3.071-1.025-4.242 0-1.172 1.025-1.172 2.687 0 3.712.203.179.43.326.67.442.745.361 1.45.999 1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                 </svg>
             </x-menu-item>
        @endcan

        <x-hr />

        @can('view-product-brands')
             <x-menu-item title="{{ __('Item Brands') }}" route="products.brands">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5l-3.9 19.5m-2.1-19.5l-3.9 19.5" />
                 </svg>
             </x-menu-item>
        @endcan

         <x-menu-item title="{{ __('Menus') }}" route="products.menus">
             <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
             </svg>
         </x-menu-item>

        <x-menu-item title="{{ __('Option Groups') }}" route="products.options.group">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z" />
            </svg>
        </x-menu-item>

        <x-menu-item title="{{ __('Options') }}" route="products.options">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
            </svg>
        </x-menu-item>
        @can('view-favourites')
            <x-menu-item title="{{ __('Favourites') }}" route="favourites">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.563.563 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.563.563 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                 </svg>
            </x-menu-item>
        @endcan
    </x-group-menu-item>
    @endshowProduct

    {{-- Package --}}
    @showPackage
    <x-group-menu-item routePath="package/*" title="{{ __('Package Delivery') }}" icon="heroicon-o-globe">

        @can('view-package-types')
            <x-menu-item title="{{ __('Package Types') }}" route="package.types">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                 </svg>
            </x-menu-item>
        @endcan

        @can('view-countries')
            <x-menu-item title="{{ __('Countries') }}" route="package.countries">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3s-4.5 4.03-4.5 9 2.015 9 4.5 9Zm8.716-6.747a9.004 9.004 0 0 0 0-8.506M3.284 5.253a9.004 9.004 0 0 1 0 8.506" />
                 </svg>
            </x-menu-item>
        @endcan

        @can('view-states')
            <x-menu-item title="{{ __('States') }}" route="package.states">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3s-4.5 4.03-4.5 9 2.015 9 4.5 9Zm8.716-6.747a9.004 9.004 0 0 0 0-8.506M3.284 5.253a9.004 9.004 0 0 1 0 8.506" />
                 </svg>
            </x-menu-item>
        @endcan

        @can('view-cities')
            <x-menu-item title="{{ __('Cities') }}" route="package.cities">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                 </svg>
            </x-menu-item>
        @endcan

        {{-- manager package delivery options --}}
        @hasanyrole('manager')
            <x-menu-item title="{{ __('Pricing') }}" route="package.pricing">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                 </svg>
            </x-menu-item>

            <x-menu-item title="{{ __('Cities') }}" route="package.cities.my">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
            </x-menu-item>

            <x-menu-item title="{{ __('States') }}" route="package.states.my">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3s-4.5 4.03-4.5 9 2.015 9 4.5 9Zm8.716-6.747a9.004 9.004 0 0 0 0-8.506M3.284 5.253a9.004 9.004 0 0 1 0 8.506" />
                 </svg>
            </x-menu-item>

            <x-menu-item title="{{ __('Countries') }}" route="package.countries.my">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3s-4.5 4.03-4.5 9 2.015 9 4.5 9Zm8.716-6.747a9.004 9.004 0 0 0 0-8.506M3.284 5.253a9.004 9.004 0 0 1 0 8.506" />
                 </svg>
            </x-menu-item>
        @endhasanyrole

        @can('new-package-order')
            <x-menu-item title="{{ __('New Package Order') }}" route="package.order.new">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 16 4 L 11 8 L 21 8 Z M 8.5 5 L 5 9.65625 L 5 27 L 27 27 L 27 9.65625 L 23.5 5 L 18.5 5 L 21 7 L 22.5 7 L 24 9 L 8 9 L 9.5 7 L 11 7 L 13.5 5 Z M 7 11 L 25 11 L 25 25 L 7 25 Z M 12.8125 13 C 12.261719 13.050781 11.855469 13.542969 11.90625 14.09375 C 11.957031 14.644531 12.449219 15.050781 13 15 L 19 15 C 19.359375 15.003906 19.695313 14.816406 19.878906 14.503906 C 20.058594 14.191406 20.058594 13.808594 19.878906 13.496094 C 19.695313 13.183594 19.359375 12.996094 19 13 L 13 13 C 12.96875 13 12.9375 13 12.90625 13 C 12.875 13 12.84375 13 12.8125 13 Z"/></svg>
            </x-menu-item>
        @endcan

        @showNewParcelOrder
        <x-menu-item title="{{ __('New Package Order') }}" route="vendor.package.order.new">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 16 4 L 11 8 L 21 8 Z M 8.5 5 L 5 9.65625 L 5 27 L 27 27 L 27 9.65625 L 23.5 5 L 18.5 5 L 21 7 L 22.5 7 L 24 9 L 8 9 L 9.5 7 L 11 7 L 13.5 5 Z M 7 11 L 25 11 L 25 25 L 7 25 Z M 12.8125 13 C 12.261719 13.050781 11.855469 13.542969 11.90625 14.09375 C 11.957031 14.644531 12.449219 15.050781 13 15 L 19 15 C 19.359375 15.003906 19.695313 14.816406 19.878906 14.503906 C 20.058594 14.191406 20.058594 13.808594 19.878906 13.496094 C 19.695313 13.183594 19.359375 12.996094 19 13 L 13 13 C 12.96875 13 12.9375 13 12.90625 13 C 12.875 13 12.84375 13 12.8125 13 Z"/></svg>
        </x-menu-item>
        @endshowNewParcelOrder
    </x-group-menu-item>

    @endshowPackage

    {{-- Services --}}
    @showService
    <x-group-menu-item routePath="service/*" title="{{ __('Services/Booking') }}" icon="heroicon-o-rss">
        <x-menu-item title="{{ __('Services/Booking') }}" route="services">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5l-3.9 19.5m-2.1-19.5l-3.9 19.5" />
            </svg>
        </x-menu-item>
        {{-- SERVICE GROUPS --}}
        <x-menu-item title="{{ __('Service Groups') }}" route="services.option.groups">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 16 5.9375 L 15.625 6.0625 L 5.625 10.0625 L 3.3125 11 L 5.625 11.9375 L 9.53125 13.5 L 5.625 15.0625 L 3.3125 16 L 5.625 16.9375 L 9.53125 18.5 L 5.625 20.0625 L 3.3125 21 L 5.625 21.9375 L 15.625 25.9375 L 16 26.0625 L 16.375 25.9375 L 26.375 21.9375 L 28.6875 21 L 26.375 20.0625 L 22.46875 18.5 L 26.375 16.9375 L 28.6875 16 L 26.375 15.0625 L 22.46875 13.5 L 26.375 11.9375 L 28.6875 11 L 26.375 10.0625 L 16.375 6.0625 Z M 16 8.09375 L 23.28125 11 L 16 13.90625 L 8.71875 11 Z M 12.25 14.59375 L 15.625 15.9375 L 16 16.0625 L 16.375 15.9375 L 19.75 14.59375 L 23.28125 16 L 16 18.90625 L 8.71875 16 Z M 12.25 19.59375 L 15.625 20.9375 L 16 21.0625 L 16.375 20.9375 L 19.75 19.59375 L 23.28125 21 L 16 23.90625 L 8.71875 21 Z"/></svg>
        </x-menu-item>

        {{-- service options --}}
        <x-menu-item title="{{ __('Service Options') }}" route="services.options">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
            </svg>
        </x-menu-item>
    </x-group-menu-item>
    @endshowService

    {{-- taxi booking --}}
    @can('view-taxi')
        <x-group-menu-item routePath="taxi/*" title="{{ __('Taxi Booking') }}" icon="tabler-brand-uber">

            @can('view-taxi-vehicle-types')
                <x-menu-item title="{{ __('Vehicle Types') }}" route="taxi.vehicle.types">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-1.5-1.5V6.75a1.5 1.5 0 0 1 1.5-1.5h7.5a1.5 1.5 0 0 1 1.5 1.5v10.5a1.5 1.5 0 0 1-1.5 1.5h-7.5Z" />
                         <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" />
                     </svg>
                </x-menu-item>
            @endcan

            @can('view-taxi-vehicles')
                <x-menu-item title="{{ __('Vehicles') }}" route="taxi.vehicles">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-1.5-1.5V6.75a1.5 1.5 0 011.5-1.5h7.5a1.5 1.5 0 011.5 1.5v10.5a1.5 1.5 0 01-1.5 1.5h-7.5zM12 12a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" />
                    </svg>
                </x-menu-item>
            @endcan

            @can('view-car-makes')
                <x-menu-item title="{{ __('Car Makes') }}" route="taxi.car.makes">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </x-menu-item>
            @endcan

            @can('view-car-models')
                <x-menu-item title="{{ __('Car Models') }}" route="taxi.car.models">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                    </svg>
                </x-menu-item>
            @endcan

            {{-- Payment methods --}}
            @can('view-taxi-payment-methods')
                <x-menu-item title="{{ __('Payment Methods') }}" route="taxi.payment.methods">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                 </svg>
                </x-menu-item>
            @endcan

            {{-- Price --}}
            @can('view-taxi-pricing')
                <x-menu-item title="{{ __('Vehicle Multiple Pricing') }}" route="taxi.pricing">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                 </svg>
                </x-menu-item>
            @endcan

            {{-- Taxi settings --}}
            @can('view-taxi-settings')
                <x-menu-item title="{{ __('Settings') }}" route="taxi.settings">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
                </x-menu-item>
            @endcan

            {{-- Taxi settings --}}
            @can('view-taxi-zones')
                <x-menu-item title="{{ __('Zones') }}" route="taxi.zones">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                    </svg>
                </x-menu-item>
            @endcan


            {{-- New Order Taxi --}}
            @can('new-taxi-order')
                <x-menu-item title="{{ __('New Taxi Order') }}" route="taxi.order.new">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 13 4 L 12.34375 6 L 9.5 6 C 8.179688 6 7.003906 6.859375 6.625 8.125 L 5.25 12.71875 L 3.3125 12.0625 L 2.6875 13.9375 L 4.65625 14.59375 L 4.03125 16.71875 C 4.007813 16.808594 3.996094 16.90625 4 17 L 4 24 C 4 24.03125 4 24.0625 4 24.09375 L 4 25 C 4 25.550781 4.449219 26 5 26 L 8 26 L 8.34375 25 L 23.65625 25 L 24 26 L 27 26 C 27.550781 26 28 25.550781 28 25 L 28 24.15625 C 28.003906 24.105469 28.003906 24.050781 28 24 L 28 17 C 28.003906 16.90625 27.992188 16.808594 27.96875 16.71875 L 27.34375 14.59375 L 29.3125 13.9375 L 28.6875 12.0625 L 26.75 12.71875 L 25.375 8.125 C 24.996094 6.859375 23.820313 6 22.5 6 L 19.65625 6 L 19 4 Z M 9.5 8 L 22.5 8 C 22.945313 8 23.339844 8.292969 23.46875 8.71875 L 24.75 13 L 7.25 13 L 8.53125 8.71875 C 8.660156 8.289063 9.054688 8 9.5 8 Z M 6.65625 15 L 25.34375 15 L 26 17.1875 L 26 23 L 6 23 L 6 17.1875 Z M 8.5 16 C 7.671875 16 7 16.671875 7 17.5 C 7 18.328125 7.671875 19 8.5 19 C 9.328125 19 10 18.328125 10 17.5 C 10 16.671875 9.328125 16 8.5 16 Z M 23.5 16 C 22.671875 16 22 16.671875 22 17.5 C 22 18.328125 22.671875 19 23.5 19 C 24.328125 19 25 18.328125 25 17.5 C 25 16.671875 24.328125 16 23.5 16 Z M 12 19 L 10.75 22 L 12.90625 22 L 13.34375 21 L 18.65625 21 L 19.09375 22 L 21.25 22 L 20 19 Z"/></svg>
                </x-menu-item>
            @endcan

        </x-group-menu-item>
    @endcan

    @can('view-fleets')
        <x-group-menu-item routePath="fleet/*" title="{{ __('Fleet Managment') }}" icon="heroicon-o-briefcase">
            @can('manager-fleets')
                <x-menu-item title="{{ __('Fleets') }}" route="fleets">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                 </svg>
                </x-menu-item>
            @endcan

            @hasanyrole('fleet-manager')
                <x-menu-item title="{{ __('Users') }}" route="fleet.users">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                 </svg>
                </x-menu-item>

                <x-menu-item title="{{ __('Vehicles') }}" route="fleet.vehicles">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-1.5-1.5V6.75a1.5 1.5 0 0 1 1.5-1.5h7.5a1.5 1.5 0 0 1 1.5 1.5v10.5a1.5 1.5 0 0 1-1.5 1.5h-7.5Z" />
                         <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" />
                     </svg>
                </x-menu-item>

                <x-menu-item title="{{ __('Fleet report') }}" route="fleet.report">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                     <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                 </svg>
                </x-menu-item>
            @endhasanyrole

        </x-group-menu-item>
    @endcan
    <x-hr />


    {{-- user management --}}
    @can(['view-users', 'view-deleted-users'])
        <x-group-menu-item routePath="user*" title="{{ __('User Mangt.') }}" icon="heroicon-o-user-group">
            {{-- Users --}}
            @can('view-users')
                <x-menu-item title="{{ __('Users') }}" route="users">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
                </x-menu-item>
            @endcan

            {{-- Deleted Users --}}
            @can('view-deleted-users')
                <x-menu-item title="{{ __('Deleted Users') }}" route="users.deleted">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 14 4 C 10.1 4 7 7.1 7 11 C 7 13.4 8.1996094 15.600781 10.099609 16.800781 C 6.4996094 18.300781 4 21.9 4 26 L 6 26 C 6 21.6 9.6 18 14 18 C 15.4 18 16.700781 18.4 17.800781 19 C 16.700781 20.4 16 22.1 16 24 C 16 28.4 19.6 32 24 32 C 28.4 32 32 28.4 32 24 C 32 19.6 28.4 16 24 16 C 22.3 16 20.600781 16.6 19.300781 17.5 C 18.900781 17.2 18.400391 17.000781 17.900391 16.800781 C 19.800391 15.500781 21 13.4 21 11 C 21 7.1 17.9 4 14 4 z M 14 6 C 16.8 6 19 8.2 19 11 C 19 13.8 16.8 16 14 16 C 11.2 16 9 13.8 9 11 C 9 8.2 11.2 6 14 6 z M 24 18 C 27.3 18 30 20.7 30 24 C 30 27.3 27.3 30 24 30 C 20.7 30 18 27.3 18 24 C 18 20.7 20.7 18 24 18 z M 20 23 L 20 25 L 28 25 L 28 23 L 20 23 z"/></svg>
                </x-menu-item>
            @endcan

        </x-group-menu-item>
    @endcan

    {{-- driver management --}}
    @can(['view-drivers', 'view-driver-incentives'])
        <x-group-menu-item routePath="driver*" title="{{ __('Driver Mangt.') }}" icon="lineawesome-users-cog-solid">
            {{-- Drivers --}}
            @can('view-drivers')
                <x-menu-item title="{{ __('Drivers') }}" route="drivers">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 19.5 5 C 17.578125 5 16 6.578125 16 8.5 C 16 10.421875 17.578125 12 19.5 12 C 21.421875 12 23 10.421875 23 8.5 C 23 6.578125 21.421875 5 19.5 5 Z M 19.5 7 C 20.339844 7 21 7.660156 21 8.5 C 21 9.339844 20.339844 10 19.5 10 C 18.660156 10 18 9.339844 18 8.5 C 18 7.660156 18.660156 7 19.5 7 Z M 15.09375 10.53125 C 14.585938 10.582031 14.09375 10.832031 13.75 11.25 L 11.40625 14.09375 C 10.597656 15.078125 10.949219 16.632813 12.09375 17.1875 L 15.53125 18.875 L 14.625 23.875 L 16.59375 24.21875 L 17.65625 18.46875 L 17.78125 17.71875 L 17.09375 17.375 L 12.9375 15.375 L 15.3125 12.5 L 19.375 15.78125 L 19.65625 16 L 25 16 L 25 14 L 20.34375 14 L 16.5625 10.96875 C 16.140625 10.628906 15.601563 10.480469 15.09375 10.53125 Z M 8.5 18 C 6.03125 18 4 20.03125 4 22.5 C 4 24.96875 6.03125 27 8.5 27 C 10.96875 27 13 24.96875 13 22.5 C 13 20.03125 10.96875 18 8.5 18 Z M 23.5 18 C 21.03125 18 19 20.03125 19 22.5 C 19 24.96875 21.03125 27 23.5 27 C 25.96875 27 28 24.96875 28 22.5 C 28 20.03125 25.96875 18 23.5 18 Z M 8.5 20 C 9.878906 20 11 21.121094 11 22.5 C 11 23.878906 9.878906 25 8.5 25 C 7.121094 25 6 23.878906 6 22.5 C 6 21.121094 7.121094 20 8.5 20 Z M 23.5 20 C 24.878906 20 26 21.121094 26 22.5 C 26 23.878906 24.878906 25 23.5 25 C 22.121094 25 21 23.878906 21 22.5 C 21 21.121094 22.121094 20 23.5 20 Z"/></svg>
                </x-menu-item>
            @endcan
            @can('track-drivers-location')
                @if (isUsingWebsocket())
                    <x-menu-item title="{{ __('Drivers Locations') }}" route="drivers.locations">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </x-menu-item>
                @endif
            @endcan
            {{-- drivers documents --}}
            @can('view-driver-documents')
                <x-menu-item title="{{ __('Document Requests') }}" route="drivers.documents">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 6 3 L 6 29 L 26 29 L 26 9.59375 L 25.71875 9.28125 L 19.71875 3.28125 L 19.40625 3 Z M 8 5 L 18 5 L 18 11 L 24 11 L 24 27 L 8 27 Z M 20 6.4375 L 22.5625 9 L 20 9 Z M 11 13 L 11 15 L 21 15 L 21 13 Z M 11 17 L 11 19 L 21 19 L 21 17 Z M 11 21 L 11 23 L 21 23 L 21 21 Z"/></svg>
                </x-menu-item>
            @endcan

            {{-- driver incentives --}}
            {{-- TODO: Driver incentives --}}
            {{-- @can('view-driver-incentives')
                <x-menu-item title="{{ __('Incentives') }}" route="driver.incentives">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 5 5 L 5 27 L 27 27 L 27 5 Z M 7 7 L 25 7 L 25 25 L 7 25 Z M 12 9 C 10.355469 9 9 10.355469 9 12 L 9 13 C 9 14.644531 10.355469 16 12 16 C 13.644531 16 15 14.644531 15 13 L 15 12 C 15 10.355469 13.644531 9 12 9 Z M 19.59375 9 L 10 23 L 12.40625 23 L 22 9 Z M 12 11 C 12.566406 11 13 11.433594 13 12 L 13 13 C 13 13.566406 12.566406 14 12 14 C 11.433594 14 11 13.566406 11 13 L 11 12 C 11 11.433594 11.433594 11 12 11 Z M 20 16 C 18.355469 16 17 17.355469 17 19 L 17 20 C 17 21.644531 18.355469 23 20 23 C 21.644531 23 23 21.644531 23 20 L 23 19 C 23 17.355469 21.644531 16 20 16 Z M 20 18 C 20.566406 18 21 18.433594 21 19 L 21 20 C 21 20.566406 20.566406 21 20 21 C 19.433594 21 19 20.566406 19 20 L 19 19 C 19 18.433594 19.433594 18 20 18 Z"/></svg>
                </x-menu-item>
            @endcan --}}

        </x-group-menu-item>
    @endcan

    {{-- orders --}}
    @canany(['view-orders', 'view-refund', 'view-reviews', 'view-delivery-addresses', 'view-coupons'])
        <x-hr />
        <x-group-menu-item routePath="order/*" title="{{ __('Orders') }}" icon="heroicon-o-shopping-bag">

            @can('view-orders')
                <x-menu-item title="{{ __('Orders') }}" route="orders">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                     </svg>
                </x-menu-item>
            @endcan
            @showTaxiOrders
            <x-menu-item title="{{ __('Taxi Orders') }}" route="orders.taxi">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 9.5 6 C 8.179688 6 7.003906 6.859375 6.625 8.125 L 5.25 12.71875 L 3.3125 12.0625 L 2.6875 13.9375 L 4.65625 14.59375 L 4.03125 16.71875 C 4.007813 16.808594 3.996094 16.90625 4 17 L 4 24 C 4 24.03125 4 24.0625 4 24.09375 L 4 25 C 4 25.550781 4.449219 26 5 26 L 8 26 L 8.34375 25 L 23.65625 25 L 24 26 L 27 26 C 27.550781 26 28 25.550781 28 25 L 28 24.15625 C 28.003906 24.105469 28.003906 24.050781 28 24 L 28 17 C 28.003906 16.90625 27.992188 16.808594 27.96875 16.71875 L 27.34375 14.59375 L 29.3125 13.9375 L 28.6875 12.0625 L 26.75 12.71875 L 25.375 8.125 C 24.996094 6.859375 23.820313 6 22.5 6 Z M 9.5 8 L 22.5 8 C 22.945313 8 23.339844 8.292969 23.46875 8.71875 L 24.75 13 L 7.25 13 L 8.53125 8.71875 C 8.660156 8.289063 9.054688 8 9.5 8 Z M 11 13 C 12.105469 13 13 12.105469 13 11 C 13 9.894531 12.105469 9 11 9 C 9.894531 9 9 9.894531 9 11 C 9 12.105469 9.894531 13 11 13 Z M 21 13 C 22.105469 13 23 12.105469 23 11 C 23 9.894531 22.105469 9 21 9 C 19.894531 9 19 9.894531 19 11 C 19 12.105469 19.894531 13 21 13 Z M 16 9 C 15.171875 9 14.5 9.671875 14.5 10.5 C 14.5 11.328125 15.171875 12 16 12 C 16.828125 12 17.5 11.328125 17.5 10.5 C 17.5 9.671875 16.828125 9 16 9 Z M 6.65625 15 L 25.34375 15 L 26 17.1875 L 26 23 L 6 23 L 6 17.1875 Z M 8.5 16 C 7.671875 16 7 16.671875 7 17.5 C 7 18.328125 7.671875 19 8.5 19 C 9.328125 19 10 18.328125 10 17.5 C 10 16.671875 9.328125 16 8.5 16 Z M 23.5 16 C 22.671875 16 22 16.671875 22 17.5 C 22 18.328125 22.671875 19 23.5 19 C 24.328125 19 25 18.328125 25 17.5 C 25 16.671875 24.328125 16 23.5 16 Z M 12 19 L 10.75 22 L 12.90625 22 L 13.34375 21 L 18.65625 21 L 19.09375 22 L 21.25 22 L 20 19 Z"/></svg>
            </x-menu-item>
            @endshowTaxiOrders
            @can('view-refund')
                <x-menu-item title="{{ __('Refunds') }}" route="refunds">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c-1.03 0-1.9.693-2.166 1.638m-7.332 0A2.25 2.25 0 0 1 10.5 2.25h3c1.03 0 1.9.693 2.166 1.638M8.25 5.25a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-7.5Z" />
                 </svg>
                </x-menu-item>
            @endcan

            @can('view-reviews')
                <x-menu-item title="{{ __('Reviews') }}" route="reviews">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 1.89-1.155.356-.71.356-1.6 0-2.31a2.124 2.124 0 0 0-1.89-1.155H6.633a2.124 2.124 0 0 0-1.89 1.155c-.356.71-.356 1.6 0 2.31a2.124 2.124 0 0 0 1.89 1.155Zm6.734 0c.806 0 1.533-.446 1.89-1.155.356-.71.356-1.6 0-2.31a2.124 2.124 0 0 0-1.89-1.155h-1.533a2.124 2.124 0 0 0-1.89 1.155c-.356.71-.356 1.6 0 2.31a2.124 2.124 0 0 0 1.89 1.155Zm6.734 0c.806 0 1.533-.446 1.89-1.155.356-.71.356-1.6 0-2.31a2.124 2.124 0 0 0-1.89-1.155h-1.533a2.124 2.124 0 0 0-1.89 1.155c-.356.71-.356 1.6 0 2.31a2.124 2.124 0 0 0 1.89 1.155Z" />
                 </svg>
                </x-menu-item>
                <x-menu-item title="{{ __('Product Reviews') }}" route="products.reviews">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 1.89-1.155.356-.71.356-1.6 0-2.31a2.124 2.124 0 0 0-1.89-1.155H6.633a2.124 2.124 0 0 0-1.89 1.155c-.356.71-.356 1.6 0 2.31a2.124 2.124 0 0 0 1.89 1.155Zm6.734 0c.806 0 1.533-.446 1.89-1.155.356-.71.356-1.6 0-2.31a2.124 2.124 0 0 0-1.89-1.155h-1.533a2.124 2.124 0 0 0-1.89 1.155c-.356.71-.356 1.6 0 2.31a2.124 2.124 0 0 0 1.89 1.155Zm6.734 0c.806 0 1.533-.446 1.89-1.155.356-.71.356-1.6 0-2.31a2.124 2.124 0 0 0-1.89-1.155h-1.533a2.124 2.124 0 0 0-1.89 1.155c-.356.71-.356 1.6 0 2.31a2.124 2.124 0 0 0 1.89 1.155Z" />
                 </svg>
                </x-menu-item>
            @endcan
            @can('view-delivery-addresses')
                <x-menu-item title="{{ __('Delivery Address') }}" route="delivery.addresses">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                     <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                 </svg>
                </x-menu-item>
            @endcan
            @can('view-coupons')
                <x-menu-item title="{{ __('Coupons') }}" route="coupons">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                 </svg>
                </x-menu-item>
            @endcan

        </x-group-menu-item>
    @endcan

    {{-- dispatch order on maps --}}
    {{-- order timeline --}}



    @can('view-payment-section')


        {{-- Payments --}}
        <x-group-menu-item routePath="payments/*" title="{{ __('Payments') }}" icon="heroicon-o-cash">
            @can('view-wallet-transactions')
                {{-- wallet transactions --}}
                <x-menu-item title="{{ __('Wallet Transactions') }}" route="wallet.transactions">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z" />
            </svg>
                </x-menu-item>
            @endcan

            @can('view-payment-accounts')
                <x-menu-item title="{{ __('Payment Accounts') }}" route="payment.accounts">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18a3 3 0 0 1-6 0v-2.25m6 0V9a3 3 0 0 0-6 0v6.75m6 0H9m6 0H9m0 0V9a3 3 0 0 1 6 0v6.75M9 15.75h6" />
                 </svg>
                </x-menu-item>
            @endcan
            @can('view-outstanding-payments')
                <x-menu-item title="{{ __('Outstanding Payments') }}" route="payment.outstanding">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                 </svg>
                </x-menu-item>
            @endcan

            @hasanyrole('manager')
                <x-menu-item title="{{ __('My Payouts') }}" route="my.payouts">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9z" />
            </svg>
                </x-menu-item>
            @endhasanyrole

        </x-group-menu-item>
        <x-hr />
    @endcan

    {{-- Earings --}}
    @can('view-earning')
        <x-group-menu-item routePath="earnings/*" title="{{ __('Earnings') }}" icon="heroicon-o-cash">
            @can('view-vendor-earning')
                <x-menu-item title="{{ __('Current Vendor Earnings') }}" route="earnings.vendors">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                     </svg>
                </x-menu-item>
            @endcan
            @can('my-earning')
                <x-menu-item title="{{ __('My Earning ') }}" route="my.earnings">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                     </svg>
                </x-menu-item>
            @endcan

            @handleDeliveryBoys
                <x-menu-item title="{{ __('Current Driver Earnings') }}" route="earnings.drivers">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-1.5-1.5V6.75a1.5 1.5 0 0 1 1.5-1.5h7.5a1.5 1.5 0 0 1 1.5 1.5v10.5a1.5 1.5 0 0 1-1.5 1.5h-7.5Z" />
                         <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" />
                     </svg>
                </x-menu-item>

                <x-menu-item title="{{ __('Driver Remittance') }}" route="earnings.remittance">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18a3 3 0 0 1-6 0v-2.25m6 0V9a3 3 0 0 0-6 0v6.75m6 0H9m6 0H9m0 0V9a3 3 0 0 1 6 0v6.75M9 15.75h6" />
                 </svg>
                </x-menu-item>
            @endhandleDeliveryBoys


            @can('vendor-earning-history')
                <x-menu-item title="{{ __('Vendors Earning History') }}" route="vendor.earnings.history">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                     </svg>
                </x-menu-item>
            @endcan

            @can('driver-earning-history')
                <x-menu-item title="{{ __('Driver Earnings History') }}" route="driver.earnings.history">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                     </svg>
                </x-menu-item>
            @endcan

        </x-group-menu-item>
    @endcan

    {{-- Payouts --}}
    @can('view-payout')
        <x-group-menu-item routePath="payouts*" title="{{ __('Payouts') }}" icon="heroicon-o-clipboard-check">
            @hasanyrole('city-admin|admin')
                <x-menu-item title="{{ __('Vendor Payouts') }}" route="payouts"
                    rawRoute="{{ route('payouts', ['type' => 'vendors']) }}">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                     </svg>
                </x-menu-item>
            @endhasanyrole
            <x-menu-item title="{{ __('Driver Payouts') }}" route="payouts"
                rawRoute="{{ route('payouts', ['type' => 'drivers']) }}">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-1.5-1.5V6.75a1.5 1.5 0 0 1 1.5-1.5h7.5a1.5 1.5 0 0 1 1.5 1.5v10.5a1.5 1.5 0 0 1-1.5 1.5h-7.5Z" />
                         <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" />
                     </svg>
            </x-menu-item>

        </x-group-menu-item>
    @endcan

    @can('view-subscription')
        <x-group-menu-item routePath="subscription*" title="{{ __('Subscription') }}" icon="heroicon-o-shield-check">
            {{-- subscription list --}}
            @hasanyrole('admin')
                <x-menu-item title="{{ __('Subscriptions') }}" route="subscriptions">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                 </svg>
                </x-menu-item>
            @endhasanyrole
            {{-- vendors and current subscriptions --}}
            @hasanyrole('city-admin|admin')
                <x-menu-item title="{{ __('Vendor Subscriptions') }}" route="vendors.subscriptions">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                 </svg>
                </x-menu-item>
            @endhasanyrole
            {{-- vendor subscription history --}}
            @hasanyrole('manager')
                <x-menu-item title="{{ __('My Subscriptions') }}" route="my.subscriptions">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                 </svg>
                </x-menu-item>
            @endhasanyrole

        </x-group-menu-item>
    @endcan

    {{-- Payment methods --}}
    @hasanyrole('manager')
        @can('allow-select-payment-gateway')
            <x-menu-item title="{{ __('Payment Methods') }}" route="payment.methods.my">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
            </x-menu-item>
        @endcan
    @endhasanyrole


    @can('view-operations')
        <x-hr />
        <x-group-menu-item routePath="operations/*" title="{{ __('Operations') }}" icon="heroicon-o-server">

            {{-- notifications --}}
            <x-menu-item title="{{ __('Notifications') }}" route="notification.send">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75v-.7V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
             </svg>
            </x-menu-item>

            {{-- backups --}}
            <x-menu-item title="{{ __('Backup') }}" route="backups">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
             </svg>
            </x-menu-item>

            {{-- import --}}
            <x-menu-item title="{{ __('Import') }}" route="imports">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
             </svg>
            </x-menu-item>

            {{-- Export --}}
            <x-menu-item title="{{ __('Export') }}" route="exports">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
             </svg>
            </x-menu-item>

            {{-- logs --}}
            <x-menu-item title="{{ __('Logs') }}" route="logs" ex="true">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
             </svg>
            </x-menu-item>

            {{-- data reset --}}
            <x-menu-item title="{{ __('Clear Data') }}" route="data.clear">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75 14.25 12m0 0 2.25 2.25M14.25 12l2.25-2.25M14.25 12 12 14.25m-2.58 4.92-6.374-6.375a48.256 48.256 0 0 1 0-8.745c.394-.077.796-.132 1.204-.132h.75c.352 0 .688.052 1.006.15l4.5-4.5a1.5 1.5 0 0 1 2.121 0l4.5 4.5a1.5 1.5 0 0 1 0 2.121L15.75 18l-4.5 4.5a1.5 1.5 0 0 1-2.121 0l-4.5-4.5a1.5 1.5 0 0 1 0-2.121l6.375-6.375" />
             </svg>
            </x-menu-item>

            {{-- cron job --}}
            <x-menu-item title="{{ __('CRON JOB') }}" route="configure.cron.job">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5" />
             </svg>
            </x-menu-item>
            {{-- cron job --}}
            <x-menu-item title="{{ __('Auto-Assignments') }}" route="auto.assignments">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                 </svg>
            </x-menu-item>

            {{-- troubleshoot --}}
            <x-menu-item title="{{ __('Troubleshoot') }}" route="troubleshooting">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a6.048 6.048 0 0 1-1.5 0m1.5-2.383a6.048 6.048 0 0 0 1.5 0m-1.5 2.383a12.06 12.06 0 0 0 4.5 0M9.75 12.75c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75 3 3 0 0 0-3-3h-3a.75.75 0 0 0-.75.75Z" />
             </svg>
            </x-menu-item>

            {{-- jobs monitore --}}
            @production
                @role('admin')
                    <x-menu-item title="{{ __('Jobs Monitor') }}" route="queue.jobs.handler">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                    </x-menu-item>
                @endrole
            @endproduction

        </x-group-menu-item>
    @endcan


    {{-- Settings --}}
    @can('view-settings')
        <x-group-menu-item routePath="setting/*" title="{{ __('Settings') }}" icon="heroicon-o-cog">

            {{-- Settings --}}
            <x-menu-item title="{{ __('General Settings') }}" route="settings">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            </x-menu-item>

            {{-- App Settings --}}
            <x-menu-item title="{{ __('Mobile App Settings') }}" route="settings.app">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
             </svg>
            </x-menu-item>

            {{-- websocket settings --}}
            <x-menu-item title="{{ __('Websocket Settings') }}" route="settings.websocket">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M9 7.5h6m-6 3h6m-6 3h6m-6 3h6M3 9.75V18a2.25 2.25 0 0 0 2.25 2.25h13.5A2.25 2.25 0 0 0 21 18V9.75M3 6a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 6v3.75M3 9.75V6a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 6v3.75" />
             </svg>
            </x-menu-item>

            <x-hr />

            {{-- Currencies --}}
            <x-menu-item title="{{ __('Currencies') }}" route="currencies">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                 </svg>
            </x-menu-item>

            {{-- Payment methods --}}
            <x-menu-item title="{{ __('Payment Methods') }}" route="payment.methods">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
            </x-menu-item>
            <x-menu-item title="{{ __('Wallet Payment Methods') }}" route="wallet.payment.methods">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
            </x-menu-item>


            {{-- Settings --}}
            <x-menu-item title="{{ __('SMS Gateways') }}" route="sms.settings">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z" />
             </svg>
            </x-menu-item>

            <x-hr />


            {{-- Page Settings --}}
            <x-menu-item title="{{ __('Page Settings') }}" route="settings.page">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
             </svg>
            </x-menu-item>

            {{-- CMS Pages --}}
            <x-menu-item title="{{ __('CMS Pages') }}" route="settings.page.cms">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
             </svg>
            </x-menu-item>

            <x-hr />

            {{-- Map Settings --}}
            <x-menu-item title="{{ __('Map Settings') }}" route="settings.map">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3s-4.5 4.03-4.5 9 2.015 9 4.5 9Zm8.716-6.747a9.004 9.004 0 0 0 0-8.506M3.284 5.253a9.004 9.004 0 0 1 0 8.506" />
                 </svg>
            </x-menu-item>

            <x-menu-item title="{{ __('UI Settings') }}" route="settings.ui">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
             </svg>
            </x-menu-item>

            {{-- Finance Settings --}}
            <x-menu-item title="{{ __('Finance Settings') }}" route="settings.finance">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
            </x-menu-item>

            {{--  payment webhooks  --}}
            <x-menu-item title="{{ __('Payment Webhooks') }}" route="settings.webhooks">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5l-3.9 19.5m-2.1-19.5l-3.9 19.5" />
             </svg>
            </x-menu-item>

            {{-- dynamic link --}}
            <x-menu-item title="{{ __('Dynamic Link Settings') }}" route="settings.dynamic.link">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
             </svg>
            </x-menu-item>

            @can('view-in-app-support')
                <x-menu-item title="{{ __('In-App Support') }}" route="inapp.support">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.471 4.471 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                     </svg>
                </x-menu-item>
            @endcan

            <x-menu-item title="{{ __('App Upgrade') }}" route="settings.app.upgrade">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.307a11.95 11.95 0 0 1 5.814-5.519l2.74-1.22m0 0-5.94-2.28m5.94 2.28-2.28 5.941" />
             </svg>
            </x-menu-item>

            {{-- Web Settings --}}
            <x-menu-item title="{{ __('Website Settings') }}" route="settings.website">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3s-4.5 4.03-4.5 9 2.015 9 4.5 9Zm8.716-6.747a9.004 9.004 0 0 0 0-8.506M3.284 5.253a9.004 9.004 0 0 1 0 8.506" />
                 </svg>
            </x-menu-item>

            {{-- Mail Settings --}}
            <x-menu-item title="{{ __('Mail Settings') }}" route="settings.server">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 17.25v-.228a4.5 4.5 0 0 0-.12-1.03l-2.268-9.64a3.375 3.375 0 0 0-3.285-2.602H7.923a3.375 3.375 0 0 0-3.285 2.602l-2.268 9.64a4.5 4.5 0 0 0-.12 1.03v.228m19.5 0a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3m19.5 0a3 3 0 0 0-3-3H5.25a3 3 0 0 0-3 3m16.5 0h.008v.008h-.008v-.008Zm-3 0h.008v.008h-.008v-.008Z" />
             </svg>
            </x-menu-item>

            @hasanyrole('admin')
                <x-menu-item title="{{ __('Roles') }}" route="settings.roles">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M7.864 4.243A7.5 7.5 0 0 1 19.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 0 0 4.5 10.5a7.464 7.464 0 0 1-1.15 3.993m1.989 3.559A11.209 11.209 0 0 0 8.25 10.5a3.75 3.75 0 1 1 7.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 0 1-3.6 9.75m6.633-4.596a18.666 18.666 0 0 1-2.485 5.33" />
                 </svg>
                </x-menu-item>
                @production
                    <x-menu-item title="{{ __('Enviroment Config') }}" rawRoute="{{ url('env/editor') }}" ex="true">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
                    </x-menu-item>
                @endproduction
            @endhasanyrole

            {{-- upgrade --}}
            <x-menu-item title="{{ __('Upgrade') }}" route="upgrade">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
             </svg>
            </x-menu-item>
        </x-group-menu-item>
    @endcan

    {{--  misc  --}}
    <x-group-menu-item routePath="misc/*" title="{{ __('Misc.') }}" icon="heroicon-o-beaker">
        @can('mang-onboarding')
            <x-menu-item title="{{ __('Onboarding') }}" route="onboarding">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            </x-menu-item>
        @endcan
         @can('view-faq')
             <x-menu-item title="{{ __('FAQs') }}" route="faqs">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                 </svg>
             </x-menu-item>
         @endcan
    </x-group-menu-item>

    {{-- extensions --}}
    @hasanyrole('admin|city-admin')
         <x-menu-item title="{{ __('Extensions') }}" route="extensions">
             <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
             </svg>
         </x-menu-item>
    @endhasanyrole


    <x-hr />
    {{-- reports --}}
    @can('view-report')
        <x-group-menu-item routePath="reports/*" title="{{ __('Reports') }}" icon="heroicon-o-chart-square-bar">

            @can('view-loyalty')
                <x-menu-item title="{{ __('Loyalty Report') }}" route="reports.loyalty">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" class="w-5 h-5"><path d="M 7.1875 4.1875 C 2.890625 8.371094 2.90625 15.3125 7.1875 19.59375 L 8.59375 18.1875 C 5.074219 14.667969 5.089844 9.039063 8.59375 5.625 Z M 24.8125 4.28125 L 23.40625 5.71875 C 26.929688 9.242188 26.929688 14.757813 23.40625 18.28125 L 24.8125 19.71875 C 29.085938 15.445313 29.085938 8.554688 24.8125 4.28125 Z M 9.90625 7.1875 C 7.320313 9.773438 7.320313 14.007813 9.90625 16.59375 L 11.3125 15.1875 C 9.5 13.375 9.5 10.40625 11.3125 8.59375 Z M 22.09375 7.28125 L 20.6875 8.71875 C 22.5 10.53125 22.5 13.46875 20.6875 15.28125 L 22.09375 16.71875 C 24.679688 14.132813 24.679688 9.867188 22.09375 7.28125 Z M 16 10 C 14.894531 10 14 10.894531 14 12 C 14 12.625 14.300781 13.164063 14.75 13.53125 L 10.3125 26 L 9 26 L 9 28 L 13 28 L 13 26 L 12.40625 26 L 16 15.96875 L 19.59375 26 L 19 26 L 19 28 L 23 28 L 23 26 L 21.6875 26 L 17.25 13.53125 C 17.699219 13.164063 18 12.625 18 12 C 18 10.894531 17.105469 10 16 10 Z"/></svg>
                </x-menu-item>
            @endcan

            @can('view-coupon-report')
                <x-menu-item title="{{ __('Coupon Report') }}" route="reports.coupons">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                     <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                 </svg>
                </x-menu-item>
            @endcan
            @can('view-referral-report')
                <x-menu-item title="{{ __('Referral Report') }}" route="reports.referral">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                 </svg>
                </x-menu-item>
            @endcan
            @can('view-commission-report')
                <x-menu-item title="{{ __('Commission Report') }}" route="reports.commission">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                 </svg>
                </x-menu-item>
            @endcan
            {{-- products --}}
            @showProduct
            <x-menu-item title="{{ __('Products') }}" route="reports.products">
                 <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                 </svg>
            </x-menu-item>
            @endshowProduct
            {{-- services --}}
            @showService
            <x-menu-item title="{{ __('Services') }}" route="reports.services">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5l-3.9 19.5m-2.1-19.5l-3.9 19.5" />
             </svg>
            </x-menu-item>
            @endshowService
            @can('view-vendor-report')
                <x-menu-item title="{{ __('Vendors') }}" route="reports.vendors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
                </x-menu-item>
            @endcan
            @can('view-customers-report')
                <x-menu-item title="{{ __('Customers') }}" route="reports.customers">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                 </svg>
                </x-menu-item>
            @endcan
            @can('view-subscriptions-report')
                <x-menu-item title="{{ __('Subscriptions') }}" route="reports.subscriptions">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                 </svg>
                </x-menu-item>
            @endcan

            @can('view-summary-report')
                <x-menu-item title="{{ __('Summary') }}" route="reports.summary">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                 <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
             </svg>
                </x-menu-item>
            @endcan
        </x-group-menu-item>
    @endcan


    <livewire:component.dynamic-nav-menu />


</ul>
