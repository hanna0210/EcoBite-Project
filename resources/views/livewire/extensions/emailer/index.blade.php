<div>
    {{-- Success is as dangerous as failure. --}}
    
    {{-- Header with Back Button --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Emailer') }}</h1>
        <a href="{{ route('extensions') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
            {{ __('Back') }}
        </a>
    </div>

    {{-- Main Form Container --}}
    <div class="bg-white rounded-lg shadow-sm">
        <x-form action="sendEmails" id="emailerForm">
            <div class="p-6 space-y-6">
                
                {{-- Subject Input --}}
                <div>
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">{{ __('Subject') }}</label>
                    <input type="text" wire:model.defer="title" id="title" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" 
                        placeholder="Subject">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email Body Editor --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">{{ __('Email Body') }}</label>
                    <div wire:ignore>
                        <div id="emailerEditor" style="min-height: 400px;"></div>
                        <input type="hidden" id="emailerBody" />
                    </div>
                    @error('body')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Recipients Section - Collapsible --}}
                <div class="pt-4 border-t border-gray-200" x-data="{ recipientsOpen: true }">
                    <button type="button" @click="recipientsOpen = !recipientsOpen" 
                        class="flex items-center justify-between w-full text-left">
                        <h3 class="text-base font-semibold text-gray-900">{{ __('Recipients') }}</h3>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': recipientsOpen }" 
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="recipientsOpen" x-transition class="mt-4 space-y-4">
                        
                        {{-- Recipient Type Selection --}}
                        <div class="flex flex-wrap gap-3">
                            <label class="inline-flex items-center px-4 py-2 border rounded-lg cursor-pointer" 
                                :class="@entangle('allReceiver') ? 'border-primary-500 bg-primary-50' : 'border-gray-300 bg-white hover:bg-gray-50'">
                                <input type="checkbox" wire:model="allReceiver" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                <span class="ml-2 text-sm font-medium text-gray-900">{{ __('All Users') }}</span>
                            </label>

                            <label class="inline-flex items-center px-4 py-2 border rounded-lg cursor-pointer" 
                                :class="@entangle('roleReceiver') ? 'border-primary-500 bg-primary-50' : 'border-gray-300 bg-white hover:bg-gray-50'">
                                <input type="checkbox" wire:model="roleReceiver" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                <span class="ml-2 text-sm font-medium text-gray-900">{{ __('By Roles') }}</span>
                            </label>

                            <label class="inline-flex items-center px-4 py-2 border rounded-lg cursor-pointer" 
                                :class="@entangle('customReceiver') ? 'border-primary-500 bg-primary-50' : 'border-gray-300 bg-white hover:bg-gray-50'">
                                <input type="checkbox" wire:model="customReceiver" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                <span class="ml-2 text-sm font-medium text-gray-900">{{ __('Custom Emails') }}</span>
                            </label>
                        </div>

                        {{-- Role Selection --}}
                        <div x-data="{ open: @entangle('roleReceiver') }" x-show="open" x-transition>
                            <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('Select Roles') }}</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($roles as $key => $role)
                                <label class="inline-flex items-center px-3 py-1.5 text-sm border border-gray-300 rounded-md cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" wire:model="customReceiverRoles.{{ $key }}" value="{{ $role->name }}" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                    <span class="ml-2 text-gray-700">{{ $role->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Custom Email Input --}}
                        <div x-data="{ open: @entangle('customReceiver') }" x-show="open" x-transition>
                            <label for="customerEmails" class="block mb-2 text-sm font-medium text-gray-700">{{ __('Email Addresses') }}</label>
                            <input type="text" wire:model.defer="customerEmails" id="customerEmails"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" 
                                placeholder="email1@example.com; email2@example.com">
                            <p class="mt-1 text-xs text-gray-500">{{ __('Separate multiple email addresses with a semicolon (;)') }}</p>
                            @error('customerEmails')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer with Send Button --}}
            <div class="flex justify-end px-6 py-4 bg-gray-50 rounded-b-lg">
                <button type="submit" class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <x-heroicon-o-paper-airplane class="w-4 h-4 mr-2" />
                    {{ __('Send Emails') }}
                </button>
            </div>
        </x-form>
    </div>

    {{-- loading --}}
    <div wire:loading wire:target="sendEmails" class="fixed top-0 bottom-0 left-0 z-50 w-full h-full ">
        <div class="fixed top-0 bottom-0 left-0 w-full h-full bg-black opacity-75"></div>
        <div class="fixed top-0 bottom-0 left-0 flex items-center justify-center w-full h-full">
            <img src="{{ asset('images/loading.svg') }}" class="" />
        </div>
    </div>

    {{-- styles --}}
    @push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/quill.css') }}" />
    <style>
        #emailerEditor {
            background: white;
        }
        
        #emailerEditor .ql-container {
            min-height: 400px;
            height: 100%;
            flex: 1;
            display: flex;
            flex-direction: column;
            font-size: 14px;
        }

        #emailerEditor .ql-editor {
            height: 100%;
            flex: 1;
            overflow-y: auto;
            width: 100%;
            min-height: 400px;
        }
        
        #emailerEditor .ql-toolbar {
            border-top-left-radius: 0.375rem;
            border-top-right-radius: 0.375rem;
        }
    </style>
    @endpush

    {{-- scripts --}}
    @push('scripts')
    <script src="{{ asset('js/quill.js') }}"></script>
    <script src="{{ asset('js/extensions/emailer.js') }}"></script>
    @endpush

</div>
