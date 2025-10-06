@section('title', 'Login')
<div>
    <div class="min-h-screen p-6 bg-gray-50 ">
        <div class="flex items-center ">
            <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl ">
                <div class="flex flex-col overflow-y-auto md:flex-row">
                    <div class="h-32 md:h-auto md:w-1/2">
                        <img aria-hidden="true" class="object-cover w-full h-full"
                            src="{{ getValidValue(setting('loginImage'), asset('images/login.jpeg')) }}" alt="Office" />
                    </div>
                    {{-- form --}}
                    <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                        <div class="w-full">
                            <form wire:submit.prevent="login">
                                @csrf
                                <div class="flex items-center justify-between">
                                    <h1 class="mb-4 text-xl font-semibold text-gray-700">{{ __('Login') }}</h1>
                                    <livewire:select.language-selector />
                                </div>
                                <x-input title="{{ __('Email') }}" type="email" placeholder="info@mail.com"
                                    name="email" />
                                <x-input-password title="{{ __('Password') }}" name="password" />
                                <div class="hidden">
                                    <x-input title="" type="" placeholder="" name="fcmToken" />
                                </div>
                                <x-checkbox description="{{ __('Remember me') }}" name="remember" />
                                <p class="flex items-center justify-end mt-2">
                                    <a class="text-sm font-medium text-primary-600 hover:underline"
                                        href="{{ route('password.forgot') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                </p>
                                <x-buttons.primary title="{{ __('Login') }}" />
                            </form>

                            {{-- registration  --}}
                            @if (setting('partnersCanRegister', true))
                                <div>
                                    <div class="flex items-center gap-2 text-sm text-primary-500 my-4">
                                        <div class="flex-1 border-t border-primary-500"></div>
                                        <span>{{ __('Or') }}</span>
                                        <div class="flex-1 border-t border-primary-500"></div>
                                    </div>
                                    {{-- <p class="text-center my-2">{{ __('Join Us') }}</p> --}}
                                    <div class=" space-y-4">
                                        <div>
                                            <a href="{{ route('register.vendor') }}"
                                                class="w-full text-primary-500 hover:underline">
                                                <div
                                                    class="w-full border shadow-sm rounded p-2 flex items-center justify-center space-x-2 rtl:space-x-reverse hover:shadow-md">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                    </svg>
                                                    <p class="md:my-2 text-sm font-medium">
                                                        {{ __('Become a Vendor/Seller') }}
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="{{ route('register.driver') }}"
                                                class="w-full text-primary-500 hover:underline">
                                                <div
                                                    class="w-full border shadow-sm rounded p-2 flex items-center justify-center space-x-2 rtl:space-x-reverse hover:shadow-md">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                                    </svg>
                                                    <p class="md:my-2 text-sm font-medium">
                                                        {{ __('Join as a Driver | Deliver') }}
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (!App::environment('production'))
                                <hr class="my-5" />
                                <div class="p-2 mb-5 bg-red-100 border rounded shadow cursor-pointer hover:shadow-lg"
                                    wire:click="loadAccount(0)">
                                    <p class="font-medium ">Admin Account</p>
                                    <p class="text-sm ">Email: admin@demo.com | Password: password</p>
                                </div>
                                <div class="p-2 mb-5 bg-red-100 border rounded shadow cursor-pointer hover:shadow-lg"
                                    wire:click="loadAccount(3)">
                                    <p class="font-medium ">City-admin Account</p>
                                    <p class="text-sm ">Email: city-admin@demo.com | Password: password</p>
                                </div>

                                <div class="p-2 mb-5 bg-purple-100 border rounded shadow cursor-pointer hover:shadow-lg"
                                    wire:click="loadAccount(1)">
                                    <p class="font-medium ">Manager Account</p>
                                    <p class="text-sm ">Email: manager@demo.com | Password: password</p>
                                </div>
                                <div class="p-2 mb-5 bg-purple-100 border rounded shadow cursor-pointer hover:shadow-lg"
                                    wire:click="loadAccount(2)">
                                    <p class="font-medium ">Manager Account(Parcel Vendor)</p>
                                    <p class="text-sm ">Email: manager1@demo.com | Password: password</p>
                                </div>
                                <div class="p-2 mb-5 bg-purple-100 border rounded shadow cursor-pointer hover:shadow-lg"
                                    wire:click="loadAccount(4)">
                                    <p class="font-medium ">Manager Account(Service Vendor)</p>
                                    <p class="text-sm ">Email: manager3@demo.com | Password: password</p>
                                </div>

                                <div class="p-2 mb-5 bg-green-100 border rounded shadow cursor-pointer hover:shadow-lg"
                                    {{-- wire:click="loadAccount(3)" --}}>
                                    <p class="font-medium ">Client Account (You can not login to backend)</p>
                                    <p class="text-sm ">Email: client@demo.com | Password: password</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="p-2 mx-auto text-center">
            <p class="text-xs text-gray-500">{{ __('version') }} {{ setting('appVerison', '1.0.0') }}</p>
        </div>
    </div>
    {{-- loading --}}
    <x-loading />
</div>
