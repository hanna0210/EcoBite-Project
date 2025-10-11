@section('title', 'Login for Users page')
<div>
    <div class="min-h-screen bg-white">
        <!-- Top Blue Header Bar -->
        <div class="w-full bg-blue-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <button onclick="history.back()" class="mr-4 text-white hover:text-blue-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <span class="text-white font-medium text-lg">Glover</span>
                </div>
                <div class="flex items-center space-x-4">
                    <select class="bg-blue-700 text-white border-none rounded px-3 py-1 text-sm">
                        <option>Click to set location</option>
                    </select>
                    <select class="bg-blue-700 text-white border-none rounded px-3 py-1 text-sm">
                        <option>English</option>
                    </select>
                    <button class="text-white hover:text-blue-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-12"></path>
                        </svg>
                    </button>
                    <button class="text-white hover:text-blue-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex min-h-screen">
            <!-- Left Section -->
            <div class="flex-1 flex items-center justify-center bg-white">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-800 mb-8">Login for Users page</h1>
                </div>
            </div>

            <!-- Right Section - Login Form -->
            <div class="flex-1 flex items-center justify-center bg-gray-50">
                <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
                    <!-- Back Button -->
                    <div class="mb-6">
                        <button onclick="history.back()" class="flex items-center text-gray-600 hover:text-gray-800 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span class="text-sm">Back button</span>
                        </button>
                    </div>

                    <!-- Login Form -->
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Login</h2>
                        <p class="text-gray-600">
                            Don't have an account? 
                            <a href="#" class="text-blue-600 hover:underline">Register</a>
                        </p>
                    </div>

                    <form wire:submit.prevent="login">
                        @csrf
                        
                        <!-- Email Input -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input 
                                type="email" 
                                id="email"
                                wire:model="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                placeholder="Enter your email"
                                required
                            >
                        </div>

                        <!-- Password Input -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password"
                                    wire:model="password"
                                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    placeholder="Enter your password"
                                    required
                                >
                                <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Forgot Password Link -->
                        <div class="mb-6 text-right">
                            <a href="#" class="text-blue-600 hover:underline text-sm">Forgot your password?</a>
                        </div>

                        <!-- Login Button -->
                        <button 
                            type="submit"
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            Login
                        </button>
                    </form>

                    @if (!App::environment('production'))
                        <hr class="my-6" />
                        <div class="p-4 mb-4 bg-green-100 border border-green-300 rounded-lg cursor-pointer hover:shadow-md transition-shadow"
                            wire:click="loadAccount(0)">
                            <p class="font-medium text-green-800">Client Account</p>
                            <p class="text-sm text-green-700">Email: client@demo.com | Password: password</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bottom Blue Footer Bar -->
        <div class="w-full bg-blue-600 px-6 py-4">
            <div class="flex items-center justify-center">
                <p class="text-white text-sm">© {{ date('Y') }} Glover. All rights reserved.</p>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <x-loading />
</div>
