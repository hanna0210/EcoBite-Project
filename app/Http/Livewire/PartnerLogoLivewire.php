<?php

namespace App\Http\Livewire;

use App\Models\PartnerLogo;
use Exception;
use Illuminate\Support\Facades\DB;

class PartnerLogoLivewire extends BaseLivewireComponent
{

    //
    public $model = PartnerLogo::class;

    //
    public $name;
    public $isActive;


    public function render()
    {
        return view('livewire.partner-logos');
    }


    public function save()
    {
        //validate
        $this->validate([
            "name" => "required|string|max:255",
            "photo" => "required|image|max:" . setting("filelimit.banner", 2048) . "",
        ]);

        try {

            DB::beginTransaction();
            $model = new PartnerLogo();
            $model->name = $this->name;
            $model->is_active = $this->isActive ?? false;
            $model->save();

            if ($this->photo) {
                $model->clearMediaCollection();
                $model->addMedia($this->photo->getRealPath())->toMediaCollection();
                $this->photo = null;
            }

            DB::commit();

            // Clear partner logos cache
            \Cache::forget('partner_logos_fetch');

            $this->dismissModal();
            $this->reset();
            $this->showSuccessAlert(__("Partner Logo created successfully!"));
            $this->emit('refreshTable');
        } catch (Exception $error) {
            DB::rollback();
            $this->showErrorAlert($error->getMessage() ?? __("Partner Logo creation failed!"));
        }
    }

    public function initiateEdit($id)
    {
        $this->selectedModel = $this->model::find($id);
        $this->name = $this->selectedModel->name;
        $this->isActive = $this->selectedModel->is_active;
        
        $this->emit('showEditModal');
    }

    public function update()
    {
        //validate
        $this->validate([
            "name" => "required|string|max:255",
            "photo" => "sometimes|nullable|image|max:" . setting("filelimit.banner", 2048) . "",
        ]);

        try {

            DB::beginTransaction();
            $model = $this->selectedModel;
            $model->name = $this->name;
            $model->is_active = $this->isActive ?? false;
            $model->save();

            if ($this->photo) {
                $model->clearMediaCollection();
                $model->addMedia($this->photo->getRealPath())->toMediaCollection();
                $this->photo = null;
            }

            DB::commit();

            // Clear partner logos cache
            \Cache::forget('partner_logos_fetch');

            $this->dismissModal();
            $this->reset();
            $this->showSuccessAlert(__("Partner Logo updated successfully!"));
            $this->emit('refreshTable');
        } catch (Exception $error) {
            DB::rollback();
            $this->showErrorAlert($error->getMessage() ?? __("Partner Logo update failed!"));
        }
    }

    // Get the current logo photo for preview
    public function getCurrentPhotoProperty()
    {
        return $this->selectedModel?->photo ?? '';
    }
}

