<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ComicPurchaseResource;
use App\Models\ComicPurchase;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestPurchasesWidget extends BaseWidget
{
    protected static ?string $heading = '🛒 Pembelian Komik Terbaru';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ComicPurchase::query()->latest('purchase_date')->latest('id')->limit(5)
            )
            ->paginated(false)
            ->emptyStateHeading('Belum ada riwayat pembelian')
            ->emptyStateDescription('Catat transaksi belanja komik Anda untuk melacak pengeluaran.')
            ->emptyStateIcon('heroicon-o-shopping-cart')
            ->emptyStateActions([
                Tables\Actions\Action::make('create')
                    ->label('+ Tambah Pembelian')
                    ->url(ComicPurchaseResource::getUrl('create'))
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Komik')
                    ->limit(20)
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('volume')
                    ->label('Vol.')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->color('success'),
                Tables\Columns\TextColumn::make('purchase_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('store')
                    ->label('Toko')
                    ->placeholder('-')
                    ->badge()
                    ->color('gray'),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Detail')
                    ->icon('heroicon-m-pencil-square')
                    ->url(fn (ComicPurchase $record): string => ComicPurchaseResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
