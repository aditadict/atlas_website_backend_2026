<?php

namespace App\Filament\Resources\Insights;

use App\Filament\Resources\Insights\Pages\CreateInsight;
use App\Filament\Resources\Insights\Pages\EditInsight;
use App\Filament\Resources\Insights\Pages\ListInsights;
use App\Filament\Resources\Insights\Schemas\InsightForm;
use App\Filament\Resources\Insights\Tables\InsightsTable;
use App\Models\Insight;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InsightResource extends Resource
{
    protected static ?string $model = Insight::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'slug';

    public static function getRecordTitle($record): ?string
    {
        return $record->title['en'] ?? $record->slug;
    }

    public static function form(Schema $schema): Schema
    {
        return InsightForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InsightsTable::configure($table);
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
            'index' => ListInsights::route('/'),
            'create' => CreateInsight::route('/create'),
            'edit' => EditInsight::route('/{record}/edit'),
        ];
    }
}
