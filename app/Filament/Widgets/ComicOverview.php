<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ComicPurchaseResource;
use App\Filament\Resources\ComicResource;
use App\Models\Comic;
use App\Models\ComicPurchase;
use App\Models\Comicvol;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class ComicOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        // 1. Data Koleksi
        $totalComics = Comic::count();
        $totalVolumes = Comicvol::count();
        $collectedVolumes = Comicvol::where('is_collected', true)->count();
        $collectionRate = $totalVolumes > 0 ? round(($collectedVolumes / $totalVolumes) * 100, 1) : 0;
        
        $newestComic = Comic::latest()->first();

        // Hitung komik lengkap vs belum lengkap
        $completeComics = Comic::whereHas('comicvol')
            ->whereDoesntHave('comicvol', function ($q) {
                $q->where('is_collected', false);
            })->count();
        $incompleteComics = max(0, $totalComics - $completeComics);

        // 2. Data Pembelian
        $currentDate = now()->startOfMonth();
        $currentMonth = $currentDate->month;
        $currentYear = $currentDate->year;

        $totalSpendMonth = ComicPurchase::whereMonth('purchase_date', $currentMonth)
            ->whereYear('purchase_date', $currentYear)
            ->sum('price');

        $lastMonthDate = (clone $currentDate)->subMonth();
        $lastMonthSpend = ComicPurchase::whereMonth('purchase_date', $lastMonthDate->month)
            ->whereYear('purchase_date', $lastMonthDate->year)
            ->sum('price');

        $diff = $totalSpendMonth - $lastMonthSpend;
        $trendIcon = $diff >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $trendColor = $diff > 0 ? 'warning' : 'success';

        $totalInvestment = ComicPurchase::sum('price');
        $totalPurchasesCount = ComicPurchase::count();

        // 3. Mini sparkline chart volume 7 bulan terakhir
        $volumeSparkline = [];
        for ($i = 6; $i >= 0; $i--) {
            $pointDate = (clone $currentDate)->subMonths($i);
            $volumeSparkline[] = Comicvol::whereYear('created_at', $pointDate->year)
                ->whereMonth('created_at', $pointDate->month)
                ->count();
        }

        return [
            // KARTU 1: TOTAL KOLEKSI
            Stat::make('Total Judul', $totalComics . ' Judul')
                ->description('Lihat semua komik')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('primary')
                ->url(ComicResource::getUrl('index')),

            // KARTU 2: TOTAL VOLUME & PROGRESS
            Stat::make('Total Volume', $totalVolumes . ' Buku')
                ->description("{$collectedVolumes} terkumpul ({$collectionRate}%)")
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->chart($volumeSparkline)
                ->color('info'),

            // KARTU 3: PENGELUARAN BULAN INI
            Stat::make('Belanja ' . now()->translatedFormat('F'), 'Rp ' . number_format($totalSpendMonth, 0, ',', '.'))
                ->description($diff != 0 ? ($diff > 0 ? 'Naik Rp ' . number_format($diff, 0, ',', '.') : 'Turun Rp ' . number_format(abs($diff), 0, ',', '.')) . ' vs bln lalu' : 'Sama dengan bulan lalu')
                ->descriptionIcon($trendIcon)
                ->color($totalSpendMonth > 0 ? $trendColor : 'gray')
                ->url(ComicPurchaseResource::getUrl('index')),

            // KARTU 4: TOTAL INVESTASI / AKUMULASI BELANJA
            Stat::make('Total Investasi', 'Rp ' . number_format($totalInvestment, 0, ',', '.'))
                ->description("{$totalPurchasesCount} transaksi tercatat")
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->url(ComicPurchaseResource::getUrl('index')),

            // KARTU 5: STATUS KELENGKAPAN
            Stat::make('Kelengkapan Seri', "{$completeComics} / {$totalComics} Seri")
                ->description($incompleteComics > 0 ? "{$incompleteComics} seri belum lengkap" : 'Semua koleksi lengkap')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color($incompleteComics === 0 && $totalComics > 0 ? 'success' : 'warning'),

            // KARTU 6: UPDATE TERBARU
            Stat::make('Baru Ditambahkan', $newestComic?->name ?? '-')
                ->description($newestComic ? 'Masuk ' . $newestComic->created_at->diffForHumans() : 'Belum ada data komik')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('amber'),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}