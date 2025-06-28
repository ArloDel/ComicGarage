<?php

namespace App\Filament\Resources\ComicResource\Pages;

use App\Filament\Resources\ComicResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateComic extends CreateRecord
{
    protected static string $resource = ComicResource::class;
}
