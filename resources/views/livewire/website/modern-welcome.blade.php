@extends('layouts.guest')

@section('title', 'Glover')

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

        .gradient-bg {
            background: linear-gradient(135deg, {{ $colors['shades'][500] }} 0%, {{ $colors['shades'][900] }} 100%);
        }
    </style>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full backdrop-blur-md z-50 border-b border-gray-200" style="background-color:#06ba69;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo2.jpg') }}" alt="{{ $appName }}" class="h-10" />
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#services"
                        class="text-white hover:text-primary-600 transition-colors">{{ __('Services') }}</a>
                    <a href="#how-it-works"
                        class="text-white hover:text-primary-600 transition-colors">{{ __('How It Works') }}</a>
                    <a href="#download"
                        class="text-white hover:text-primary-600 transition-colors">{{ __('Download') }}</a>
                    <a href="{{ route('login') }}"
                        class="bg-primary-600 text-white px-6 py-2 rounded-full hover:bg-primary-700 transition-all pulse-glow">
                        {{ __('Admin/Store Login') }}
                    </a>
                    <a href="{{ route('users.login') }}"
                        class="bg-primary-600 text-white px-6 py-2 rounded-full hover:bg-primary-700 transition-all pulse-glow">
                        {{ __('Users') }}
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

        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between gap-12 items-center">
                <div class="flex flex-col gap-12" style="width: 30%;">
                    <!-- Left Content -->
                    <div class="text-center lg:text-left">
                        <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
                            {!! setting('website.modern.websiteHeaderTitle', '') !!}
                        </h1>
                        <p class="text-xl md:text-2xl text-white/90 mb-8">
                            {!! nl2br(setting('website.modern.websiteHeaderSubtitle', '')) !!}
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="#download"
                                class="bg-white text-primary-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg">
                                📱 {{ __('Download App') }}
                            </a>
                        </div>
                    </div>
    
                    <!-- Right Image Showcase -->
                    <div class="relative flex justify-center ">
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
                <div class="flex flex-col gap-12" style="width: 60%;">
                    <div class="mt-20">
                        <div class="mt-20 relative w-full mx-auto" x-data="{ slide: 0, slides: [
                            'https://customers.edentech.online/storage/10475/Glover-fresh-preview---2024.png',
                            'https://customers.edentech.online/storage/10479/d020d06e84d069030c61f6bc402ed960.png',
                            'https://customers.edentech.online/storage/10478/Meetup.png'
                        ] }" x-init="setInterval(() => { slide = (slide + 1) % slides.length }, 4000)">
                            <div id="welcome-slider" class="overflow-hidden rounded-2xl shadow-lg relative group" style="height: 500px;">
                                <div class="flex transition-transform duration-700 ease-in-out h-full" 
                                    :style="`transform: translateX(-${slide * 100}%)`">
                                    <template x-for="(img, idx) in slides" :key="idx">
                                        <img :src="img" alt="Slide" 
                                            class="w-full h-full flex-shrink-0 object-cover">
                                    </template>
                                </div>
                                
                                <!-- Left Arrow -->
                                <button @click="slide = slide === 0 ? slides.length - 1 : slide - 1"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow-lg transition-all duration-300 opacity-0 group-hover:opacity-100 z-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                
                                <!-- Right Arrow -->
                                <button @click="slide = (slide + 1) % slides.length"
                                    class="absolute top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-2 shadow-lg transition-all duration-300 opacity-0 group-hover:opacity-100 z-10"
                                    style="right: 16px; left: auto;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex justify-center mt-3 space-x-2">
                                <template x-for="idx in [0,1,2]" :key="idx">
                                    <button class="w-3 h-3 rounded-full transition-colors duration-300"
                                        :class="slide === idx ? 'bg-primary-600' : 'bg-gray-300'"
                                        @click="slide = idx"></button>
                                </template>
                            </div>
                        </div>
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
    <section id="download" class="py-20 relative overflow-hidden" style="background-color:#06ba69;">
        <div class="absolute inset-0" ></div>
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                {{ __('Ready to Experience') }} <span style="color:#061a0e;">{{ $appName }}</span>?
            </h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                {{ __("Join thousands of satisfied customers who've made :app_name their go-to for everything local.", ['app_name' => $appName]) }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                <a href="https://play.google.com/store/apps/details?id={{ env('dynamic_link.android') }}"
                    class="bg-black text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-800 transition-all transform hover:scale-105 shadow-lg space-x-2 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.523 15.3414c-.5511 0-.9993-.4486-.9993-.9997s.4482-.9993.9993-.9993c.5511 0 .9993.4482.9993.9993.0001.5511-.4482.9997-.9993.9997m-11.046 0c-.5511 0-.9993-.4486-.9993-.9997s.4482-.9993.9993-.9993c.5511 0 .9993.4482.9993.9993 0 .5511-.4482.9997-.9993.9997m11.4045-6.02l1.9973-3.4592a.416.416 0 00-.1521-.5676.416.416 0 00-.5676.1521l-2.0223 3.503C15.5902 8.2439 13.8533 7.6808 12 7.6808s-3.5902.5631-5.1367 1.6649L4.841 5.8427a.416.416 0 00-.5676-.1521.416.416 0 00-.1521.5676l1.9973 3.4592C2.6889 11.1867.3432 14.6589 0 18.761h24c-.3432-4.1021-2.6889-7.5743-6.1185-9.4396"/>
                    </svg>
                    <p>{{ __('Get it on Google Play') }} </p>
                </a>
                <a href="https://apps.apple.com/app/{{ env('dynamic_link.ios_id') }}"
                    class="bg-white text-primary-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg space-x-2 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                    </svg>
                    <p>{{ __('Download on App Store') }} </p>

                </a>
            </div>
            <p class="text-white/80">
                {{ __('Available on') }} Android {{ __('and') }} iOS •
                {{ __('Free Download') }}</p>
        </div>
    </section>
    
    <!-- Banner Section - Partner Logos -->
    @php
        $bannerTitle = setting('website.modern.bannerTitle', 'Find Your Favorite Products with Our Partners');
        $showBanner = setting('website.modern.showBanner', true);
        
        // Partner logos from vendors folder
        $partnerLogos = [
            ['name' => 'Walmart', 'logo' => asset('images/vendors/walmart.png')],
            ['name' => 'Target', 'logo' => asset('images/vendors/target.png')],
            ['name' => 'Burger King', 'logo' => asset('images/vendors/burgerking.png')],
            ['name' => 'KFC', 'logo' => asset('images/vendors/kfc.png')],
            ['name' => 'McDonald\'s', 'logo' => asset('images/vendors/mcdonalds.png')],
            ['name' => 'Subway', 'logo' => asset('images/vendors/subway.png')],
            ['name' => 'CVS', 'logo' => asset('images/vendors/cvs.png')],
            ['name' => 'Bloom Bask', 'logo' => asset('images/vendors/bloombask.png')],
            ['name' => 'Auto Revive Garage', 'logo' => asset('images/vendors/autorevivegarage.png')],
            ['name' => 'Byte Medic', 'logo' => asset('images/vendors/bytemedic.png')],
            ['name' => 'Glow Grace Studio', 'logo' => asset('images/vendors/glowgracestudio.png')],
            ['name' => 'Handy Hive', 'logo' => asset('images/vendors/handyhive.png')],
            ['name' => 'Hype Lane', 'logo' => asset('images/vendors/hypelane.png')],
            ['name' => 'Plug & Play Installations', 'logo' => asset('images/vendors/plug&playinstallations.png')],
        ];
    @endphp
    
    @if($showBanner)
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Banner Header -->
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                    {{ $bannerTitle }}
                </h2>
                <div class="text-sm text-gray-600">
                    Banner
                </div>
            </div>
            
            <!-- Partner Logos Carousel -->
            <div class="relative" x-data="{ 
                currentIndex: 0,
                itemsPerView: 6,
                autoPlay: true,
                autoPlayInterval: null,
                totalItems: {{ count($partnerLogos) }},
                maxIndex: {{ ceil(count($partnerLogos) / 6) - 1 }},
                moveLeft() {
                    this.currentIndex = this.currentIndex === 0 ? this.maxIndex : this.currentIndex - 1;
                },
                moveRight() {
                    this.currentIndex = (this.currentIndex + 1) % (this.maxIndex + 1);
                }
            }" x-init="
                if (autoPlay) {
                    autoPlayInterval = setInterval(() => {
                        this.moveRight();
                    }, 4000);
                }
            " x-on:destroy="if (autoPlayInterval) clearInterval(autoPlayInterval)">
                
                <!-- Carousel Container -->
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-in-out" 
                         :style="`transform: translateX(-${currentIndex * (100 / itemsPerView)}%)`">
                        @foreach($partnerLogos as $index => $partner)
                            <div class="flex-shrink-0 px-4" style="width: {{ 100 / 6 }}%">
                                <div class="flex items-center justify-center py-6">
                                    <img src="{{ $partner['logo'] }}" alt="{{ $partner['name'] }}" 
                                         class="h-12 w-auto object-contain opacity-60 hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Left Arrow -->
                <button @click="moveLeft()"
                        class="absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow-lg rounded-full p-3 hover:bg-gray-50 transition-colors z-10 border border-gray-200">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <!-- Right Arrow -->
                <button @click="moveRight()"
                        class="absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow-lg rounded-full p-3 hover:bg-gray-50 transition-colors z-10 border border-gray-200">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <!-- Debug Info (remove in production) -->
                <div class="text-xs text-gray-400 mt-2 text-center" x-text="`Slide: ${currentIndex + 1}/${maxIndex + 1}`"></div>
            </div>
        </div>
    </section>
    @endif
     
    <!-- Footer -->
    <footer class="text-white py-12" style="background-color:#061a0e;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="text-2xl font-bold mb-4">{{ $appName }}</div>
                    <p class="text-gray-400">
                        {!! nl2br(e(setting('website.modern.websiteFooterBrief', ''))) !!}
                    </p>
                    
                    <!-- Newsletter Subscription -->
                    <div class="mt-6">
                        <h4 class="font-semibold mb-3">{{ __('Subscribe to our Newsletter') }}</h4>
                        <p class="text-gray-400 text-sm mb-3">{{ __('Get updates on new features and special offers') }}</p>
                        <form class="flex flex-col gap-3" id="newsletter-form">
                            <input 
                                type="email" 
                                name="email" 
                                placeholder="{{ __('Enter your email') }}" 
                                required
                                class="w-full px-4 py-2.5 rounded-lg bg-white/10 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                            />
                            <button 
                                type="submit"
                                class="w-full px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary-500"
                            >
                                {{ __('Subscribe') }}
                            </button>
                            <p class="text-xs text-gray-500">{{ __('We respect your privacy. Unsubscribe at any time.') }}</p>
                        </form>
                    </div>
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
                navbar.style.backgroundColor = 'rgba(6, 186, 105, 0.95)';
            } else {
                navbar.style.backgroundColor = 'rgba(6, 186, 105, 0.8)';
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

        // Newsletter form handler (ready for emailer extension integration)
        document.getElementById('newsletter-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[name="email"]').value;
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.textContent;
            
            // UI feedback
            button.textContent = '{{ __("Subscribing...") }}';
            button.disabled = true;
            
            // TODO: Connect to emailer extension here
            // For now, just show success message
            setTimeout(() => {
                button.textContent = '{{ __("Subscribed!") }}';
                button.classList.add('bg-green-600');
                button.classList.remove('bg-primary-600');
                
                setTimeout(() => {
                    this.reset();
                    button.textContent = originalText;
                    button.disabled = false;
                    button.classList.remove('bg-green-600');
                    button.classList.add('bg-primary-600');
                }, 2000);
            }, 1000);
        });
    </script>
@endsection
