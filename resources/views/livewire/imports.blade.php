@section('title', __('Data Import'))
    <div>

        <x-baseview title="{{ __('Data Import') }}">

            <div class="grid grid-cols-1 gap-6 mt-10 md:grid-cols-2 lg:grid-cols-3">

                <div>
                    <x-settings-item title="{{ __('Categories') }}" wireClick="showImportDialog(1, 'Categories')">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                        </svg>
                    </x-settings-item>
                    <a href="{{ asset('xlxs/categories.xlsx') }}" download class="text-sm text-gray-500 underline">{{ __('Download sample') }}</a>
                </div>
                <div>
                    <x-settings-item title="{{ __('Subcategories') }}" wireClick="showImportDialog(5, 'Subcategories')">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                        </svg>
                    </x-settings-item>
                    <a href="{{ asset('xlxs/subcategories.xlsx') }}" download class="text-sm text-gray-500 underline">{{ __('Download sample') }}</a>
                </div>

                <div>
                    <x-settings-item title="{{ __('Vendors') }}" wireClick="showImportDialog(2, 'Vendors')">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                        </svg>
                    </x-settings-item>
                    <a href="{{ asset('xlxs/vendors.xlsx') }}" download class="text-sm text-gray-500 underline">{{ __('Download sample') }}</a>
                </div>
                <div>
                    <x-settings-item title="{{ __('Menus') }}" wireClick="showImportDialog(3, 'Menus')">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </x-settings-item>
                    <a href="{{ asset('xlxs/menus.xlsx') }}" download class="text-sm text-gray-500 underline">{{ __('Download sample') }}</a>
                </div>
                <div>
                    <x-settings-item title="{{ __('Products') }}" wireClick="showImportDialog(4, 'Products')">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h1.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V16a2 2 0 01-2 2H5a2 2 0 01-2-2V8zM5 8v10a2 2 0 002 2h8a2 2 0 002-2V8m-6 4h2m-2-4h2"></path>
                        </svg>
                    </x-settings-item>
                    <a href="{{ asset('xlxs/products.xlsx') }}" download class="text-sm text-gray-500 underline">{{ __('Download sample') }}</a>
                </div>

                <div>
                    <x-settings-item title="{{ __('Services') }}" wireClick="showImportDialog(6, 'Services')">
                        <svg class="w-5 h-5 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h1.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V16a2 2 0 01-2 2H5a2 2 0 01-2-2V8zM5 8v10a2 2 0 002 2h8a2 2 0 002-2V8m-6 4h2m-2-4h2"></path>
                        </svg>
                    </x-settings-item>
                    {{-- TODO: Service demo file --}}
                    <a href="{{ asset('xlxs/services.xlsx') }}" download class="text-sm text-gray-500 underline">{{ __('Download sample') }}</a>
                </div>

            </div>

        </x-baseview>

        {{-- import dialog --}}
        <div x-data="{ open: @entangle('showCreate') }">
            <x-modal confirmText="Import" action="processImport">
                <p class="text-xl font-semibold">Import {{ $dataTypeName ?? '' }}</p>
                <x-media-upload title="Data File" name="photo" :photo="$photo" :photoInfo="$photoInfo" :image="false"
                    types="xlsx" rules="xls" />
            </x-modal>
        </div>

    </div>
