@section('title', __('Jobs Monitor'))
<div>

    <x-baseview title="{{ __('Jobs Monitor') }}">

        <x-tab.tabview class="shadow pb-10">

            <x-slot name="header">
                <x-tab.header tab="1" title="{{ __('Jobs') }}">
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </x-tab.header>
                <x-tab.header tab="2" title="{{ __('Failed Jobs') }}">
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </x-tab.header>
            </x-slot>

            <x-slot name="body">
                <x-tab.body tab="1">
                    @livewire('components.queue-jobs-table', [
                        'showBorder' => false,
                    ])
                </x-tab.body>
                <x-tab.body tab="2">
                    @livewire('components.failed-jobs-table', [
                        'showBorder' => false,
                    ])
                </x-tab.body>

            </x-slot>

        </x-tab.tabview>

    </x-baseview>


</div>
