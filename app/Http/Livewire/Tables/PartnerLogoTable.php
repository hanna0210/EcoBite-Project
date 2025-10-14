<?php

namespace App\Http\Livewire\Tables;

use App\Models\PartnerLogo;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PartnerLogoTable extends OrderingBaseDataTableComponent
{

    public $model = PartnerLogo::class;
    public $header_view = 'components.buttons.new';


    public function query()
    {
        return PartnerLogo::query();
    }

    // Override delete to clear cache
    public function deleteModel()
    {
        try {
            $this->isDemo();
            $this->selectedModel->delete();
            
            // Clear partner logos cache
            \Cache::forget('partner_logos_fetch');
            
            $this->showSuccessAlert(__("Deleted"));
        } catch (\Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? "Failed");
        }
    }

    // Override activate to clear cache
    public function activateModel()
    {
        try {
            if ($this->checkDemo) {
                // Demo check
            }
            $this->selectedModel->is_active = true;
            $this->selectedModel->save();
            
            // Clear partner logos cache
            \Cache::forget('partner_logos_fetch');
            
            $this->showSuccessAlert(__("Activated"));
        } catch (\Exception $error) {
            $this->showErrorAlert("Failed");
        }
    }

    // Override deactivate to clear cache
    public function deactivateModel()
    {
        try {
            if ($this->checkDemo) {
                $this->isDemo();
            }
            $this->selectedModel->is_active = false;
            $this->selectedModel->save();
            
            // Clear partner logos cache
            \Cache::forget('partner_logos_fetch');
            
            $this->showSuccessAlert(__("Deactivated"));
        } catch (\Exception $error) {
            $this->showErrorAlert("Failed");
        }
    }

    public function columns(): array
    {
        $columns = [
            Column::make(__('ID'), "id")->searchable()->sortable(),
            Column::make(__('Name'), "name")->searchable()->sortable(),
            Column::make(__('Logo'))->format(function ($value, $column, $row) {
                return view('components.table.image_md', $data = [
                    "model" => $row
                ]);
            }),
            Column::make(__('Active'), 'is_active')->format(function ($value, $column, $row) {
                return view('components.table.active', $data = [
                    "model" => $row
                ]);
            })->sortable(),
            Column::make(__('Created At'), 'formatted_date'),
        ];

        //
        if (app()->environment('production')) {
            $columns[] = Column::make(__('Actions'))->format(function ($value, $column, $row) {
                return view('components.buttons.actions', $data = [
                    "model" => $row,
                ]);
            });
        }

        return $columns;
    }
}

