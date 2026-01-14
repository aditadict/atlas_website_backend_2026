<?php

namespace App\Filament\Resources\AboutPages\Pages;

use App\Filament\Resources\AboutPages\AboutPageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAboutPages extends ListRecords
{
    protected static string $resource = AboutPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
