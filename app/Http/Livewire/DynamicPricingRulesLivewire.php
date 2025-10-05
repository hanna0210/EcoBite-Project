<?php

namespace App\Http\Livewire;

use App\Models\DynamicPricingRule;
use Exception;
use Illuminate\Support\Facades\DB;

class DynamicPricingRulesLivewire extends BaseLivewireComponent
{
    public $model = DynamicPricingRule::class;
    
    // Form fields
    public $name;
    public $description;
    public $service_type = 'delivery';
    public $rule_type = 'time_based';
    public $start_time;
    public $end_time;
    public $days_of_week = [];
    public $base_multiplier = 1.00;
    public $distance_multiplier = 1.00;
    public $time_multiplier = 1.00;
    public $min_multiplier = 0.50;
    public $max_multiplier = 3.00;
    public $low_demand_threshold = 5;
    public $high_demand_threshold = 20;
    public $critical_demand_threshold = 50;
    public $is_active = true;
    public $priority = 1;
    public $start_date;
    public $end_date;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'service_type' => 'required|in:delivery,package,taxi',
        'rule_type' => 'required|in:time_based,demand_based,location_based,weather_based,event_based',
        'start_time' => 'nullable|date_format:H:i:s',
        'end_time' => 'nullable|date_format:H:i:s',
        'base_multiplier' => 'required|numeric|min:0.1|max:10',
        'distance_multiplier' => 'required|numeric|min:0.1|max:10',
        'time_multiplier' => 'required|numeric|min:0.1|max:10',
        'min_multiplier' => 'required|numeric|min:0.1|max:10',
        'max_multiplier' => 'required|numeric|min:0.1|max:10',
        'low_demand_threshold' => 'required|integer|min:0',
        'high_demand_threshold' => 'required|integer|min:0',
        'critical_demand_threshold' => 'required|integer|min:0',
        'priority' => 'required|integer|min:1|max:10',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date'
    ];

    public function render()
    {
        return view('livewire.dynamic-pricing-rules');
    }

    public function save()
    {
        $this->validate();

        try {
            $this->isDemo();
            DB::beginTransaction();
            
            $model = new DynamicPricingRule();
            $model->name = $this->name;
            $model->description = $this->description;
            $model->service_type = $this->service_type;
            $model->rule_type = $this->rule_type;
            $model->start_time = $this->start_time;
            $model->end_time = $this->end_time;
            $model->days_of_week = $this->days_of_week;
            $model->base_multiplier = $this->base_multiplier;
            $model->distance_multiplier = $this->distance_multiplier;
            $model->time_multiplier = $this->time_multiplier;
            $model->min_multiplier = $this->min_multiplier;
            $model->max_multiplier = $this->max_multiplier;
            $model->low_demand_threshold = $this->low_demand_threshold;
            $model->high_demand_threshold = $this->high_demand_threshold;
            $model->critical_demand_threshold = $this->critical_demand_threshold;
            $model->is_active = $this->is_active;
            $model->priority = $this->priority;
            $model->start_date = $this->start_date;
            $model->end_date = $this->end_date;
            $model->save();

            DB::commit();

            $this->dismissModal();
            $this->reset();
            $this->showSuccessAlert(__("Dynamic Pricing Rule") . " " . __('created successfully!'));
            $this->emit('refreshTable');
        } catch (Exception $error) {
            DB::rollback();
            $this->showErrorAlert($error->getMessage() ?? __("Dynamic Pricing Rule") . " " . __('creation failed!'));
        }
    }

    public function initiateEdit($id)
    {
        $this->reset();
        $this->selectedModel = $this->model::find($id);
        $this->name = $this->selectedModel->name;
        $this->description = $this->selectedModel->description;
        $this->service_type = $this->selectedModel->service_type;
        $this->rule_type = $this->selectedModel->rule_type;
        $this->start_time = $this->selectedModel->start_time;
        $this->end_time = $this->selectedModel->end_time;
        $this->days_of_week = $this->selectedModel->days_of_week ?? [];
        $this->base_multiplier = $this->selectedModel->base_multiplier;
        $this->distance_multiplier = $this->selectedModel->distance_multiplier;
        $this->time_multiplier = $this->selectedModel->time_multiplier;
        $this->min_multiplier = $this->selectedModel->min_multiplier;
        $this->max_multiplier = $this->selectedModel->max_multiplier;
        $this->low_demand_threshold = $this->selectedModel->low_demand_threshold;
        $this->high_demand_threshold = $this->selectedModel->high_demand_threshold;
        $this->critical_demand_threshold = $this->selectedModel->critical_demand_threshold;
        $this->is_active = $this->selectedModel->is_active;
        $this->priority = $this->selectedModel->priority;
        $this->start_date = $this->selectedModel->start_date;
        $this->end_date = $this->selectedModel->end_date;
        $this->emit('showEditModal');
    }

    public function update()
    {
        $this->validate();

        try {
            $this->isDemo();
            DB::beginTransaction();
            
            $this->selectedModel->name = $this->name;
            $this->selectedModel->description = $this->description;
            $this->selectedModel->service_type = $this->service_type;
            $this->selectedModel->rule_type = $this->rule_type;
            $this->selectedModel->start_time = $this->start_time;
            $this->selectedModel->end_time = $this->end_time;
            $this->selectedModel->days_of_week = $this->days_of_week;
            $this->selectedModel->base_multiplier = $this->base_multiplier;
            $this->selectedModel->distance_multiplier = $this->distance_multiplier;
            $this->selectedModel->time_multiplier = $this->time_multiplier;
            $this->selectedModel->min_multiplier = $this->min_multiplier;
            $this->selectedModel->max_multiplier = $this->max_multiplier;
            $this->selectedModel->low_demand_threshold = $this->low_demand_threshold;
            $this->selectedModel->high_demand_threshold = $this->high_demand_threshold;
            $this->selectedModel->critical_demand_threshold = $this->critical_demand_threshold;
            $this->selectedModel->is_active = $this->is_active;
            $this->selectedModel->priority = $this->priority;
            $this->selectedModel->start_date = $this->start_date;
            $this->selectedModel->end_date = $this->end_date;
            $this->selectedModel->save();

            DB::commit();

            $this->dismissModal();
            $this->reset();
            $this->showSuccessAlert(__("Dynamic Pricing Rule") . " " . __('updated successfully!'));
            $this->emit('refreshTable');
        } catch (Exception $error) {
            DB::rollback();
            $this->showErrorAlert($error->getMessage() ?? __("Dynamic Pricing Rule") . " " . __('update failed!'));
        }
    }

    public function toggleStatus($id)
    {
        try {
            $this->isDemo();
            $model = $this->model::find($id);
            $model->is_active = !$model->is_active;
            $model->save();
            
            $this->showSuccessAlert(__("Status updated successfully!"));
            $this->emit('refreshTable');
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage());
        }
    }

    public function getServiceTypesProperty()
    {
        return [
            'delivery' => 'Delivery',
            'package' => 'Package Delivery',
            'taxi' => 'Taxi Service'
        ];
    }

    public function getRuleTypesProperty()
    {
        return [
            'time_based' => 'Time Based',
            'demand_based' => 'Demand Based',
            'location_based' => 'Location Based',
            'weather_based' => 'Weather Based',
            'event_based' => 'Event Based'
        ];
    }

    public function getDaysOfWeekProperty()
    {
        return [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday'
        ];
    }
}
