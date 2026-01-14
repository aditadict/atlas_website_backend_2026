<?php

namespace App\Filament\Resources\AboutPages\Pages;

use App\Filament\Resources\AboutPages\AboutPageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAboutPage extends EditRecord
{
    protected static string $resource = AboutPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
