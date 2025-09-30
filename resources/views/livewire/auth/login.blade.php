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
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.5V3m-3.75 9.75h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v7.5a2.25 2.25 0 002.25 2.25z" />
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
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-1.5-1.5V6.75a1.5 1.5 0 011.5-1.5h7.5a1.5 1.5 0 011.5 1.5v10.5a1.5 1.5 0 01-1.5 1.5h-7.5zM12 12a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" />
                                                    </svg>
                                                    <p class="md:my-2 text-sm font-medium">
                                                        {{ __('Join as a Driver') }}
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
