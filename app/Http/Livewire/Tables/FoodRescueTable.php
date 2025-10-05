<?php

namespace App\Http\Livewire\Tables;

use App\Models\FoodRescue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class FoodRescueTable extends BaseDataTableComponent
{
    public $model = FoodRescue::class;
    public $columnSearch = [
        'title' => null,
        'vendor.name' => null,
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setTableRowUrl(function ($row) {
            return '#';
        });
    }

    public function query()
    {
        $query = FoodRescue::query()->with(['vendor']);
        
        // Apply role-based filtering
        if (Auth::user()->hasRole('manager')) {
            $query->where('vendor_id', Auth::user()->vendor_id);
        } elseif (Auth::user()->hasRole('city-admin')) {
            $query->whereHas('vendor', function ($q) {
                $q->where('creator_id', Auth::id());
            });
        }

        // Apply filters
        $query->when($this->getFilter('status'), function ($query, $status) {
            if ($status === '1') {
                $query->where('is_active', true);
            } elseif ($status === '0') {
                $query->where('is_active', false);
            }
        });

        $query->when($this->getFilter('availability'), function ($query, $availability) {
            if ($availability === 'available') {
                $query->available();
            } elseif ($availability === 'expired') {
                $query->where('available_until', '<', now());
            } elseif ($availability === 'sold_out') {
                $query->where('available_quantity', '<=', 0);
            }
        });

        return $query;
    }

    public function filters(): array
    {
        return [
            'status' => Filter::make(__('Status'))
                ->select([
                    '' => __('All'),
                    '1' => __('Active'),
                    '0' => __('Inactive'),
                ]),
            'availability' => Filter::make(__('Availability'))
                ->select([
                    '' => __('All'),
                    'available' => __('Available'),
                    'expired' => __('Expired'),
                    'sold_out' => __('Sold Out'),
                ]),
        ];
    }

    public function columns(): array
    {
        return [
            $this->smImageColumn(),

            Column::make('Title', 'title')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row) {
                    return view('components.table.title-description', [
                        'title' => $value,
                        'description' => \Str::limit($row->description, 50),
                    ]);
                }),

            Column::make('Vendor', 'vendor.name')
                ->sortable()
                ->searchable()
                ->format(function ($value, $row) {
                    return $row->vendor->name ?? 'N/A';
                }),

            Column::make('Prices')
                ->format(function ($value, $row) {
                    return view('components.table.price-comparison', [
                        'original_price' => currencyFormat($row->original_price),
                        'rescue_price' => currencyFormat($row->rescue_price),
                        'discount_percentage' => $row->discount_percentage,
                    ]);
                }),

            Column::make('Quantity')
                ->format(function ($value, $row) {
                    return view('components.table.quantity-status', [
                        'available' => $row->available_quantity,
                        'total' => $row->total_quantity,
                        'is_sold_out' => $row->available_quantity <= 0,
                    ]);
                }),

            Column::make('Availability')
                ->format(function ($value, $row) {
                    return view('components.table.availability-status', [
                        'available_from' => $row->available_from,
                        'available_until' => $row->available_until,
                        'is_available' => $row->is_available,
                        'time_remaining' => $row->time_remaining,
                    ]);
                }),

            Column::make('Tags')
                ->format(function ($value, $row) {
                    $tags = $row->tags ?? [];
                    if (empty($tags)) return '-';
                    
                    $html = '';
                    foreach (array_slice($tags, 0, 3) as $tag) {
                        $html .= '<span class="inline-block bg-gray-200 rounded-full px-2 py-1 text-xs text-gray-700 mr-1 mb-1">' . $tag . '</span>';
                    }
                    if (count($tags) > 3) {
                        $html .= '<span class="text-xs text-gray-500">+' . (count($tags) - 3) . ' more</span>';
                    }
                    return view('components.table.plain', [
                        'text' => $html
                    ]);
                }),

            Column::make('Active', 'is_active')
                ->format(function ($value, $column, $row) {
                    return view('components.table.active', [
                        'model' => $row
                    ]);
                })
                ->sortable(),

            Column::make('Actions')
                ->format(function ($value, $row) {
                    return view('components.table.actions', [
                        'model' => $row,
                        'actions' => [
                            [
                                'type' => 'edit',
                                'route' => '#',
                                'permission' => true,
                                'onclick' => '$emit(\'initiateEdit\', ' . $row->id . ')'
                            ],
                            [
                                'type' => 'view',
                                'route' => '#',
                                'permission' => true,
                                'onclick' => '$emit(\'showDetailsModal\', ' . $row->id . ')'
                            ],
                            [
                                'type' => 'inactive',
                                'route' => '#',
                                'permission' => $row->is_active,
                                'onclick' => 'confirm(\'Mark as inactive?\') && $wire.call(\'markAsInactive\', ' . $row->id . ')',
                                'title' => 'Mark as Inactive'
                            ],
                            [
                                'type' => 'delete',
                                'route' => '#',
                                'permission' => true,
                                'onclick' => '$emit(\'initiateDelete\', ' . $row->id . ')'
                            ]
                        ]
                    ]);
                }),
        ];
    }
}
