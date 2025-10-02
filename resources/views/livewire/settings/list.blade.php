<div class="grid grid-cols-1 gap-6 mt-10 md:grid-cols-2 lg:grid-cols-3">

    {{-- Firebase settings --}}
    <x-settings-item title="{{ __('Push notification (Firebase)') }}" wireClick="$set('showNotification',true)">
        <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
        </svg>
    </x-settings-item>

    {{-- app settings --}}
    <x-settings-item title="{{ __('Web App Settings') }}" wireClick="$set('showApp',true)">
        <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
    </x-settings-item>

    {{-- file size settings --}}
    <x-settings-item title="{{ __('File Upload Limit Settings') }}" wireClick="$set('showFileLimits',true)">
        <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
        </svg>
    </x-settings-item>

    {{-- custom message --}}
    <x-settings-item title="{{ __('Custom Notification Messages') }}"
        wireClick="$set('showCustomNotificationMessage',true)">
        <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 002.828 0L12.828 7H4.828zM4.828 17l2.586-2.586a2 2 0 012.828 0L12.828 17H4.828zM15 7h5l-5-5v5z"></path>
        </svg>
    </x-settings-item>


    {{-- Privacy policy --}}
    <x-settings-item title="{!! __('Privacy & Policy') !!}" wireClick="$set('showPrivacy',true)">
        <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
        </svg>
    </x-settings-item>

    {{-- Contact info --}}
    <x-settings-item title="{{ __('Contact Info') }}" wireClick="$set('showContact',true)">
        <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
    </x-settings-item>

    {{-- Terms and conditions --}}
    <x-settings-item title="{!! __('Terms & Conditions') !!}" wireClick="$set('showTerms',true)">
        <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
        </svg>
    </x-settings-item>

    {{-- Terms and conditions --}}
    <x-settings-item title="{{ __('Page Settings') }}" wireClick="$set('showPageSetting',true)">
        <svg class="w-5 h-5 {{ isRTL() ? 'ml-4' : 'mr-4' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
        </svg>
    </x-settings-item>

</div>
