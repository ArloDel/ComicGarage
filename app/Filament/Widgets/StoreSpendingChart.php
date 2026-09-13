<?php

namespace App\Filament\Widgets;

use App\Models\ComicPurchase;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class StoreSpendingChart extends ChartWidget
{
    protected static ?string $heading = '🏪 Distribusi Belanja per Toko';
    protected static ?int $sort = 7;
    protected static ?string $maxHeight = '280px';
    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    public ?string $filter = 'all';

    protected function getFilters(): ?array
    {
        return [
            'all' => 'Semua Waktu',
            'this_year' => 'Tahun Ini',
            'this_month' => 'Bulan Ini',
        ];
    }

    protected function getData(): array
    {
        $query = ComicPurchase::query();

        if ($this->filter === 'this_year') {
            $query->whereYear('purchase_date', now()->year);
        } elseif ($this->filter === 'this_month') {
            $query->whereYear('purchase_date', now()->year)
                  ->whereMonth('purchase_date', now()->month);
        }

        $storePurchases = $query->select(
            DB::raw("COALESCE(NULLIF(TRIM(store), ''), 'Lainnya') as store_name"),
            DB::raw('SUM(price) as total_spent'),
            DB::raw('COUNT(*) as total_items')
        )
        ->groupBy('store_name')
        ->orderByDesc('total_spent')
        ->take(6)
        ->get();

        $colors = [
            '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6',
            '#ec4899', '#06b6d4', '#64748b'
        ];

        if ($storePurchases->isEmpty()) {
            return [
                'datasets' => [
                    [
                        'label' => 'Total Belanja (Rp)',
                        'data' => [1],
                        'backgroundColor' => ['#e2e8f0'],
                    ],
                ],
                'labels' => ['Belum ada data belanja'],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Belanja (Rp)',
                    'data' => $storePurchases->pluck('total_spent')->map(fn ($val) => (float) $val)->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $storePurchases->count()),
                ],
            ],
            'labels' => $storePurchases->pluck('store_name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
