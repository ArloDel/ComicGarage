<?php

namespace App\Filament\Widgets;

use App\Models\Comic;
use App\Models\Comicvol;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ComicOverview extends BaseWidget
{


    protected function getStats(): array
    {
        // Komik dengan volume terbanyak
        $mostCollectedComic = Comic::withCount('comicvol')
    ->orderByDesc('comicvol_count')
    ->first();
            // ->orderBy('volume', 'desc')
            // ->first();

            $totalComics = Comic::count();

        // Total volume
        $totalVolumes = ComicVol::count();

        // // Rata-rata volume per komik
        $avgVolumesPerComic = $totalComics > 0 ? round($totalVolumes / $totalComics, 1) : 0;

        // Komik terbaru (berdasarkan created_at)
        $newestComic = Comic::latest()->first();

        // Volume terbaru ditambahkan
        $newestVolume = ComicVol::with('comic')->latest()->first();

        // Top 3 komik dengan volume terbanyak untuk chart
        $topComics = Comic::withCount('comicvol')
            ->orderByDesc('comicvol_count')
            ->take(3)
            ->get()
            ->pluck('comicvol_count')
            ->toArray();

            return [
            Stat::make('Total Komik', $totalComics)
                ->description('Jumlah komik dalam koleksi')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('success'),


            Stat::make('Total Volume', $totalVolumes)
                ->description('Total volume yang dimiliki')
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('info'),



            Stat::make('Komik Terpopuler', $mostCollectedComic ? $mostCollectedComic->name : 'Belum ada data')
                ->description($mostCollectedComic ? "{$mostCollectedComic->comicvol_count} volume" : 'Tambahkan komik dan volume')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('warning')
                ->chart($topComics),

            Stat::make('Rata-rata Volume/Komik', $avgVolumesPerComic)
                ->description('Volume rata-rata per komik')
                ->descriptionIcon('heroicon-m-calculator')
                ->color('gray'),

            Stat::make('Komik Terbaru', $newestComic ? $newestComic->title : 'Belum ada komik')
                ->description($newestComic ? 'Ditambahkan ' . $newestComic->created_at->diffForHumans() : 'Tambahkan komik pertama')
                ->descriptionIcon('heroicon-m-plus-circle')
                ->color('success'),

            Stat::make('Volume Terbaru', $newestVolume ? $newestVolume->comic->title : 'Belum ada volume')
                ->description($newestVolume ? "Vol. {$newestVolume->volume_number} - " . $newestVolume->created_at->diffForHumans() : 'Tambahkan volume pertama')
                ->descriptionIcon('heroicon-m-document-plus')
                ->color('info'),
        ];

    }

    protected static ?int $sort = 1;

    // Refresh widget setiap 30 detik
    protected static ?string $pollingInterval = '30s';
}
