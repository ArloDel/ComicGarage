<?php

namespace App\Filament\Widgets;

use App\Models\Comic;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Str;

class TopComicsChart extends ChartWidget
{
    protected static ?string $heading = '🏆 Top Komik Volume Terbanyak';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '280px';
    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    public ?string $filter = '10';

    protected function getFilters(): ?array
    {
        return [
            '5' => 'Top 5',
            '10' => 'Top 10',
            '15' => 'Top 15',
        ];
    }

    protected function getData(): array
    {
        $limit = (int) ($this->filter ?? 10);

        $topComics = Comic::withCount('comicvol')
            ->orderByDesc('comicvol_count')
            ->take($limit)
            ->get();

        $colors = [
            '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6',
            '#ef4444', '#06b6d4', '#84cc16', '#f97316',
            '#ec4899', '#6366f1', '#14b8a6', '#eab308',
            '#a855f7', '#0284c7', '#16a34a',
        ];

        if ($topComics->isEmpty()) {
            return [
                'datasets' => [
                    [
                        'label' => 'Total Volume',
                        'data' => [0],
                        'backgroundColor' => ['#94a3b8'],
                        'borderRadius' => 6,
                    ],
                ],
                'labels' => ['Belum ada komik'],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Volume',
                    'data' => $topComics->pluck('comicvol_count')->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $topComics->count()),
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $topComics->map(function ($comic) {
                return Str::limit($comic->name, 16);
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
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
