<?php

namespace App\Http\Livewire\Tables\Taxi;

use App\Http\Livewire\Tables\BaseTableComponent;
use App\Models\CarModel;
use Kdion4891\LaravelLivewireTables\Column;
use Exception;

class CarModelTable extends BaseTableComponent
{

    public $model = CarModel::class;
    public $header_view = 'components.buttons.new';

    protected $listeners = [
        'activateModel',
        'deactivateModel',
        'deleteModel',
        'filterUsers',
        'refreshTable' => '$refresh',
    ];

    public function query()
    {
        return CarModel::with('car_make');
    }

    public function columns()
    {
        return [
            Column::make(__('ID'),"id")->searchable()->sortable(),
            Column::make(__('Make'),'car_make.name')->searchable(),
            Column::make(__('Name'),'name')->searchable(),
            Column::make(__('Actions'))->view('components.buttons.edit'),
            Column::make(__('Delete'))->view('components.buttons.delete'),
        ];
    }

    public function deleteModel()
    {
        try {
            $this->isDemo();
            $this->selectedModel->delete();
            $this->showSuccessAlert(__("Car Model deleted successfully!"));
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? __("Deletion failed!"));
        }
    }
}
