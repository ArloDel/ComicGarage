<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;

class Wishlist extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.wishlist';

    public $defaultAction = 'onboarding';


    protected function getHeaderActions(): array
    {
       return [

    ];
    }


}
