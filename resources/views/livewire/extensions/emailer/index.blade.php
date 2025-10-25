<div>
    {{-- Success is as dangerous as failure. --}}
    @if($showView)
    <div class="flex items-center w-full mb-3 text-2xl font-semibold">
        Emailer
        <div class="mx-auto"></div>
        <div class="{{ setting('localeCode') == 'ar' ? 'mr-auto':'ml-auto' }}">
            <x-buttons.primary title="Back" wireClick="showExtensions" />
        </div>
    </div>


    <x-form action="sendEmails">
        <x-input title="{{ __('Subject') }}" name="title" placeholder="Subject" />
        <p class="my-4"></p>
        <div wire:ignore>
            <textarea id="emailerTextArea" name="emailBody"></textarea>
        </div>

        {{-- receiver --}}
        <div class="p-2 border border-gray-200 rounded bg-gray-50">
            <div class="grid grid-cols-2 gap-2 pb-4 border-b">
                <x-checkbox title="{{ __('All') }}" name="allReceiver" description="Send to all users" :defer="false" />
                <x-checkbox title="{{ __('Roles') }}" name="roleReceiver" description="Send Directly to roles" :defer="false" />
                <x-checkbox title="{{ __('Custom') }}" name="customReceiver" description="Send Directly to emails" :defer="false" />
            </div>
            <div class="flex flex-wrap mt-2 mb-6 space-x-5" x-data="{ open: @entangle('roleReceiver') }" x-show="open">
                @foreach ($roles as $key => $role)
                <x-checkbox title="{{ $role->name }}" name="customReceiverRoles.{{ $key }}" value="{{ $role->name }}" :defer="false" />
                @endforeach
            </div>
            <div class="mt-2 mb-6 space-x-5" x-data="{ open: @entangle('customReceiver') }" x-show="open">
                <x-input title="{{ __('Emails') }}" name="customerEmails" :defer="false" />
                <p class="px-0 py-1 text-xs font-light text-red-500">{{ __('Seperate emails with semi-colon(;)') }}</p>
            </div>
        </div>

        <x-buttons.primary title="Send">
            <x-heroicon-o-mail class="w-4 h-4 mx-2" />
        </x-buttons.primary>
    </x-form>

    {{-- loading --}}
    <div wire:loading wire:target="sendEmails" class="fixed top-0 bottom-0 left-0 z-50 w-full h-full ">
        <div class="fixed top-0 bottom-0 left-0 w-full h-full bg-black opacity-75"></div>
        <div class="fixed top-0 bottom-0 left-0 flex items-center justify-center w-full h-full">
            <img src="{{ asset('images/loading.svg') }}" class="" />
        </div>
    </div>

    @endif

    {{-- styles --}}
    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
    @endpush

    {{-- scripts --}}
    @push('scripts')
    <script src="{{ asset('js/extensions/emailer-easymde.min.js') }}"></script>
    <script src="{{ asset('js/extensions/emailer.js') }}"></script>
    @endpush

</div>
