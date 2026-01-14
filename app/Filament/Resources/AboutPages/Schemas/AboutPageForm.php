<?php

namespace App\Filament\Resources\AboutPages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class AboutPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Metrics')
                    ->schema([
                        TextInput::make('years_experience')
                            ->label('Years of Experience')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0),

                        TextInput::make('systems_delivered')
                            ->label('Systems Delivered')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0),

                        TextInput::make('industries_served')
                            ->label('Industries Served')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                    ])
                    ->columns(3),

                Fieldset::make('Headline')
                    ->schema([
                        TextInput::make('headline.en')
                            ->label('Headline (English)')
                            ->maxLength(500),

                        TextInput::make('headline.id')
                            ->label('Headline (Indonesian)')
                            ->maxLength(500),
                    ]),

                Fieldset::make('Subheadline')
                    ->schema([
                        Textarea::make('subheadline.en')
                            ->label('Subheadline (English)')
                            ->rows(3),

                        Textarea::make('subheadline.id')
                            ->label('Subheadline (Indonesian)')
                            ->rows(3),
                    ]),

                Fieldset::make('Our Story')
                    ->schema([
                        Textarea::make('story.en')
                            ->label('Story (English)')
                            ->rows(6)
                            ->helperText('The company story/about text. Use \n for line breaks.'),

                        Textarea::make('story.id')
                            ->label('Story (Indonesian)')
                            ->rows(6)
                            ->helperText('Cerita/tentang perusahaan. Gunakan \n untuk baris baru.'),
                    ]),

                Fieldset::make('Mission')
                    ->schema([
                        Textarea::make('mission.en')
                            ->label('Mission (English)')
                            ->rows(4),

                        Textarea::make('mission.id')
                            ->label('Mission (Indonesian)')
                            ->rows(4),
                    ]),

                Fieldset::make('Vision')
                    ->schema([
                        Textarea::make('vision.en')
                            ->label('Vision (English)')
                            ->rows(4),

                        Textarea::make('vision.id')
                            ->label('Vision (Indonesian)')
                            ->rows(4),
                    ]),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
