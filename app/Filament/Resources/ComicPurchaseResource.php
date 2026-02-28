<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComicPurchaseResource\Pages;
use App\Filament\Resources\ComicPurchaseResource\RelationManagers;
use App\Models\ComicPurchase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class ComicPurchaseResource extends Resource
{
    protected static ?string $model = ComicPurchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart'; // Saya ganti ikonnya agar lebih pas

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make() // Menggunakan Card agar tampilan form lebih rapi
                    ->schema([
                        Forms\Components\TextInput::make('title')->required(),
                        Forms\Components\TextInput::make('volume')->numeric()->required(),
                        Forms\Components\TextInput::make('price')->numeric()->prefix('Rp')->required(),
                        Forms\Components\DatePicker::make('purchase_date')->default(now())->required(),
                        Forms\Components\TextInput::make('store'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('volume'),
                Tables\Columns\TextColumn::make('purchase_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->summarize(Sum::make()->label('Total Belanja')),
            ])
            ->filters([
                Tables\Filters\Filter::make('pembelian_bulanan')
                    ->form([
                        Select::make('bulan')
                            ->options([
                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                '04' => 'April', '10' => 'Mei', '06' => 'Juni',
                                '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
                            ])
                            ->default(now()->format('m')),
                        TextInput::make('tahun')
                            ->numeric()
                            ->default(now()->format('Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['bulan'],
                                fn (Builder $query, $date): Builder => $query->whereMonth('purchase_date', $date),
                            )
                            ->when(
                                $data['tahun'],
                                fn (Builder $query, $date): Builder => $query->whereYear('purchase_date', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['bulan'] ?? null) {
                            $bulan = [
                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                                '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                                '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                            ];
                            $indicators[] = 'Bulan: ' . $bulan[$data['bulan']];
                        }
                        if ($data['tahun'] ?? null) {
                            $indicators[] = 'Tahun: ' . $data['tahun'];
                        }
                        return $indicators;
                    })
            ]); // Kurung penutup filter ada di sini
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComicPurchases::route('/'),
            'create' => Pages\CreateComicPurchase::route('/create'),
            'edit' => Pages\EditComicPurchase::route('/{record}/edit'),
        ];
    }
}
