<?php

namespace App\Http\Livewire\Tables;

use App\Models\FoodRescue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class FoodRescueTable extends DataTableComponent
{
    protected $model = FoodRescue::class;
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

    public function builder(): Builder
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

        return $query;
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status')
                ->options([
                    '' => 'All',
                    '1' => 'Active',
                    '0' => 'Inactive',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('is_active', true);
                    } elseif ($value === '0') {
                        $builder->where('is_active', false);
                    }
                }),
            SelectFilter::make('Availability')
                ->options([
                    '' => 'All',
                    'available' => 'Available',
                    'expired' => 'Expired',
                    'sold_out' => 'Sold Out',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value === 'available') {
                        $builder->available();
                    } elseif ($value === 'expired') {
                        $builder->where('available_until', '<', now());
                    } elseif ($value === 'sold_out') {
                        $builder->where('available_quantity', '<=', 0);
                    }
                }),
        ];
    }

    public function columns(): array
    {
        return [
            ImageColumn::make('Photo')
                ->location(function ($row) {
                    return $row->photo;
                })
                ->attributes(function ($row) {
                    return [
                        'class' => 'w-16 h-16 object-cover rounded',
                    ];
                }),

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
                    return $html;
                })
                ->html(),

            BooleanColumn::make('Active', 'is_active')
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
                })
                ->html(),
        ];
    }
}
