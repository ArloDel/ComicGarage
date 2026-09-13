<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ComicResource;
use App\Models\Comic;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class IncompleteComicsWidget extends BaseWidget
{
    protected static ?string $heading = '⏳ Seri Komik Belum Lengkap';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Comic::query()
                    ->whereHas('comicvol', function ($q) {
                        $q->where('is_collected', false);
                    })
                    ->withCount([
                        'comicvol',
                        'comicvol as collected_count' => function ($q) {
                            $q->where('is_collected', true);
                        },
                        'comicvol as uncollected_count' => function ($q) {
                            $q->where('is_collected', false);
                        }
                    ])
                    ->orderByDesc('uncollected_count')
                    ->limit(5)
            )
            ->paginated(false)
            ->emptyStateHeading('Semua Seri Komik Lengkap! 🎉')
            ->emptyStateDescription('Hebat! Tidak ada seri buku komik yang tertinggal atau belum terkumpul.')
            ->emptyStateIcon('heroicon-o-check-badge')
            ->emptyStateActions([
                Tables\Actions\Action::make('browse')
                    ->label('Lihat Semua Komik')
                    ->url(ComicResource::getUrl('index'))
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Judul Komik')
                    ->limit(18)
                    ->weight('bold')
                    ->searchable(),
                Tables\Columns\TextColumn::make('genre')
                    ->label('Genre')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'shounen' => 'success',
                        'seinen' => 'warning',
                        'horror' => 'danger',
                        'america' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('progress')
                    ->label('Progress')
                    ->getStateUsing(function (Comic $record): string {
                        return "{$record->collected_count}/{$record->comicvol_count} Vol";
                    })
                    ->badge()
                    ->color(fn (Comic $record): string => $record->collected_count === $record->comicvol_count ? 'success' : 'warning'),
                Tables\Columns\TextColumn::make('uncollected_count')
                    ->label('Kurang')
                    ->badge()
                    ->color('danger')
                    ->formatStateUsing(fn ($state): string => "{$state} Vol"),
            ])
            ->actions([
                Tables\Actions\Action::make('manage')
                    ->label('Lengkapi')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->url(fn (Comic $record): string => ComicResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
