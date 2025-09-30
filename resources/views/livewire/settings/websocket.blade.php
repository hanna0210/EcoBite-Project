@section('title', __('Websocket Settings'))
<div>

    <x-baseview title="{{ __('Websocket Settings') }}">
        @production


            <x-slot:newBtn>
                <x-buttons.plain title="" bgColor="bg-primary-500" wireClick="regenerateKeys">
                    <svg class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                    </svg>
                    <p>{{ __('Re-Generate') }}</p>
                </x-buttons.plain>
            </x-slot:newBtn>
            <div class="w-full p-8 rounded bg-white">
                <p class="font-bold">{{ __('Websocket connection Details') }}</p>
                <p class="font-thing text-sm">
                    {{ __('Note: The values below are auto loaded by the apps to work, there is no need to do anything') }}
                </p>
                <div class="my-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <x-copyable-input label="{{ __('Websocket Host') }}" value="{{ env('REVERB_HOST') }}" />
                    <x-copyable-input label="{{ __('Websocket Port') }}" value="{{ env('REVERB_PORT') }}" />
                    <x-copyable-input label="{{ __('Websocket Scheme') }}" value="{{ env('REVERB_SCHEME') }}" />
                    <x-copyable-input label="{{ __('Websocket App ID') }}" value="{{ env('REVERB_APP_ID') }}" />
                    <x-copyable-input label="{{ __('Websocket App Key') }}" value="{{ env('REVERB_APP_KEY') }}" />
                    <x-copyable-input label="{{ __('Websocket App Secret') }}" value="{{ env('REVERB_APP_SECRET') }}" />
                    <x-copyable-input label="{{ __('Websocket Server Host') }}" value="{{ env('REVERB_SERVER_HOST') }}" />
                    <x-copyable-input label="{{ __('Websocket Server Port') }}" value="{{ env('REVERB_SERVER_PORT') }}" />
                </div>
            </div>
        @else
            <div class="w-full p-8 rounded bg-white text-center space-y-2">
                <svg class="w-12 h-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672ZM12 2.25V4.5m5.834.166-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243-1.59-1.59" />
                </svg>
                <p>{{ __('Production View Only') }}</p>
            </div>
        @endproduction
    </x-baseview>

</div>
