@section('title', __('Troubleshoot'))
<div>

    <x-baseview title="{{ __('Troubleshoot') }} ">

        <div class="grid grid-cols-1 gap-6 mt-10 md:grid-cols-2 lg:grid-cols-3">
            {{-- fix image --}}
            <x-settings-item title="{{ __('Fix Image(Not Loading)') }}" wireClick="fixImage">
                <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </x-settings-item>
            {{-- clear cache --}}
            <x-settings-item title="{{ __('Clear Cache') }}" wireClick="fixCache">
                <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </x-settings-item>
            {{-- restart queue --}}
            <x-settings-item title="{{ __('Restart Queue') }}" wireClick="restartQueue">
                <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </x-settings-item>
            {{-- restart reverb --}}
            <x-settings-item title="{{ __('Restart Laravel Reverb [Websocket]') }}" wireClick="restartReverb">
                <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </x-settings-item>

            {{-- fix notification --}}
            <x-settings-item title="{{ __('Notification Error') }}" wireClick="fixNotification">
                <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 002.828 0L12.828 7H4.828zM4.828 17l2.586-2.586a2 2 0 012.828 0L12.828 17H4.828zM15 7h5l-5-5v5z"></path>
                </svg>
            </x-settings-item>

            {{-- auto assignment --}}
            <x-settings-item title="{{ __('Auto assignment') }}" wireClick="fixAutoassignment">
                <svg class="w-5 h-5 rtl:ml-4 ltr:mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 002.828 0L12.828 7H4.828zM4.828 17l2.586-2.586a2 2 0 012.828 0L12.828 17H4.828zM15 7h5l-5-5v5z"></path>
                </svg>
            </x-settings-item>

            {{-- referal code --}}
            <x-settings-item title="{{ __('User referral code') }}" wireClick="fixReferralCodes">
                <svg class="w-5 h-5 rtl:ml-4 ltr:mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                </svg>
            </x-settings-item>

            {{-- role/permssions --}}
            <x-settings-item title="{{ __('User roles/permissions') }}" wireClick="fixUserPermission">
                <svg class="w-5 h-5 rtl:ml-4 ltr:mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                </svg>
            </x-settings-item>

            {{-- missing roles --}}
            <x-settings-item title="{{ __('User missing roles') }}" wireClick="fixMissingUserRoles">
                <svg class="w-5 h-5 rtl:ml-4 ltr:mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                </svg>
            </x-settings-item>

            {{-- Model Translations --}}
            <x-settings-item title="{{ __('Model Translations') }}" wireClick="fixModelTranslations">
                <svg class="w-5 h-5 rtl:ml-4 ltr:mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                </svg>
            </x-settings-item>

            {{-- Product Translations --}}
            <x-settings-item title="{{ __('Product Translations') }}" wireClick="fixProductTranslations">
                <svg class="w-5 h-5 rtl:ml-4 ltr:mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                </svg>
            </x-settings-item>

            {{-- Model Translations Fallback --}}
            <x-settings-item title="{{ __('Model Translations Fallback') }}" wireClick="fixTranslationFallback">
                <svg class="w-5 h-5 rtl:ml-4 ltr:mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                </svg>
            </x-settings-item>

            {{-- fix arabic trans value --}}
            <x-settings-item title="{{ __('Fix Arabic Translation Values') }}" wireClick="fixArabicTranslationModels">
                <svg class="w-5 h-5 rtl:ml-4 ltr:mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                </svg>
            </x-settings-item>

            {{-- generate firebase indexes --}}
            <x-settings-item title="{{ __('Generate Firestore Indexes Links') }}" wireClick="fixFirestoreIndexesLink">
                <svg class="w-5 h-5 rtl:ml-4 ltr:mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
            </x-settings-item>

            {{-- update driver records in firebase --}}
            <x-settings-item title="{{ __('Fix Regular Driver Firebase Issue') }}"
                wireClick="fixFirebaseDriverRecords">
                <svg class="w-5 h-5 rtl:ml-4 ltr:mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
                <x-slot name="info">
                    <div class="text-xs p-2">
                        <p>
                            {{ __('This will try fix the regular drivers record in the firebase that was setting wrongly') }}
                        </p>
                        <p class="text-red-500">
                            {{ __('These process might be longer depending on the size of your driver record') }}
                        </p>
                    </div>
                </x-slot>
            </x-settings-item>

            {{-- try clear browser tokens --}}
            <x-settings-item title="{{ __('Clear Browser Notification Tokens') }}" wireClick="fixWebBrowserFCMTokens">
                <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </x-settings-item>


        </div>


        <hr class="my-8" />
        {{-- sync boundaries --}}
        <div class="grid grid-cols-1 gap-6 mt-10 md:grid-cols-2 lg:grid-cols-3">
            {{-- countries --}}
            <x-settings-item title="{{ __('Sync Geo Boundaries') }}({{ __('Countries') }})"
                wireClick="fixCountiresBoundaries">
                <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                </svg>
                <x-slot name="info">
                    <div class="text-xs p-2">
                        <p>
                            {{ __('All the boundaries of the countries will be synced with the latest data. This helps with parcel delivery operation restrictions.') }}
                            <br />
                            <span class="text-red-500">
                                {{ __('These process might be longer depending on the size of your countries data') }}
                            </span>
                        </p>
                    </div>
                </x-slot>
            </x-settings-item>
            {{-- states --}}
            <x-settings-item title="{{ __('Sync Geo Boundaries') }}({{ __('States') }})"
                wireClick="fixStatesBoundaries">
                <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                </svg>
                <x-slot name="info">
                    <div class="text-xs p-2">
                        <p>
                            {{ __('All the boundaries of the States will be synced with the latest data. This helps with parcel delivery operation restrictions.') }}
                            <br />
                            <span class="text-red-500">
                                {{ __('These process might be longer depending on the size of your states data') }}
                            </span>
                        </p>
                    </div>
                </x-slot>
            </x-settings-item>
            {{-- cities --}}
            <x-settings-item title="{{ __('Sync Geo Boundaries') }}({{ __('Cities') }})"
                wireClick="fixCitiesBoundaries">
                <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                </svg>
                <x-slot name="info">
                    <div class="text-xs p-2">
                        <p>
                            {{ __('All the boundaries of the Cities will be synced with the latest data. This helps with parcel delivery operation restrictions.') }}
                            <br />
                            <span class="text-red-500">
                                {{ __('These process might be longer depending on the size of your cities data') }}
                            </span>
                        </p>
                    </div>
                </x-slot>
            </x-settings-item>
        </div>
    </x-baseview>

    <div x-data="{ open: @entangle('showCreate') }">
        <x-modal>
            <p class="text-xl font-semibold">{{ __('Auto Assignment checks') }}</p>
            <hr class="my-2" />
            @foreach ($autoAssignmentChecks as $key => $autoAssignmentCheck)
                <div class="flex items-center py-2 my-2 ">

                    <div class="w-6/12">{{ Str::title(str_ireplace('_', ' ', $key)) }}</div>
                    <div class="w-full h-1 mx-2 border-b border-dashed"></div>
                    <div
                        class="text-white rounded-full p-1 {{ $autoAssignmentCheck ? 'bg-green-500' : 'bg-red-500' }}">
                        @if ($autoAssignmentCheck)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        @endif
                    </div>

                </div>
            @endforeach
        </x-modal>
    </div>


</div>
