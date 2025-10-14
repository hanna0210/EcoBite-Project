<?php

namespace App\Http\Livewire;

use App\Models\Banner;
use App\Models\DeliveryZone;
use App\Models\VendorType;
use Exception;
use Illuminate\Support\Facades\DB;

class BannerLivewire extends BaseLivewireComponent
{

    //
    public $model = Banner::class;

    //
    public $link;
    public $vendor_id;
    public $category_id;
    public $product_id;
    public $isActive;
    public $featured;
    public $type;
    public $types = ["link", "category", "vendor", "product"];
    public $vendor_type_id;
    public $deliveryZonesIDs = [];


    //getlisteners
    public function getListeners()
    {
        return $this->listeners + [
            "vendor_idUpdated" => "autocompleteVendorSelected",
            "product_idUpdated" => "autocompleteProductSelected",
            "category_idUpdated" => "autocompleteCategorySelected",
            "deliveryZonesChange" => "deliveryZonesChange",
        ];
    }


    public function render()
    {
        return view('livewire.banners');
    }


    //
    public function getVendorTypesProperty()
    {
        $mVendorTypes = VendorType::active()->get();
        //prepend the first option
        $topOptions = [];
        $topOptions[] = [
            "id" => "",
            "name" => __("Home"),
        ];
        $types = $mVendorTypes->toArray();
        return array_merge($topOptions, $types);
    }

    public function getZonesProperty()
    {
        $vendors = DeliveryZone::active()->get();
        return $vendors;
    }

    public function showCreateModal()
    {
        parent::showCreateModal();
        $this->updateDeliveryZoneSelector();
    }

    public function showEditModal()
    {
        parent::showEditModal();
    }


    //select actions
    public function autocompleteVendorSelected($selection)
    {
        $this->vendor_id = $selection["value"];
    }
    public function autocompleteProductSelected($selection)
    {
        $this->product_id = $selection["value"];
    }
    public function autocompleteCategorySelected($selection)
    {
        $this->category_id = $selection["value"];
    }

    //on type change rest the _id fields
    public function updatedType($value)
    {
        $this->reset(["vendor_id", "category_id", "product_id"]);
        
        // If changing to link type, ensure link field is ready
        if ($value === 'link') {
            // Don't reset link field when changing to link type
            $this->resetValidation('link');
        } else {
            // Reset link field when changing away from link type
            $this->link = null;
            $this->resetValidation('link');
        }
    }

    // Clear link validation errors when type is not 'link'
    public function updatedLink()
    {
        if ($this->type !== 'link') {
            $this->link = null;
            $this->resetValidation('link');
        } else {
            // If type is link but field is empty, clear validation errors temporarily
            if (empty(trim($this->link ?? ''))) {
                $this->resetValidation('link');
            }
        }
    }



    public function save()
    {
        // Trim and clean link field
        $this->link = trim($this->link ?? '');
        
        // If type is 'link' but link is empty, change type to category to avoid validation error
        if ($this->type === 'link' && empty($this->link)) {
            $this->type = 'category';
            $this->link = null;
        }
        
        // Clear link field if type is not 'link'
        if ($this->type !== 'link') {
            $this->link = null;
        }

        //validate - NO LINK VALIDATION for now
        $this->validate([
            //required type
            "type" => "required",
            //depending on the type: category
            "category_id" => "required_if:type,category|nullable|exists:categories,id",
            //depending on the type: vendor
            "vendor_id" => "required_if:type,vendor|nullable|exists:vendors,id",
            //depending on the type: product
            "product_id" => "required_if:type,product|nullable|exists:products,id",
            "photo" => "required|image|max:" . setting("filelimit.banner", 2048) . "",
        ]);

        try {

            DB::beginTransaction();
            $model = new Banner();
            $model->vendor_type_id = empty($this->vendor_type_id) ? null : $this->vendor_type_id;
            $model->category_id = $this->category_id ?? null;
            $model->vendor_id = $this->vendor_id ?? null;
            $model->product_id = $this->product_id ?? null;
            $model->link = $this->link ?? '';
            $model->is_active = $this->isActive ?? false;
            $model->featured = $this->featured ?? false;
            $model->save();
            $model->delivery_zones()->sync($this->deliveryZonesIDs);
            if ($this->photo) {

                $model->clearMediaCollection();
                $model->addMedia($this->photo->getRealPath())->toMediaCollection();
                $this->photo = null;
            }

            DB::commit();

            $this->dismissModal();
            $this->reset();
            $this->showSuccessAlert(__("Banner created successfully!"));
            $this->emit('refreshTable');
        } catch (Exception $error) {
            DB::rollback();
            $this->showErrorAlert($error->getMessage() ?? __("Banner creation failed!"));
        }
    }

