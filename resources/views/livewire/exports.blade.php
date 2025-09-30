@section('title', __('Data Export'))
    <div>

        <x-baseview title="{{ __('Data Export') }}">

            <div class="grid grid-cols-1 gap-6 mt-10 md:grid-cols-2 lg:grid-cols-3">

                <div>
                    <x-settings-item title="{{ __('Categories') }}" wireClick="exportData(1, 'Categories')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-5 h-5 mr-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
</svg>
                    </x-settings-item>
                </div>
                <div>
                    <x-settings-item title="{{ __('Subcategories') }}" wireClick="exportData(2, 'Subcategories')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-5 h-5 mr-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
</svg>
                    </x-settings-item>
                </div>

                <div>
                    <x-settings-item title="{{ __('Vendors') }}" wireClick="exportData(3, 'Vendors')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-5 h-5 mr-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
</svg>
                    </x-settings-item>
                </div>
                <div>
                    <x-settings-item title="{{ __('Menus') }}" wireClick="exportData(4, 'Menus')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-5 h-5 mr-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
</svg>
                    </x-settings-item>
                </div>
                <div>
                    <x-settings-item title="{{ __('Products') }}" wireClick="exportData(5, 'Products')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-5 h-5 mr-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
</svg>
                    </x-settings-item>
                </div>
                <div>
                    <x-settings-item title="{{ __('Services') }}" wireClick="exportData(6, 'Services')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-5 h-5 mr-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
</svg>
                    </x-settings-item>
                </div>

                <div>
                    <x-settings-item title="{{ __('Earnings') }}" wireClick="exportData(7, 'Earnings')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-5 h-5 mr-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
</svg>
                    </x-settings-item>
                </div>
                <div>
                    <x-settings-item title="{{ __('Payouts') }}" wireClick="exportData(8, 'Payouts')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="w-5 h-5 mr-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
</svg>
                    </x-settings-item>
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
