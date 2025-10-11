<?php

namespace App\Http\Livewire\Tables\Taxi;

use App\Http\Livewire\Tables\BaseTableComponent;
use App\Models\CarMake;
use Kdion4891\LaravelLivewireTables\Column;
use Exception;

class CarMakeTable extends BaseTableComponent
{

    public $model = CarMake::class;
    public $header_view = 'components.buttons.new';

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

    // Override delete method to check for associated car models
    public function deleteModel()
    {
        try {
            $this->isDemo();
            
            // Check if there are any car models associated with this car make
            if ($this->selectedModel->carModels()->count() > 0) {
                $this->showErrorAlert(__("Cannot delete this car make because it has associated car models. Please delete or reassign the car models first."));
                return;
            }
            
            // If no associated car models, proceed with deletion
            $this->selectedModel->delete();
            $this->showSuccessAlert(__("Deleted"));
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? "Failed");
        }
    }
}
