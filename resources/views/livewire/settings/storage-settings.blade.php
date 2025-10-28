<div>
    <x-form action="saveStorageSettings" :noClass="true">
        
        {{-- Storage Disk Selection --}}
        <div class="mb-8">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">{{ __('File Storage Configuration') }}</h3>
            
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <x-select 
                        title="{{ __('Storage Disk') }}" 
                        :options="$storageDiskOptions" 
                        name="mediaDisk" 
                        :noPreSelect="false" 
                    />
                    <p class="mt-2 text-xs text-gray-500">
                        {{ __('Select where uploaded files (images, documents, etc.) should be stored') }}
                    </p>
                </div>
                
                <div class="p-4 bg-blue-50 border border-blue-200 rounded">
                    <p class="text-sm font-medium text-blue-800">{{ __('Current Storage:') }}</p>
                    <p class="mt-1 text-xs text-blue-600">
                        @if($mediaDisk === 'gdrive')
                            <span class="font-semibold">Google Drive</span> - {{ __('Files stored in Google Drive cloud storage') }}
                        @elseif($mediaDisk === 'local')
                            <span class="font-semibold">Local Storage (Private)</span> - {{ __('Files stored on server (not publicly accessible)') }}
                        @else
                            <span class="font-semibold">Local Storage (Public)</span> - {{ __('Files stored on server in public directory') }}
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <x-hr />

        {{-- Google Drive Configuration --}}
        <div class="mt-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">{{ __('Google Drive Configuration') }}</h3>
                @if($mediaDisk === 'gdrive')
                    <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded">{{ __('Active') }}</span>
                @else
                    <span class="px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded">{{ __('Inactive') }}</span>
                @endif
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-input 
                    title="{{ __('Client ID') }}" 
                    name="googleDriveClientId" 
                    placeholder="123456789-abc.apps.googleusercontent.com"
                />
                
                <x-input 
                    title="{{ __('Client Secret') }}" 
                    name="googleDriveClientSecret" 
                    type="password"
                    placeholder="{{ __('Enter Client Secret') }}"
                />
                
                <div class="md:col-span-2">
                    <x-input 
                        title="{{ __('Refresh Token') }}" 
                        name="googleDriveRefreshToken" 
                        type="password"
                        placeholder="{{ __('Enter Refresh Token') }}"
                    />
                </div>
                
                <x-input 
                    title="{{ __('Folder ID') }} ({{ __('Optional') }})" 
                    name="googleDriveFolderId" 
                    placeholder="{{ __('Leave empty to use root folder') }}"
                />
            </div>

            {{-- Setup Instructions --}}
            <div class="p-4 mt-6 bg-gray-50 border border-gray-200 rounded">
                <p class="mb-2 text-sm font-semibold text-gray-700">{{ __('Setup Instructions:') }}</p>
                <ol class="text-xs text-gray-600 list-decimal list-inside space-y-1">
                    <li>
                        {{ __('Go to') }} 
                        <a href="https://console.cloud.google.com/" target="_blank" class="text-blue-600 underline">
                            Google Cloud Console
                        </a>
                    </li>
                    <li>{{ __('Create a new project or select an existing one') }}</li>
                    <li>{{ __('Enable the Google Drive API for your project') }}</li>
                    <li>{{ __('Create OAuth 2.0 credentials (Client ID and Client Secret)') }}</li>
                    <li>
                        {{ __('Get your Refresh Token from') }} 
                        <a href="https://developers.google.com/oauthplayground" target="_blank" class="text-blue-600 underline">
                            OAuth Playground
                        </a>
                    </li>
                    <li>{{ __('Enter all credentials above and save') }}</li>
                    <li>{{ __('Click "Test Connection" to verify setup') }}</li>
                </ol>
            </div>

            {{-- Test Connection Button --}}
            <div class="mt-6">
                <button 
                    type="button" 
                    wire:click="testGoogleDriveConnection" 
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    {{ __('Test Connection') }}
                </button>
            </div>

            {{-- Connection Test Result --}}
            @if($showConnectionTest)
                <div class="mt-4">
                    @if($connectionStatus === 'success')
                        <div class="p-4 bg-green-50 border border-green-200 rounded">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm font-medium text-green-800">{{ $connectionMessage }}</p>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-red-50 border border-red-200 rounded">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm text-red-800">{{ $connectionMessage }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <x-hr />

        {{-- Important Notes --}}
        <div class="p-4 mt-6 bg-yellow-50 border border-yellow-200 rounded">
            <p class="mb-2 text-sm font-semibold text-yellow-800">⚠️ {{ __('Important Notes:') }}</p>
            <ul class="text-xs text-yellow-700 list-disc list-inside space-y-1">
                <li>{{ __('Changing storage disk will affect where new files are uploaded') }}</li>
                <li>{{ __('Existing files will remain in their current location') }}</li>
                <li>{{ __('Make sure to test Google Drive connection before switching to it') }}</li>
                <li>{{ __('Local storage is faster but Google Drive offers unlimited storage and better reliability') }}</li>
            </ul>
        </div>

        {{-- Save Button --}}
        <div class="mt-6">
            <x-buttons.primary title="{{ __('Save Storage Settings') }}" />
        </div>
    </x-form>
</div>