    public function initiateEdit($id)
    {
        $this->selectedModel = $this->model::find($id);
        $this->vendor_type_id = $this->selectedModel->vendor_type_id ?? "";
        $this->category_id = $this->selectedModel->category_id;
        $this->product_id = $this->selectedModel->product_id;
        $this->vendor_id = $this->selectedModel->vendor_id;
        $this->link = $this->selectedModel->link;
        $this->isActive = $this->selectedModel->is_active;
        $this->featured = $this->selectedModel->featured;

        $this->deliveryZonesIDs = $this->selectedModel->delivery_zones()->pluck('delivery_zone_id');
        $this->updateDeliveryZoneSelector();
        //update selects
        if ($this->vendor_id != null) {
            $this->emit("vendor_id_Loaded", $this->vendor_id);
        }
        if ($this->product_id != null) {
            $this->emit("product_id_Loaded", $this->product_id);
        }
        if ($this->category_id != null) {
            $this->emit("category_id_Loaded", $this->category_id);
        }
        
        // Determine type based on what's actually set, with better logic
        if ($this->selectedModel->category_id) {
            $this->type = "category";
        } elseif ($this->selectedModel->vendor_id) {
            $this->type = "vendor";
        } elseif ($this->selectedModel->product_id) {
            $this->type = "product";
        } else {
            // Only set as link if there's actually a valid link
            $this->type = (!empty($this->selectedModel->link)) ? "link" : "category"; // Default to category if no link
        }
        
        $this->emit('showEditModal');
    }

    public function update()
    {
        // Trim and clean link field
        $this->link = trim($this->link ?? '');
        
        // If type is 'link' but link is empty, change type to category to avoid validation error
        if ($this->type === 'link' && empty($this->link)) {
            $this->type = 'category';
            $this->link = null;
        }
        
        // Clear link field if type is not 'link'
        if ($this->type !== 'link') {
            $this->link = null;
        }

        //validate - NO LINK VALIDATION for now
        $this->validate([
            //required type
            "type" => "required",
            //depending on the type: category
            "category_id" => "required_if:type,category|nullable|exists:categories,id",
            //depending on the type: vendor
            "vendor_id" => "required_if:type,vendor|nullable|exists:vendors,id",
            //depending on the type: product
            "product_id" => "required_if:type,product|nullable|exists:products,id",
            //photo
            "photo" => "sometimes|nullable|image|max:" . setting("filelimit.banner", 2048) . "",
        ]);

        try {

            DB::beginTransaction();
            $model = $this->selectedModel;
            $model->vendor_type_id = empty($this->vendor_type_id) ? null : $this->vendor_type_id;
            $model->category_id = $this->category_id ?? null;
            $model->vendor_id = $this->vendor_id ?? null;
            $model->product_id = $this->product_id ?? null;
            $model->link = $this->link ?? '';
            $model->is_active = $this->isActive ?? false;
            $model->featured = $this->featured;
            $model->save();
            $model->delivery_zones()->sync($this->deliveryZonesIDs);

            if ($this->photo) {

                $model->clearMediaCollection();
                $model->addMedia($this->photo->getRealPath())->toMediaCollection();
                $this->photo = null;
            }

            DB::commit();

            $this->dismissModal();
            $this->reset();
            $this->showSuccessAlert(__("Banner updated successfully!"));
            $this->emit('refreshTable');
        } catch (Exception $error) {
            DB::rollback();
            $this->showErrorAlert($error->getMessage() ?? __("Banner updated failed!"));
        }
    }




    //misc.
    public function updateDeliveryZoneSelector()
    {
        $deliveryZones = $this->zones;
        if ($this->showCreate) {
            $this->showSelect2("#deliveryZonesSelect2", $this->deliveryZonesIDs, "deliveryZonesChange", $deliveryZones);
        } else {
            $this->showSelect2("#editDeliveryZonesSelect2", $this->deliveryZonesIDs, "deliveryZonesChange", $deliveryZones);
        }
    }

    public function deliveryZonesChange($data)
    {
        $this->deliveryZonesIDs = $data;
    }

    // Get the current banner photo for preview
    public function getCurrentPhotoProperty()
    {
        return $this->selectedModel?->photo ?? '';
    }
}