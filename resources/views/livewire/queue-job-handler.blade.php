@section('title', __('Jobs Monitor'))
<div>

    <x-baseview title="{{ __('Jobs Monitor') }}">

        <x-tab.tabview class="shadow pb-10">

            <x-slot name="header">
                <x-tab.header tab="1" title="{{ __('Jobs') }}">
                    <svg class="w-4 h-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                </x-tab.header>
                <x-tab.header tab="2" title="{{ __('Failed Jobs') }}">
                    <svg class="w-4 h-4 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 9l6 6m0-6l-6 6m6-6H9m6 6H9m6 6a9 9 0 11-18 0 9 9 0 0118 0z" />
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
