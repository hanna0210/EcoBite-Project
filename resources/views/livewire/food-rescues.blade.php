@section('title', __('Food Rescues'))
<div>

    <x-baseview title="{{ __('Food Rescues') }}" :showNew="true">
        <livewire:tables.food-rescue-table />
    </x-baseview>

    {{-- Create form --}}
    <div x-data="{ open: @entangle('showCreate') }">
        <x-modal-lg confirmText="{{ __('Save') }}" action="save" :clickAway="false">
            <p class="text-xl font-semibold">{{ __('Create Food Rescue Offer') }}</p>
            {{-- Show all errors --}}
            <x-form-errors />
            
            {{-- Vendor --}}
            <div class="{{ auth()->user()->hasRole('manager') ?? false ? 'block' : 'hidden' }}">
                <x-details.item title="{{ __('Vendor') }}" text="{{ auth()->user()->vendor->name ?? '' }}" />
            </div>
            <div class="{{ !(auth()->user()->hasRole('manager') ?? false) ? 'block' : 'hidden' }}">
                <x-select :options="$this->vendors ?? []" name="vendor_id" title="{{ __('Vendor') }}" :noPreSelect="true"
                    :defer="false" />
            </div>

            {{-- Basic Information --}}
            <x-input title="{{ __('Title') }}" name="title" placeholder="{{ __('e.g., Fresh Bakery Items - End of Day Special') }}" />

            <x-input.filepond wire:model="photos" title="{{ __('Photo(s)') }}"
                acceptedFileTypes="['image/png', 'image/jpeg', 'image/jpg']" allowImagePreview="true"
                imagePreviewMaxHeight="80" grid="3" multiple="true" allowFileSizeValidation="true"
                maxFileSize="{{ setting('filelimit.product_image_size', 200) }}kb" />
            <x-input-error message="{{ $errors->first('photos') }}" />

            <x-input.summernote name="description" title="{{ __('Description') }}" id="newContent" 
                placeholder="{{ __('Describe what items are included, condition, and any other relevant details...') }}" />

            {{-- Pricing --}}
            <div class="grid grid-cols-2 gap-4">
                <x-input title="{{ __('Original Price') }}" name="original_price" type="number" step="0.01" min="0" />
                <x-input title="{{ __('Rescue Price') }}" name="rescue_price" type="number" step="0.01" min="0" />
            </div>
            
            {{-- Show discount percentage if both prices are set --}}
            @if($original_price > 0 && $rescue_price >= 0)
                <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-700">
                        <strong>{{ __('Discount') }}:</strong> {{ $this->calculateDiscountPercentage() }}% {{ __('off') }}
                    </p>
                </div>
            @endif

            {{-- Quantity --}}
            <div class="grid grid-cols-2 gap-4">
                <x-input title="{{ __('Available Quantity') }}" name="available_quantity" type="number" min="1" />
                <x-input title="{{ __('Total Quantity') }}" name="total_quantity" type="number" min="1" />
            </div>

            {{-- Availability Time --}}
            <div class="grid grid-cols-2 gap-4">
                <x-input title="{{ __('Available From') }}" name="available_from" type="datetime-local" />
                <x-input title="{{ __('Available Until') }}" name="available_until" type="datetime-local" />
            </div>

            {{-- Tags --}}
            <div>
                <x-label title="{{ __('Tags') }}" />
                <div class="grid grid-cols-3 gap-2 mt-2">
                    @foreach($availableTags as $tag)
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="tags" value="{{ $tag }}" class="mr-2">
                            <span class="text-sm">{{ $tag }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Pickup Instructions --}}
            <x-textarea title="{{ __('Pickup Instructions') }}" name="pickup_instructions" 
                placeholder="{{ __('Special instructions for customers picking up this rescue offer...') }}" />

            {{-- Status --}}
            <x-checkbox title="{{ __('Active') }}" name="isActive" 
                description="{{ __('Make this rescue offer visible to customers') }}" />
        </x-modal-lg>
    </div>

    {{-- Edit form --}}
    <div x-data="{ open: @entangle('showEdit') }">
        <x-modal-lg confirmText="{{ __('Update') }}" action="update" :clickAway="false">
            <p class="text-xl font-semibold">{{ __('Update Food Rescue Offer') }}</p>
            {{-- Show all errors --}}
            <x-form-errors />
            
            {{-- Vendor --}}
            <div class="{{ auth()->user()->hasRole('manager') ?? false ? 'block' : 'hidden' }}">
                <x-details.item title="{{ __('Vendor') }}" text="{{ auth()->user()->vendor->name ?? '' }}" />
            </div>
            <div class="{{ !(auth()->user()->hasRole('manager') ?? false) ? 'block' : 'hidden' }}">
                <x-select :options="$this->vendors ?? []" name="vendor_id" title="{{ __('Vendor') }}" :noPreSelect="true"
                    :defer="false" />
            </div>

            {{-- Basic Information --}}
            <x-input title="{{ __('Title') }}" name="title" placeholder="{{ __('e.g., Fresh Bakery Items - End of Day Special') }}" />

            <x-input.filepond wire:model="photos" title="{{ __('Photo(s)') }}" id="editFoodRescueInput"
                allowAddFileEvent="true" acceptedFileTypes="['image/png', 'image/jpeg', 'image/jpg']"
                allowImagePreview multiple="true" allowFileSizeValidation imagePreviewMaxHeight="80"
                maxFileSize="{{ setting('filelimit.product_image_size', 200) }}kb" />

            <x-input.summernote name="description" title="{{ __('Description') }}" id="editContent" 
                placeholder="{{ __('Describe what items are included, condition, and any other relevant details...') }}" />

            {{-- Pricing --}}
            <div class="grid grid-cols-2 gap-4">
                <x-input title="{{ __('Original Price') }}" name="original_price" type="number" step="0.01" min="0" />
                <x-input title="{{ __('Rescue Price') }}" name="rescue_price" type="number" step="0.01" min="0" />
            </div>
            
            {{-- Show discount percentage if both prices are set --}}
            @if($original_price > 0 && $rescue_price >= 0)
                <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-700">
                        <strong>{{ __('Discount') }}:</strong> {{ $this->calculateDiscountPercentage() }}% {{ __('off') }}
                    </p>
                </div>
            @endif

            {{-- Quantity --}}
            <div class="grid grid-cols-2 gap-4">
                <x-input title="{{ __('Available Quantity') }}" name="available_quantity" type="number" min="1" />
                <x-input title="{{ __('Total Quantity') }}" name="total_quantity" type="number" min="1" />
            </div>

            {{-- Availability Time --}}
            <div class="grid grid-cols-2 gap-4">
                <x-input title="{{ __('Available From') }}" name="available_from" type="datetime-local" />
                <x-input title="{{ __('Available Until') }}" name="available_until" type="datetime-local" />
            </div>

            {{-- Tags --}}
            <div>
                <x-label title="{{ __('Tags') }}" />
                <div class="grid grid-cols-3 gap-2 mt-2">
                    @foreach($availableTags as $tag)
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="tags" value="{{ $tag }}" class="mr-2">
                            <span class="text-sm">{{ $tag }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Pickup Instructions --}}
            <x-textarea title="{{ __('Pickup Instructions') }}" name="pickup_instructions" 
                placeholder="{{ __('Special instructions for customers picking up this rescue offer...') }}" />

            {{-- Status --}}
            <x-checkbox title="{{ __('Active') }}" name="isActive" 
                description="{{ __('Make this rescue offer visible to customers') }}" />
        </x-modal-lg>
    </div>

    {{-- Details modal --}}
    <div x-data="{ open: @entangle('showDetails') }">
        <x-modal-lg>
            <p class="text-xl font-semibold">{{ $selectedModel->title ?? '' }} {{ __('Details') }}</p>
            
            @if($selectedModel)
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-details.item title="{{ __('Title') }}" text="{{ $selectedModel->title ?? '' }}" />
                    <x-details.item title="{{ __('Vendor') }}" text="{{ $selectedModel->vendor->name ?? '' }}" />
                </div>
                
                <x-details.item title="{{ __('Description') }}" text="">
                    {!! $selectedModel->description ?? '' !!}
                </x-details.item>
                
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-details.item title="{{ __('Original Price') }}" 
                        text="{{ currencyFormat($selectedModel->original_price ?? '') }}" />
                    <x-details.item title="{{ __('Rescue Price') }}" 
                        text="{{ currencyFormat($selectedModel->rescue_price ?? '') }}" />
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-details.item title="{{ __('Available Quantity') }}" text="{{ $selectedModel->available_quantity ?? '' }}" />
                    <x-details.item title="{{ __('Total Quantity') }}" text="{{ $selectedModel->total_quantity ?? '' }}" />
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-details.item title="{{ __('Available From') }}" 
                        text="{{ $selectedModel->available_from ? $selectedModel->available_from->format('M d, Y H:i') : 'Immediately' }}" />
                    <x-details.item title="{{ __('Available Until') }}" 
                        text="{{ $selectedModel->available_until ? $selectedModel->available_until->format('M d, Y H:i') : 'Until sold out' }}" />
                </div>

                @if($selectedModel->pickup_instructions)
                    <x-details.item title="{{ __('Pickup Instructions') }}" text="{{ $selectedModel->pickup_instructions }}" />
                @endif

                @if($selectedModel->tags && count($selectedModel->tags) > 0)
                    <x-details.item title="{{ __('Tags') }}" text="">
                        <div class="flex flex-wrap gap-2">
                            @foreach($selectedModel->tags as $tag)
                                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm text-gray-700">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </x-details.item>
                @endif

                <x-details.item title="{{ __('Photos') }}" text="">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach ($selectedModel->photos ?? [] as $photo)
                            <a href="{{ $photo }}" target="_blank"><img src="{{ $photo }}"
                                    class="w-24 h-24 mx-2 rounded-sm object-cover" /></a>
                        @endforeach
                    </div>
                </x-details.item>

                <div class="grid grid-cols-1 gap-4 pt-4 mt-4 border-t md:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <x-label title="{{ __('Status') }}" />
                        <x-table.active :model="$selectedModel" />
                    </div>
                    
                    <div>
                        <x-label title="{{ __('Discount') }}" />
                        <span class="text-green-600 font-semibold">{{ $selectedModel->discount_percentage }}% off</span>
                    </div>

                    <div>
                        <x-label title="{{ __('Availability') }}" />
                        @if($selectedModel->is_available)
                            <span class="text-green-600">{{ __('Available') }}</span>
                        @else
                            <span class="text-red-600">{{ __('Not Available') }}</span>
                        @endif
                    </div>
                </div>
            @endif
        </x-modal-lg>
    </div>

</div>
