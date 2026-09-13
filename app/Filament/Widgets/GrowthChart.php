<?php

namespace App\Filament\Widgets;

use App\Models\ComicPurchase;
use App\Models\Comicvol;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class GrowthChart extends ChartWidget
{
    protected static ?string $heading = '📈 Tren Penambahan Volume & Pembelian';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '280px';
    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    public ?string $filter = '6m';

    protected function getFilters(): ?array
    {
        return [
            '3m' => '3 Bulan Terakhir',
            '6m' => '6 Bulan Terakhir',
            '12m' => '12 Bulan Terakhir',
            'this_year' => 'Tahun Ini',
        ];
    }

    protected function getData(): array
    {
        $currentDate = now()->startOfMonth();

        $monthsCount = match ($this->filter) {
            '3m' => 3,
            '12m' => 12,
            'this_year' => max(1, $currentDate->month),
            default => 6,
        };

        $labels = [];
        $volumeCounts = [];
        $purchaseCounts = [];

        for ($i = $monthsCount - 1; $i >= 0; $i--) {
            $date = (clone $currentDate)->subMonths($i);
            $labels[] = $date->translatedFormat('M Y');

            $volumeCounts[] = Comicvol::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $purchaseCounts[] = ComicPurchase::whereYear('purchase_date', $date->year)
                ->whereMonth('purchase_date', $date->month)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Volume Ditambahkan',
                    'data' => $volumeCounts,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.15)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
                [
                    'label' => 'Buku Dibeli',
                    'data' => $purchaseCounts,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.15)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
