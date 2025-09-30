<?php

namespace App\Http\Livewire;

use App\Models\FoodRescue;
use App\Models\Vendor;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FoodRescueLivewire extends BaseLivewireComponent
{
    // Model
    public $model = FoodRescue::class;

    // Properties
    public $title;
    public $description;
    public $original_price;
    public $rescue_price;
    public $available_quantity = 1;
    public $total_quantity = 1;
    public $available_from;
    public $available_until;
    public $vendor_id;
    public $isActive = 1;
    public $pickup_instructions;
    public $tags = [];
    public $photos = [];

    // Available tags for food rescues
    public $availableTags = [
        'Bakery', 'Fresh Produce', 'Dairy', 'Meat & Seafood', 
        'Prepared Meals', 'Snacks', 'Beverages', 'Frozen Foods',
        'Vegetarian', 'Vegan', 'Gluten-Free', 'Organic'
    ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'original_price' => 'required|numeric|min:0',
        'rescue_price' => 'required|numeric|min:0',
        'available_quantity' => 'required|integer|min:1',
        'total_quantity' => 'required|integer|min:1',
        'vendor_id' => 'required|exists:vendors,id',
        'available_from' => 'nullable|date',
        'available_until' => 'nullable|date|after:available_from',
        'pickup_instructions' => 'nullable|string',
        'tags' => 'nullable|array',
        'photos' => 'nullable|array',
    ];

    protected $messages = [
        'vendor_id.exists' => 'Invalid vendor selected',
        'rescue_price.min' => 'Rescue price must be greater than or equal to 0',
        'original_price.min' => 'Original price must be greater than or equal to 0',
        'available_until.after' => 'End time must be after start time',
    ];

    public function mount()
    {
        $user = User::find(Auth::id());

        if ($user->hasRole('manager')) {
            $this->vendor_id = Auth::user()->vendor_id;
        }
    }

    public function render()
    {
        return view('livewire.food-rescues');
    }

    public function getVendorsProperty()
    {
        $user = User::find(Auth::id());
        
        if ($user->hasRole('admin')) {
            return Vendor::active()->get();
        } else {
            return Vendor::active()->where('id', Auth::user()->vendor_id)->get();
        }
    }

    public function save()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                // Ensure total_quantity is at least as much as available_quantity
                if ($this->total_quantity < $this->available_quantity) {
                    $this->total_quantity = $this->available_quantity;
                }

                $foodRescue = new FoodRescue();
                $foodRescue->title = $this->title;
                $foodRescue->description = $this->description;
                $foodRescue->original_price = $this->original_price;
                $foodRescue->rescue_price = $this->rescue_price;
                $foodRescue->available_quantity = $this->available_quantity;
                $foodRescue->total_quantity = $this->total_quantity;
                $foodRescue->available_from = $this->available_from;
                $foodRescue->available_until = $this->available_until;
                $foodRescue->vendor_id = $this->vendor_id;
                $foodRescue->is_active = $this->isActive;
                $foodRescue->pickup_instructions = $this->pickup_instructions;
                $foodRescue->tags = $this->tags;
                $foodRescue->save();

                // Handle photo uploads
                if (!empty($this->photos)) {
                    foreach ($this->photos as $photo) {
                        $foodRescue->addMedia($photo->getRealPath())
                            ->toMediaCollection('default');
                    }
                }
            });

            $this->alert('success', '', __('Food Rescue created successfully!'));
            $this->reset();
            $this->showCreate = false;
            $this->emit('refreshView');
        } catch (Exception $ex) {
            logger("Food Rescue Creation Error", [$ex]);
            $this->alert('error', '', __('Food Rescue creation failed!'));
        }
    }

    public function initiateEdit($id)
    {
        $this->reset();
        $this->selectedModel = FoodRescue::find($id);

        $this->title = $this->selectedModel->title;
        $this->description = $this->selectedModel->description;
        $this->original_price = $this->selectedModel->original_price;
        $this->rescue_price = $this->selectedModel->rescue_price;
        $this->available_quantity = $this->selectedModel->available_quantity;
        $this->total_quantity = $this->selectedModel->total_quantity;
        $this->available_from = $this->selectedModel->available_from ? $this->selectedModel->available_from->format('Y-m-d\TH:i') : null;
        $this->available_until = $this->selectedModel->available_until ? $this->selectedModel->available_until->format('Y-m-d\TH:i') : null;
        $this->vendor_id = $this->selectedModel->vendor_id;
        $this->isActive = $this->selectedModel->is_active;
        $this->pickup_instructions = $this->selectedModel->pickup_instructions;
        $this->tags = $this->selectedModel->tags ?? [];
        
        $this->showEdit = true;
    }

    public function update()
    {
        $this->validate();

        try {
            DB::transaction(function () {
                // Ensure total_quantity is at least as much as available_quantity
                if ($this->total_quantity < $this->available_quantity) {
                    $this->total_quantity = $this->available_quantity;
                }

                $this->selectedModel->title = $this->title;
                $this->selectedModel->description = $this->description;
                $this->selectedModel->original_price = $this->original_price;
                $this->selectedModel->rescue_price = $this->rescue_price;
                $this->selectedModel->available_quantity = $this->available_quantity;
                $this->selectedModel->total_quantity = $this->total_quantity;
                $this->selectedModel->available_from = $this->available_from;
                $this->selectedModel->available_until = $this->available_until;
                $this->selectedModel->vendor_id = $this->vendor_id;
                $this->selectedModel->is_active = $this->isActive;
                $this->selectedModel->pickup_instructions = $this->pickup_instructions;
                $this->selectedModel->tags = $this->tags;
                $this->selectedModel->save();

                // Handle photo uploads
                if (!empty($this->photos)) {
                    // Clear existing photos if new ones are uploaded
                    $this->selectedModel->clearMediaCollection('default');
                    
                    foreach ($this->photos as $photo) {
                        $this->selectedModel->addMedia($photo->getRealPath())
                            ->toMediaCollection('default');
                    }
                }
            });

            $this->alert('success', '', __('Food Rescue updated successfully!'));
            $this->reset();
            $this->showEdit = false;
            $this->emit('refreshView');
        } catch (Exception $ex) {
            logger("Food Rescue Update Error", [$ex]);
            $this->alert('error', '', __('Food Rescue update failed!'));
        }
    }

    public function markAsInactive($id)
    {
        try {
            $foodRescue = FoodRescue::find($id);
            if ($foodRescue) {
                $foodRescue->markAsInactive();
                $this->alert('success', '', __('Food Rescue marked as inactive!'));
                $this->emit('refreshView');
            }
        } catch (Exception $ex) {
            logger("Food Rescue Deactivation Error", [$ex]);
            $this->alert('error', '', __('Operation failed!'));
        }
    }

    public function calculateDiscountPercentage()
    {
        if ($this->original_price > 0 && $this->rescue_price >= 0) {
            return round((($this->original_price - $this->rescue_price) / $this->original_price) * 100);
        }
        return 0;
    }

    // Validation for rescue price
    public function updatedRescuePrice()
    {
        if ($this->rescue_price > $this->original_price) {
            $this->addError('rescue_price', 'Rescue price cannot be higher than original price');
        }
    }

    public function updatedAvailableQuantity()
    {
        if ($this->available_quantity > $this->total_quantity) {
            $this->total_quantity = $this->available_quantity;
        }
    }
}
