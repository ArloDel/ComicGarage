<?php

namespace App\Filament\Resources\ComicPurchaseResource\Pages;

use App\Filament\Resources\ComicPurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComicPurchases extends ListRecords
{
    protected static string $resource = ComicPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
