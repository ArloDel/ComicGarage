<?php

namespace App\Filament\Widgets;

use App\Models\Comic;
use Filament\Widgets\ChartWidget;

class TopComicsChart extends ChartWidget
{
     protected static ?string $heading = 'Top 10 Komik Terpopuler';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $topComics = Comic::withCount('comicvol')
            ->orderByDesc('comicvol_count')
            ->take(10)
            ->get();
        return [
           'datasets' => [
                [
                    'label' => 'Jumlah Volume',
                    'data' => $topComics->pluck('comicvol_count')->toArray(),
                    'backgroundColor' => [
                        '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6',
                        '#ef4444', '#06b6d4', '#84cc16', '#f97316',
                        '#ec4899', '#6366f1'
                    ],
                ],
            ],
            'labels' => $topComics->map(function ($comic) {
                return strlen($comic->name) > 15
                    ? substr($comic->name, 0, 15) . '...'
                    : $comic->name;
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
                ],
            ],
        ];
    }
}
