<?php

namespace App\Filament\Resources\Solutions;

use App\Filament\Resources\Solutions\Pages\ManageSolutions;
use App\Models\Solution;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class SolutionResource extends Resource
{
    protected static ?string $model = Solution::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'slug';

    public static function getRecordTitle($record): ?string
    {
        return $record->title['en'] ?? $record->slug;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Basic Information')
                    ->schema([
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('URL-friendly identifier'),

                        TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first'),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(3),

                Fieldset::make('Title')
                    ->schema([
                        TextInput::make('title.en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(500),

                        TextInput::make('title.id')
                            ->label('Title (Indonesian)')
                            ->required()
                            ->maxLength(500),
                    ]),

                Fieldset::make('Description')
                    ->schema([
                        Textarea::make('description.en')
                            ->label('Description (English)')
                            ->required()
                            ->rows(4),

                        Textarea::make('description.id')
                            ->label('Description (Indonesian)')
                            ->required()
                            ->rows(4),
                    ]),

                Fieldset::make('Images')
                    ->schema([
                        TextInput::make('icon')
                            ->label('Icon Name')
                            ->maxLength(255)
                            ->helperText('E.g., Server, Cloud, Database'),

                        FileUpload::make('image')
                            ->label('Solution Image')
                            ->image()
                            ->maxSize(2048)
                            ->directory('solutions'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title.en')
                    ->label('Title')
                    ->searchable()
                    ->limit(40),

                ImageColumn::make('image')
                    ->size(60),

                TextColumn::make('order')
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label('Active'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSolutions::route('/'),
        ];
    }
}
