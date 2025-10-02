<div class="block {{ empty($title ?? '') ? '' : 'mt-4' }}">
    @if (!empty($title ?? ''))
        <label class="block text-sm text-gray-700 mb-2">
            {{ $title }}
        </label>
    @endif
    <div x-data="{ showPassword: false }" class="relative">
        <input
            {{ $attributes->merge(['class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors input-focus']) }}
            placeholder="{{ $placeholder ?? '********' }}" :type="showPassword ? 'text' : 'password'"
            id='{{ $name ?? '' }}'
            @if ($defer ?? true) wire:model.defer='{{ $name ?? '' }}' @else wire:model='{{ $name ?? '' }}' @endif
            @if ($disable ?? false) disabled @endif />

        <button type="button" @click="showPassword = !showPassword"
            class="absolute inset-y-0 right-0 pr-3 flex items-center">
            <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" x-show="showPassword" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" x-show="!showPassword" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
            </svg>
        </button>
    </div>
    @if (!empty($hint))
        <span class="text-xs italic text-gray-700">{{ $hint ?? '' }}</span>
    @endif
    @error($name ?? '')
        <span class="mt-1 text-xs text-red-700">{{ $message }}</span>
    @enderror

    @isset($type)

        @if ($type != null && $type == 'password')
            @push('scripts')
                <script>
                    function togglePassword() {
                        const input = document.getElementById("{{ $name }}");
                        input.type = input.type === "password" ? "text" : "password";
                    }
                </script>
            @endpush
        @endif
    @endisset
</div>
