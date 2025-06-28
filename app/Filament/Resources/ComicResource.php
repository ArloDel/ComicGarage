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
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
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
                TextInput::make("name"),
                Select::make("genre")
                ->options([
                    'shounen' => 'Shounen',
                    'seinen' => 'Seinen',
                    'horror' => 'Horror',
                    'america' => 'America'
                ]),
                Select::make("author_id")
                ->relationship('author', 'name')
                ->searchable()
                ->preload()
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
                    ->maxSize(2048) // 2MB max
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
                Repeater::make('comicvol')
                    ->relationship()
                    ->columnSpanFull()
                    ->schema([
                    TextInput::make('volume')
                    ->label('Vol.')
                    ->numeric()
                    ->required(),
                    TextInput::make('volume_name')
                    ->label('Judul'),
                    Toggle::make('is_collected')
                   ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user')

                ])
                ->grid(4) // Membuat layout grid

                ->addActionLabel('+ Volume Baru')


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                TextColumn::make("name")
                ->searchable(),
                TextColumn::make("genre"),
                TextColumn::make("author.name")->searchable(),
                 ImageColumn::make("image")
                    ->disk('public')
                    ->height(50),
                TextColumn::make("comicvol_count")
                ->label("Total Volume")
                ->counts('comicvol'),
            ])
            ->filters([
                SelectFilter::make('genre')
                ->options([
                    'shounen' => 'Shounen',
                    'seinen' => 'Seinen',
                    'horror' => 'Horror',
                    'america' => 'America'
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
