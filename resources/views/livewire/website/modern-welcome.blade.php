@extends('layouts.guest')

@section('title', 'Glover - Your Local Everything, Delivered')

@section('content')
    @php
        $colors = getAppColorShades();
        $appName = setting('websiteName', env('APP_NAME'));
        $foodModule = remember_result(
            'food_module_fetch',
            function () {
                return \App\Models\VendorType::where('slug', 'food')->active()->first();
            },
            60,
        );
        $groceryModule = remember_result(
            'grocery_module_fetch',
            function () {
                return \App\Models\VendorType::where('slug', 'grocery')->active()->first();
            },
            60,
        );
        $taxiModule = remember_result(
            'taxi_module_fetch',
            function () {
                return \App\Models\VendorType::where('slug', 'taxi')->active()->first();
            },
            60,
        );
        $parcelModule = remember_result(
            'parcel_module_fetch',
            function () {
                return \App\Models\VendorType::where('slug', ['parcel', 'package'])
                    ->active()
                    ->first();
            },
            60,
        );
        $serviceModule = remember_result(
            'service_module_fetch',
            function () {
                return \App\Models\VendorType::where('slug', ['service', 'booking'])
                    ->active()
                    ->first();
            },
            60,
        );
        $pharmacyModule = remember_result(
            'pharmacy_module_fetch',
            function () {
                return \App\Models\VendorType::where('slug', ['pharmacy', 'drug', 'medicine'])
                    ->active()
                    ->first();
            },
            60,
        );
    @endphp
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, {{ $colors['shades'][500] }} 0%, {{ $colors['shades'][900] }} 100%);
        }

        .service-card {
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        .floating-animation:nth-child(2) {
            animation-delay: -2s;
        }

        .floating-animation:nth-child(3) {
            animation-delay: -4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }

        @keyframes pulse-glow {
            from {
                box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
            }

            to {
                box-shadow: 0 0 30px rgba(102, 126, 234, 0.6);
            }
        }

        .text-gradient {
            background: linear-gradient(135deg, {{ $colors['shades'][500] }} 0%, {{ $colors['shades'][900] }} 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .from-primary-600 {
            --tw-gradient-from: {{ $colors['shades'][600] }};
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(255, 255, 255, 0));
        }

        .to-primary-600 {
            --tw-gradient-to: {{ $colors['shades'][600] }};
        }
    </style>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-md z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="text-2xl font-bold text-gradient">{{ $appName }}</div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#services"
                        class="text-gray-700 hover:text-primary-600 transition-colors">{{ __('Services') }}</a>
                    <a href="#how-it-works"
                        class="text-gray-700 hover:text-primary-600 transition-colors">{{ __('How It Works') }}</a>
                    <a href="#download"
                        class="text-gray-700 hover:text-primary-600 transition-colors">{{ __('Download') }}</a>
                    <a href="{{ route('login') }}"
                        class="bg-primary-600 text-white px-6 py-2 rounded-full hover:bg-primary-700 transition-all pulse-glow">
                        {{ __('Admin/Store Login') }}
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-16 gradient-bg min-h-screen flex items-center relative overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>

        <!-- Floating Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-white/20 rounded-full floating-animation"></div>
        <div class="absolute top-40 right-20 w-16 h-16 bg-white/15 rounded-full floating-animation"></div>
        <div class="absolute bottom-32 left-1/4 w-12 h-12 bg-white/25 rounded-full floating-animation"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-left">
                    <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
                        {!! setting('website.modern.websiteHeaderTitle', '') !!}
                    </h1>
                    <p class="text-xl md:text-2xl text-white/90 mb-8">
                        {!! nl2br(setting('website.modern.websiteHeaderSubtitle', '')) !!}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#download"
                            class="bg-white text-primary-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg">
                            📱 {{ __('Download App') }}
                        </a>
                    </div>
                </div>

                <!-- Right Image Showcase -->
                <div class="relative flex justify-center lg:justify-end">
                    <div class="relative">
                        <!-- Main Phone Mockup -->
                        <div class="relative z-10 transform rotate-3 hover:rotate-0 transition-transform duration-700">
                            <div class="bg-gray-900 rounded-3xl p-2 shadow-2xl">
                                <div class="bg-white rounded-2xl overflow-hidden" style="width: 280px; height: 580px;">
                                    <!-- Phone Screen Content -->
                                    <div class="bg-gradient-to-br from-primary-600 to-primary-600 p-4 h-full flex flex-col">
                                        <!-- Status Bar -->
                                        <div class="flex justify-between items-center text-white text-sm mb-4">
                                            <span>9:41</span>
                                            <span>●●●●●</span>
                                            <span>🔋 100%</span>
                                        </div>

                                        <!-- App Header -->
                                        <div class="text-center mb-6">
                                            <h2 class="text-white text-2xl font-bold">{{ $appName }}</h2>
                                            <p class="text-white/80 text-sm">
                                                {{ cached_setting('website.modern.websitePhoneSubtitle', __('What do you need today?')) }}
                                            </p>
                                        </div>

                                        <!-- Service Grid -->
                                        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 mb-6">
                                            @if ($foodModule)
                                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                                                    <div class="text-2xl mb-2">🍕</div>
                                                    <div class="text-white text-sm font-medium">{{ __('Food') }}</div>
                                                </div>
                                            @endif
                                            @if ($groceryModule)
                                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                                                    <div class="text-2xl mb-2">🥬</div>
                                                    <div class="text-white text-sm font-medium">{{ __('Grocery') }}</div>
                                                </div>
                                            @endif
                                            @if ($taxiModule)
                                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                                                    <div class="text-2xl mb-2">🚗</div>
                                                    <div class="text-white text-sm font-medium">{{ __('Taxi') }}</div>
                                                </div>
                                            @endif
                                            @if ($parcelModule)
                                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                                                    <div class="text-2xl mb-2">📦</div>
                                                    <div class="text-white text-sm font-medium">{{ __('Parcel') }}</div>
                                                </div>
                                            @endif
                                            @if ($serviceModule)
                                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 text-center">
                                                    <div class="text-2xl mb-2">🛠️</div>
                                                    <div class="text-white text-sm font-medium">{{ __('Service') }}</div>
                                                </div>
                                            @endif

                                        </div>

                                        <!-- Popular Section -->
                                        <div class="flex-1">
                                            <h3 class="text-white font-semibold mb-3">{{ __('Popular') }}</h3>
                                            <div class="space-y-2">
                                                @if ($foodModule)
                                                    <div
                                                        class="bg-white/20 backdrop-blur-sm rounded-lg p-3 flex items-center">
                                                        <div
                                                            class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white text-sm mr-3">
                                                            🍔
                                                        </div>
                                                        <div>
                                                            <div class="text-white text-sm font-medium">
                                                                {{ __('Burger Palace') }}
                                                            </div>
                                                            <div class="text-white/70 text-xs">15 min • 4.8 ⭐</div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($groceryModule)
                                                    <div
                                                        class="bg-white/20 backdrop-blur-sm rounded-lg p-3 flex items-center">
                                                        <div
                                                            class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm mr-3">
                                                            🥗
                                                        </div>
                                                        <div>
                                                            <div class="text-white text-sm font-medium">
                                                                {{ __('Fresh Market') }}
                                                            </div>
                                                            <div class="text-white/70 text-xs">8 min • 4.9 ⭐</div>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($taxiModule)
                                                    <div
                                                        class="bg-white/20 backdrop-blur-sm rounded-lg p-3 flex items-center">
                                                        <div
                                                            class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm mr-3">
                                                            🚙
                                                        </div>
                                                        <div>
                                                            <div class="text-white text-sm font-medium">
                                                                {{ __('Quick Ride') }}
                                                            </div>
                                                            <div class="text-white/70 text-xs">2 min pickup • 4.7 ⭐</div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Service Icons -->
                        @if ($foodModule)
                            <div
                                class="absolute -top-8 -left-8 bg-white/20 backdrop-blur-sm rounded-full p-4 floating-animation">
                                <div class="text-3xl">🍕</div>
                            </div>
                        @endif
                        @if ($taxiModule)
                            <div
                                class="absolute -bottom-8 -right-8 bg-white/20 backdrop-blur-sm rounded-full p-4 floating-animation">
                                <div class="text-3xl">🚗</div>
                            </div>
                        @endif
                        @if ($parcelModule)
                            <div
                                class="absolute top-1/2 -left-12 bg-white/20 backdrop-blur-sm rounded-full p-3 floating-animation">
                                <div class="text-2xl">📦</div>
                            </div>
                        @endif
                        @if ($groceryModule)
                            <div
                                class="absolute top-1/4 -right-12 bg-white/20 backdrop-blur-sm rounded-full p-3 floating-animation">
                                <div class="text-2xl">🥬</div>
                            </div>
                        @endif
                        @if ($serviceModule)
                            <div
                                class="absolute top-1/2 -right-12 bg-white/20 backdrop-blur-sm rounded-full p-3 floating-animation">
                                <div class="text-2xl">🛠️</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    {{ __('One App') }}, <span class="text-gradient">{{ __('Endless Possibilities') }}</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    {{ __('Why juggle multiple apps when :app_name brings everything together? Your local community, delivered.', ['app_name' => $appName]) }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Food Delivery -->
                @if ($foodModule)
                    <div
                        class="service-card bg-gradient-to-br from-orange-50 to-red-50 p-8 rounded-2xl border border-orange-200">
                        <div class="text-5xl mb-4">🍕</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $foodModule->name }}</h3>
                        <p class="text-gray-600 mb-4">
                            {{ $foodModule->description }}
                        </p>
                        <div class="flex items-center text-orange-600 font-semibold">
                            <span>{{ __('Order Now') }}</span>
                            <span class="ml-2">→</span>
                        </div>
                    </div>
                @endif

                <!-- Grocery Delivery -->
                @if ($groceryModule)
                    <div
                        class="service-card bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-2xl border border-green-200">
                        <div class="text-5xl mb-4">🥬</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $groceryModule->name }}</h3>
                        <p class="text-gray-600 mb-4">
                            {{ $groceryModule->description }}
                        </p>
                        <div class="flex items-center text-green-600 font-semibold">
                            <span>{{ __('Shop Now') }}</span>
                            <span class="ml-2">→</span>
                        </div>
                    </div>
                @endif

                <!-- Taxi Service -->
                @if ($taxiModule)
                    <div
                        class="service-card bg-gradient-to-br from-blue-50 to-cyan-50 p-8 rounded-2xl border border-blue-200">
                        <div class="text-5xl mb-4">🚗</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3"> {{ $taxiModule->name }} </h3>
                        <p class="text-gray-600 mb-4">
                            {{ $taxiModule->description }}
                        </p>
                        <div class="flex items-center text-blue-600 font-semibold">
                            <span> {{ __('Book Ride') }} </span>
                            <span class="ml-2">→</span>
                        </div>
                    </div>
                @endif

                <!-- Parcel Delivery -->
                @if ($parcelModule)
                    <div
                        class="service-card bg-gradient-to-br from-primary-50 to-pink-50 p-8 rounded-2xl border border-primary-200">
                        <div class="text-5xl mb-4">📦</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3"> {{ $parcelModule->name }} </h3>
                        <p class="text-gray-600 mb-4">
                            {{ $parcelModule->description }}
                        </p>
                        <div class="flex items-center text-primary-600 font-semibold">
                            <span> {{ __('Send Package') }} </span>
                            <span class="ml-2">→</span>
                        </div>
                    </div>
                @endif

                <!-- Pharmacy -->
                @if ($pharmacyModule)
                    <div
                        class="service-card bg-gradient-to-br from-teal-50 to-cyan-50 p-8 rounded-2xl border border-teal-200">
                        <div class="text-5xl mb-4">💊</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3"> {{ $pharmacyModule->name }} </h3>
                        <p class="text-gray-600 mb-4">{{ $pharmacyModule->description }} </p>
                        <div class="flex items-center text-teal-600 font-semibold">
                            <span>{{ __('Order Meds') }} </span>
                            <span class="ml-2">→</span>
                        </div>
                    </div>
                @endif

                <!-- More Services -->
                @if ($serviceModule)
                    <div
                        class="service-card bg-gradient-to-br from-gray-50 to-slate-50 p-8 rounded-2xl border border-gray-200">
                        <div class="text-5xl mb-4">✨</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $serviceModule->name }} </h3>
                        <p class="text-gray-600 mb-4">
                            {{ $serviceModule->description }}
                        </p>
                        <div class="flex items-center text-gray-600 font-semibold">
                            <span>{{ __('Explore All') }} </span>
                            <span class="ml-2">→</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    {{ __('Simple as') }} <span class="text-gradient">1-2-3</span>
                </h2>
                <p class="text-xl text-gray-600">
                    {{ __('Getting what you need has never been easier') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-primary-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-primary-600">1</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Choose Your Service') }} </h3>
                    <p class="text-gray-600">
                        {{ __('Select from food, groceries, taxi, delivery, or any other service you need.') }}
                    </p>
                </div>

                <div class="text-center">
                    <div class="bg-primary-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-primary-600">2</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Place Your Order') }} </h3>
                    <p class="text-gray-600">
                        {{ __('Browse local options, customize your order, and checkout securely.') }}
                    </p>
                </div>

                <div class="text-center">
                    <div class="bg-primary-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-primary-600">3</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Get It Delivered') }} </h3>
                    <p class="text-gray-600">{{ __('Track your order in real-time and receive it at your doorstep.') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="download" class="py-20 gradient-bg relative overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                {{ __('Ready to Experience') }} <span class="text-primary-400">{{ $appName }}</span>?
            </h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                {{ __("Join thousands of satisfied customers who've made :app_name their go-to for everything local.", ['app_name' => $appName]) }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                <a href="https://play.google.com/store/apps/details?id={{ env('dynamic_link.android') }}"
                    class="bg-black text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-800 transition-all transform hover:scale-105 shadow-lg space-x-2 flex items-center justify-center">
                    <x-tabler-brand-android class="w-5 h-5" />
                    <p>{{ __('Get it on Google Play') }} </p>
                </a>
                <a href="https://apps.apple.com/app/{{ env('dynamic_link.ios_id') }}"
                    class="bg-white text-primary-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg space-x-2 flex items-center justify-center">
                    <x-tabler-brand-apple class="w-5 h-5" />
                    <p>{{ __('Download on App Store') }} </p>

                </a>
            </div>
            <p class="text-white/80">
                {{ __('Available on') }} Android {{ __('and') }} iOS •
                {{ __('Free Download') }}</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="text-2xl font-bold mb-4">{{ $appName }}</div>
                    <p class="text-gray-400">
                        {!! nl2br(e(setting('website.modern.websiteFooterBrief', ''))) !!}
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Services</h4>
                    <ul class="space-y-2 text-gray-400">
                        @if ($foodModule)
                            <li>
                                <a href="#" class="hover:text-white transition-colors">
                                    {{ $foodModule->name }}
                                </a>
                            </li>
                        @endif
                        @if ($groceryModule)
                            <li>
                                <a href="#" class="hover:text-white transition-colors">
                                    {{ $groceryModule->name }}
                                </a>
                            </li>
                        @endif
                        @if ($taxiModule)
                            <li>
                                <a href="#" class="hover:text-white transition-colors">
                                    {{ $taxiModule->name }}
                                </a>
                            </li>
                        @endif
                        @if ($parcelModule)
                            <li>
                                <a href="#" class="hover:text-white transition-colors">
                                    {{ $parcelModule->name }}
                                </a>
                            </li>
                        @endif
                        @if ($serviceModule)
                            <li>
                                <a href="#" class="hover:text-white transition-colors">
                                    {{ $serviceModule->name }}
                                </a>
                            </li>
                        @endif
                        @if ($pharmacyModule)
                            <li>
                                <a href="#" class="hover:text-white transition-colors">
                                    {{ $pharmacyModule->name }}
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        {{-- <li><a href="#" class="hover:text-white transition-colors">About</a></li> --}}
                        {{-- <li><a href="#" class="hover:text-white transition-colors">Careers</a></li> --}}
                        {{-- <li><a href="#" class="hover:text-white transition-colors">Partner</a></li> --}}
                        <li>
                            <a href="{{ route('register.driver') }}" class="hover:text-white transition-colors">
                                {{ __('Driver Sign-Up') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register.vendor') }}" class="hover:text-white transition-colors">
                                {{ __('Store/Vendor Sign-Up') }}
                            </a>
                        </li>
                        <hr class="my-2 text-theme w-2/12" />
                        {{--  --}}
                        <li>
                            <a href="{{ route('contact') }}" class="hover:text-white transition-colors">
                                {{ __('Support') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('terms') }}" class="hover:text-white transition-colors">
                                {{ __('Terms of Service') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('privacy') }}" class="hover:text-white transition-colors">
                                {{ __('Privacy Policy') }}
                            </a>
                        </li>

                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Connect</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>
                            <a href="{{ setting('website.modern.social.fbLink', '') }}"
                                class="hover:text-white transition-colors">Facebook
                            </a>
                        </li>
                        <li>
                            <a href="{{ setting('website.modern.social.twLink', '') }}"
                                class="hover:text-white transition-colors">Twitter
                            </a>
                        </li>
                        <li>
                            <a href="{{ setting('website.modern.social.igLink', '') }}"
                                class="hover:text-white transition-colors">Instagram
                            </a>
                        </li>
                        <li>
                            <a href="{{ setting('social.liLink', '') }}"
                                class="hover:text-white transition-colors">LinkedIn
                            </a>
                        </li>
                        <li>
                            <a href="{{ setting('website.modern.social.yuLink', '') }}"
                                class="hover:text-white transition-colors">
                                Youtube
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>
                    &copy; {{ date('Y') }} {{ $appName }}.
                    {{ __('All rights reserved') }}. | <a href="{{ route('privacy') }}">{{ __('Privacy Policy') }}</a> |
                    <a href="{{ route('terms') }}">{{ __('Terms of Service') }}</a>
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to navbar
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('nav');
            if (window.scrollY > 50) {
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
            } else {
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
            }
        });

        // Service card hover effects
        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
@endsection
