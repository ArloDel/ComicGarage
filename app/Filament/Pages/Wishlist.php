<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Wishlist extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.wishlist';


    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
