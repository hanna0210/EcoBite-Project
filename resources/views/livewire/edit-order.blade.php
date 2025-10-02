@php
    $pageTitle = __('Edit Order') . ' #';
    if ($selectedModel != null) {
        $pageTitle .= $selectedModel->code;
    }
    $pageTitle .= ' ';
    $pageTitle .= __('Products');

@endphp
@section('title', $pageTitle)
<div>
    <div class="bg-white px-8 pt-4 pb-8 rounded shadow">
        <x-baseview title="{{ $pageTitle }}">
            <livewire:component.autocomplete-input title="{{ __('Product') }}" column="name" model="Product"
                emitFunction="autocompleteProductSelected" updateQueryClauseName="productQueryClasueUpdate"
                :clear="true" :queryClause="$productSearchClause" onclearCalled="clearAutocompleteFieldsEvent" />
            <table class="w-full p-2 mt-5 border rounded-sm">
                <thead>
                    <tr>
                        <th class="text-left  p-2 bg-gray-300 border-b">S/N</th>
                        <th class="text-left w-3/12 p-2 bg-gray-300 border-b">Name</th>
                        <th class="text-left w-4/12 p-2 bg-gray-300 border-b">Options</th>
                        <th class="text-left w-2/12 p-2 bg-gray-300 border-b">QTY</th>
                        <th class="text-left w-2/12 p-2 bg-gray-300 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($editOrderProducts ?? [] as $key => $product)
                        <tr>
                            <td class="items-center px-2 py-1 border-b">
                                <span>{{ $key + 1 }}</span>
                            </td>
                            <td class="items-center w-2/12 px-2 py-1 border-b">
                                {{ $product->name }}
                            </td>
                            <td class="items-center w-4/12 px-2 py-1 border-b">
                                @foreach ($product->option_groups as $option_group)
                                    <div class="p-1 mb-2 border-b">
                                        <p class="text-sm font-medium">{{ $option_group->name }}</p>
                                        <p class="ml-2">
                                            @foreach ($option_group->options as $option)
                                                @php
                                                    if ($option_group->multiple) {
                                                        $optionId =
                                                            'editProductOptions.' .
                                                            $product->id .
                                                            '.' .
                                                            $option_group->id .
                                                            '.' .
                                                            $option->id;
                                                    } else {
                                                        $optionId =
                                                            'editProductOptions.' .
                                                            $product->id .
                                                            '.' .
                                                            $option_group->id;
                                                    }
                                                @endphp
                                                @if ($option_group->multiple)
                                                    <x-checkbox
                                                        title="{{ $option->name . ' (' . currencyFormat($option->price) . ')' }}"
                                                        name="{{ $optionId }}" :defer="false" />
                                                @else
                                                    <x-radio type="radio"
                                                        title="{{ $option->name . ' (' . currencyFormat($option->price) . ')' }}"
                                                        name="{{ $optionId }}" :defer="false"
                                                        value="{{ $option->id }}" />
                                                @endif
                                            @endforeach
                                        </p>
                                    </div>
                                @endforeach
                            </td>
                            <td class="items-center w-1/12 px-2 py-1 border-b">
                                <x-input name="editOrderProductsQtys.{{ $product->id }}" type="number" />
                            </td>
                            <td class="items-center w-2/12 px-2 py-1 border-b">
                                {{-- actions --}}
                                <x-buttons.plain wireClick="$emit('removeProductFromOrder', '{{ $product->id }}' )"
                                    bgColor="bg-red-500">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </x-buttons.plain>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- lo --}}
            <hr class="my-4" />
            <x-form-errors />
            <div class="ml-auto block md:flex gap-4 w-full md:w-8/12 lg:w-4/12 items-end justify-end">
                <div class="w-full md:w-6/12">
                    <x-buttons.primary title="{{ __('Save') }}" wireClick="updateOrderProducts">
                        <x-heroicon-o-check class="mr-2 w-4 h-4" />
                    </x-buttons.primary>
                </div>
                @if (
                    $selectedModel->vendor->vendor_type->slug == 'pharmacy' &&
                        !in_array($selectedModel->payment_status, ['request', 'failed', 'cancelled', 'successful']))
                    <div class="w-full md:w-6/12">
                        <x-buttons.primary title="{{ __('Request Payment') }}" wireClick="requestPayment">
                            <x-heroicon-o-credit-card class="mr-2 w-4 h-4" />
                        </x-buttons.primary>
                    </div>
                @endif
            </div>
        </x-baseview>
    </div>
    <x-page-loader target="requestPayment" />
    <x-page-loader target="updateOrderProducts" />
</div>
