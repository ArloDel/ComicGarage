<?php

use App\Models\Comic;
use App\Models\ComicPurchase;
use App\Models\Comicvol;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $comics = collect();
    $stats = [
        'totalTitles' => 0,
        'totalVolumes' => 0,
        'collectedVolumes' => 0,
        'collectionRate' => 0,
        'completeSeries' => 0,
        'incompleteSeries' => 0,
        'totalInvestment' => 0,
        'recentPurchasesCount' => 0,
    ];
    $recentPurchases = collect();
    $genres = collect();

    try {
        $comics = Comic::with(['author', 'comicvol' => function ($query) {
            $query->orderBy('volume', 'asc');
        }])->latest()->get();

        $totalComics = $comics->count();
        $totalVolumes = Comicvol::count();
        $collectedVolumes = Comicvol::where('is_collected', true)->count();
        $collectionRate = $totalVolumes > 0 ? round(($collectedVolumes / $totalVolumes) * 100, 1) : 0;

        $completeSeries = $comics->filter(function ($comic) {
            $total = $comic->comicvol->count();
            $collected = $comic->comicvol->where('is_collected', true)->count();
            return $total > 0 && $collected === $total;
        })->count();

        $incompleteSeries = max(0, $totalComics - $completeSeries);
        $totalInvestment = ComicPurchase::sum('price') ?? 0;
        $recentPurchases = ComicPurchase::latest('purchase_date')->take(6)->get();
        $genres = $comics->pluck('genre')->unique()->filter()->values();

        $stats = [
            'totalTitles' => $totalComics,
            'totalVolumes' => $totalVolumes,
            'collectedVolumes' => $collectedVolumes,
            'collectionRate' => $collectionRate,
            'completeSeries' => $completeSeries,
            'incompleteSeries' => $incompleteSeries,
            'totalInvestment' => $totalInvestment,
            'recentPurchasesCount' => ComicPurchase::count(),
        ];
    } catch (\Throwable $e) {
        // Fallback gracefully if database table not yet populated or offline
    }

    return view('welcome', compact('comics', 'stats', 'recentPurchases', 'genres'));
});
 