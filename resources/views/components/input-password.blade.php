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
            <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" x-show="showPassword" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" x-show="!showPassword" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 11-4.243-4.243m4.242 4.242L9.88 9.88" />
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
