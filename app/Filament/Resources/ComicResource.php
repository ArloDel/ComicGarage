<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Comic;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\ComicResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ComicResource\RelationManagers;

class ComicResource extends Resource
{
    protected static ?string $model = Comic::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

     public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Comic')
                    ->schema([
                        TextInput::make("name")
                            ->required()
                            ->label('Nama Comic'),
                        Select::make("genre")
                            ->options([
                                'shounen' => 'Shounen',
                                'seinen' => 'Seinen',
                                'horror' => 'Horror',
                                'america' => 'America'
                            ])
                            ->required(),
                        Select::make("author_id")
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required(),
                                FileUpload::make("image_path")
                            ]),
                        FileUpload::make("image")
                            ->image()
                            ->directory('comics')
                            ->disk('public')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
                    ])
                    ->columns(2),

                Section::make('Volume Management')
                    ->schema([
                        TextInput::make('volume_count')
                            ->label('Berapa Volume yang ingin ditambahkan?')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(50)
                            ->default(1)
                            ->live()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                $currentVolumes = $get('comicvol') ?? [];
                                $volumeCount = (int) $state;

                                if ($volumeCount > 0) {
                                    $newVolumes = [];
                                    for ($i = 1; $i <= $volumeCount; $i++) {
                                        $newVolumes[] = [
                                            'volume' => $i,
                                            'volume_name' => '',
                                            'is_collected' => false,
                                        ];
                                    }
                                    $set('comicvol', $newVolumes);
                                }
                            })
                            ->helperText('Masukkan jumlah volume, form akan otomatis terbuat sesuai jumlah yang diinginkan')
                            ->suffixAction(
                                Action::make('generate_volumes')
                                    ->icon('heroicon-m-arrow-path')
                                    ->label('Generate')
                                    ->action(function ($state, $set, $get) {
                                        $volumeCount = (int) $get('volume_count');
                                        if ($volumeCount > 0) {
                                            $newVolumes = [];
                                            for ($i = 1; $i <= $volumeCount; $i++) {
                                                $newVolumes[] = [
                                                    'volume' => $i,
                                                    'volume_name' => '',
                                                    'is_collected' => false,
                                                ];
                                            }
                                            $set('comicvol', $newVolumes);
                                        }
                                    })
                            ),

                        Placeholder::make('volume_info')
                            ->label('')
                            ->content(function ($get) {
                                $volumeCount = $get('volume_count');
                                if ($volumeCount) {
                                    return "📚 Akan dibuat {$volumeCount} volume form di bawah ini";
                                }
                                return '';
                            })
                            ->visible(fn ($get) => $get('volume_count') > 0),

                        Repeater::make('comicvol')
                            ->relationship()
                            ->label('Volume Details')
                            ->schema([
                                TextInput::make('volume')
                                    ->label('Vol.')
                                    ->numeric()
                                    ->required()
                                    ,
                                TextInput::make('volume_name')
                                    ->label('Judul Volume')
                                    ->placeholder('Masukkan judul volume (opsional)'),
                                Toggle::make('is_collected')
                                    ->label('Sudah Koleksi?')
                                    ->onIcon('heroicon-m-check-circle')
                                    ->offIcon('heroicon-m-x-circle')
                                    ->onColor('success')
                                    ->offColor('gray')
                            ])
                            ->columns(3)
                            ->collapsible()
                            ->cloneable(false) // Tidak bisa di-clone manual
                            ->deletable(false) // Tidak bisa dihapus manual
                            ->addable(false) // Tidak bisa ditambah manual
                            ->reorderable(false) // Tidak bisa diurutkan ulang
                            ->visible(fn ($get) => $get('volume_count') > 0)
                            ->columnSpanFull()
                    ])->visible(fn ($livewire) => $livewire instanceof \App\Filament\Resources\ComicResource\Pages\CreateComic),

                     Section::make('Volume Management')
                    ->schema([
                        Placeholder::make('existing_volumes_info')
                            ->label('')
                            ->content(function ($record) {
                                if ($record && $record->comicvol) {
                                    $totalVolumes = $record->comicvol->count();
                                    $collectedVolumes = $record->comicvol->where('is_collected', true)->count();
                                    return "📚 Total Volume: {$totalVolumes} | Terkumpul: {$collectedVolumes} | Belum: " . ($totalVolumes - $collectedVolumes);
                                }
                                return '📚 Belum ada volume yang tersimpan';
                            }),

                        Repeater::make('comicvol')
                            ->relationship()
                            ->label('Volume Details')
                            ->schema([
                                TextInput::make('volume')
                                    ->label('Vol.')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('volume_name')
                                    ->label('Judul Volume')
                                    ->placeholder('Masukkan judul volume (opsional)'),
                                Toggle::make('is_collected')
                                    ->label('Sudah Koleksi?')
                                    ->onIcon('heroicon-m-check-circle')
                                    ->offIcon('heroicon-m-x-circle')
                                    ->onColor('success')
                                    ->offColor('gray')
                            ])
                            ->columns(3)
                            ->collapsible()
                            ->cloneable(false)
                            ->addActionLabel('+ Tambah Volume Baru')
                            ->columnSpanFull()
                            ->orderColumn('volume')
                            ->defaultItems(0)
                    ])
                    ->visible(fn ($livewire) => !($livewire instanceof \App\Filament\Resources\ComicResource\Pages\CreateComic)),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("name")
                    ->searchable()
                    ->sortable(),
                TextColumn::make("genre")
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'shounen' => 'success',
                        'seinen' => 'warning',
                        'horror' => 'danger',
                        'america' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make("author.name")
                    ->searchable()
                    ->sortable(),
                ImageColumn::make("image")
                    ->disk('public')
                    ->height(50)
                    ->width(40),
                TextColumn::make("comicvol_count")
                    ->label("Total Volume")
                    ->counts('comicvol')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('collected_volumes')
                    ->label('Terkumpul')
                    ->getStateUsing(function ($record) {
                        return $record->comicvol()->where('is_collected', true)->count() . '/' . $record->comicvol()->count();
                    })
                    ->badge()
                    ->color('success'),
            ])
            ->filters([
                SelectFilter::make('genre')
                    ->options([
                        'shounen' => 'Shounen',
                        'seinen' => 'Seinen',
                        'horror' => 'Horror',
                        'america' => 'America'
                    ]),
                SelectFilter::make('collection_status')
                    ->label('Status Koleksi')
                    ->options([
                        'complete' => 'Lengkap',
                        'incomplete' => 'Belum Lengkap'
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['value'] === 'complete') {
                            $query->whereHas('comicvol', function ($q) {
                                $q->where('is_collected', false);
                            }, '=', 0);
                        } elseif ($data['value'] === 'incomplete') {
                            $query->whereHas('comicvol', function ($q) {
                                $q->where('is_collected', false);
                            }, '>', 0);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListComics::route('/'),
            'create' => Pages\CreateComic::route('/create'),
            'edit' => Pages\EditComic::route('/{record}/edit'),
        ];
    }
}
