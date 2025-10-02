@section('title', __('Websocket Settings'))
<div>

    <x-baseview title="{{ __('Websocket Settings') }}">
        @production


            <x-slot:newBtn>
                <x-buttons.plain title="" bgColor="bg-primary-500" wireClick="regenerateKeys">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
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
                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                </svg>
                <p>{{ __('Production View Only') }}</p>
            </div>
        @endproduction
    </x-baseview>

</div>
