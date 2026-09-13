<?php

namespace App\Filament\Widgets;

use App\Models\Comic;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class GenreDistributionChart extends ChartWidget
{
    protected static ?string $heading = '📊 Distribusi Genre Koleksi';
    protected static ?int $sort = 6;
    protected static ?string $maxHeight = '280px';
    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    public ?string $filter = 'all';

    protected function getFilters(): ?array
    {
        return [
            'all' => 'Semua Judul',
            'with_volumes' => 'Hanya yang Punya Volume',
        ];
    }

    protected function getData(): array
    {
        $query = Comic::query();

        if ($this->filter === 'with_volumes') {
            $query->has('comicvol');
        }

        $genreCounts = $query->select('genre', DB::raw('count(*) as total'))
            ->groupBy('genre')
            ->pluck('total', 'genre')
            ->toArray();

        $genreMeta = [
            'shounen' => ['label' => 'Shounen', 'color' => '#10b981'],
            'seinen' => ['label' => 'Seinen', 'color' => '#f59e0b'],
            'horror' => ['label' => 'Horror', 'color' => '#ef4444'],
            'america' => ['label' => 'America', 'color' => '#3b82f6'],
        ];

        $labels = [];
        $data = [];
        $colors = [];
        $palette = ['#8b5cf6', '#ec4899', '#06b6d4', '#84cc16', '#f97316', '#14b8a6'];
        $paletteIndex = 0;

        foreach ($genreMeta as $key => $meta) {
            $count = $genreCounts[$key] ?? 0;
            if ($count > 0 || empty($genreCounts)) {
                $labels[] = $meta['label'];
                $data[] = $count;
                $colors[] = $meta['color'];
            }
        }

        // Custom genres if any
        foreach ($genreCounts as $key => $count) {
            if (!isset($genreMeta[$key])) {
                $labels[] = ucfirst($key);
                $data[] = $count;
                $colors[] = $palette[$paletteIndex % count($palette)];
                $paletteIndex++;
            }
        }

        if (empty($labels) || array_sum($data) === 0) {
            return [
                'datasets' => [
                    [
                        'label' => 'Jumlah Judul',
                        'data' => [1],
                        'backgroundColor' => ['#e2e8f0'],
                    ],
                ],
                'labels' => ['Belum ada komik'],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Judul',
                    'data' => $data,
                    'backgroundColor' => $colors,
                ],
            ],
            'labels' => $labels,
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
