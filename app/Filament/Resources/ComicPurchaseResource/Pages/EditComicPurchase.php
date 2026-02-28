<?php

namespace App\Filament\Resources\ComicPurchaseResource\Pages;

use App\Filament\Resources\ComicPurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComicPurchase extends EditRecord
{
    protected static string $resource = ComicPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
