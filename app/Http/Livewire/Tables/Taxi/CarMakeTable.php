<?php

namespace App\Http\Livewire\Tables\Taxi;

use App\Http\Livewire\Tables\BaseTableComponent;
use App\Models\CarMake;
use Kdion4891\LaravelLivewireTables\Column;
use Exception;
use Illuminate\Support\Facades\DB;

class CarMakeTable extends BaseTableComponent
{

    public $model = CarMake::class;
    public $header_view = 'components.buttons.new';

    protected $listeners = [
        'activateModel',
        'deactivateModel',
        'deleteModel',
        'forceDeleteCarMake',
        'filterUsers',
        'refreshTable' => '$refresh',
    ];

    public function query()
    {
        return CarMake::query();
    }

    public function columns()
    {
        return [
            Column::make(__('ID'),"id")->searchable()->sortable(),
            Column::make(__('Name'),'name')->searchable(),
            Column::make(__('Actions'))->view('components.buttons.edit'),
            Column::make(__('Delete'))->view('components.buttons.delete'),
        ];
    }

    // Override initiateDelete to check for associated car models
    public function initiateDelete($id)
    {
        $this->selectedModel = $this->model::find($id);
        
        // Check if there are any car models associated with this car make
        $carModelsCount = $this->selectedModel->carModels()->count();
        
        if ($carModelsCount > 0) {
            // Show warning with force delete option
            $this->confirm(__('Delete Car Make'), [
                'icon' => 'warning',
                'toast' => false,
                'text' =>  __("This car make has :count associated car model(s). Deleting it will also delete all associated car models. Are you sure you want to continue?", ['count' => $carModelsCount]),
                'position' => 'center',
                'showConfirmButton' => true,
                'cancelButtonText' => __("Cancel"),
                'confirmButtonText' => __("Yes, Delete All"),
                'onConfirmed' => 'forceDeleteCarMake',
                'onCancelled' => 'cancelled'
            ]);
        } else {
            // No associated models, show normal delete confirmation
            $this->confirm(__('Delete'), [
                'icon' => 'question',
                'toast' => false,
                'text' =>  __('Are you sure you want to delete the selected data?'),
                'position' => 'center',
                'showConfirmButton' => true,
                'cancelButtonText' => __("Cancel"),
                'confirmButtonText' => __("Yes"),
                'onConfirmed' => 'deleteModel',
                'onCancelled' => 'cancelled'
            ]);
        }
    }

    // Delete car make without associated models
    public function deleteModel()
    {
        try {
            $this->isDemo();
            
            // Double check no associated models exist
            if ($this->selectedModel->carModels()->count() > 0) {
                $this->showErrorAlert(__("Cannot delete this car make because it has associated car models."));
                return;
            }
            
            $this->selectedModel->delete();
            $this->showSuccessAlert(__("Car Make deleted successfully!"));
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? __("Deletion failed!"));
        }
    }

    // Force delete car make along with all associated car models
    public function forceDeleteCarMake()
    {
        try {
            $this->isDemo();
            
            DB::beginTransaction();
            
            // Get count for success message
            $carModelsCount = $this->selectedModel->carModels()->count();
            
            // Delete all associated car models first
            $this->selectedModel->carModels()->delete();
            
            // Then delete the car make
            $this->selectedModel->delete();
            
            DB::commit();
            
            $this->showSuccessAlert(__("Car Make and :count associated car model(s) deleted successfully!", ['count' => $carModelsCount]));
        } catch (Exception $error) {
            DB::rollback();
            $this->showErrorAlert($error->getMessage() ?? __("Deletion failed!"));
        }
    }
}
