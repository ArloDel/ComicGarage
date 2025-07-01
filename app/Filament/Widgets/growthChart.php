<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Comicvol;

class growthChart extends ChartWidget
{
    protected static ?string $heading = 'Trend Penambahan Volume (6 Bulan Terakhir)';
    protected static ?int $sort = 3;


    protected function getData(): array
    {
         $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months->push([
                'label' => $date->format('M Y'),
                'count' => ComicVol::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            ]);
        }
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
