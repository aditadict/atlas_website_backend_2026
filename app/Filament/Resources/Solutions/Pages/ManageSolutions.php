<?php

namespace App\Filament\Resources\Solutions\Pages;

use App\Filament\Resources\Solutions\SolutionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageSolutions extends ManageRecords
{
    protected static string $resource = SolutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
