<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Project Settings')
                    ->schema([
                        Toggle::make('featured')
                            ->required()
                            ->default(false),

                        TextInput::make('order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                    ])
                    ->columns(2),

                Fieldset::make('Industry & System Type')
                    ->schema([
                        Select::make('industry.en')
                            ->label('Industry (English)')
                            ->options([
                                'E-Commerce' => 'E-Commerce',
                                'Healthcare' => 'Healthcare',
                                'Finance' => 'Finance',
                                'Manufacturing' => 'Manufacturing',
                                'Education' => 'Education',
                                'Logistics' => 'Logistics',
                                'Retail' => 'Retail',
                                'Government' => 'Government',
                                'Other' => 'Other',
                            ])
                            ->required()
                            ->searchable(),

                        Select::make('industry.id')
                            ->label('Industry (Indonesian)')
                            ->options([
                                'E-Commerce' => 'E-Commerce',
                                'Kesehatan' => 'Kesehatan',
                                'Keuangan' => 'Keuangan',
                                'Manufaktur' => 'Manufaktur',
                                'Pendidikan' => 'Pendidikan',
                                'Logistik' => 'Logistik',
                                'Retail' => 'Retail',
                                'Pemerintah' => 'Pemerintah',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->searchable(),

                        Select::make('system_type.en')
                            ->label('System Type (English)')
                            ->options([
                                'Web Application' => 'Web Application',
                                'Mobile Application' => 'Mobile Application',
                                'Enterprise System' => 'Enterprise System',
                                'Learning Management System' => 'Learning Management System',
                                'Mobile & Web Application' => 'Mobile & Web Application',
                                'Desktop Application' => 'Desktop Application',
                                'Cloud Platform' => 'Cloud Platform',
                            ])
                            ->required()
                            ->searchable(),

                        Select::make('system_type.id')
                            ->label('System Type (Indonesian)')
                            ->options([
                                'Aplikasi Web' => 'Aplikasi Web',
                                'Aplikasi Mobile' => 'Aplikasi Mobile',
                                'Sistem Enterprise' => 'Sistem Enterprise',
                                'Sistem Manajemen Pembelajaran' => 'Sistem Manajemen Pembelajaran',
                                'Aplikasi Mobile & Web' => 'Aplikasi Mobile & Web',
                                'Aplikasi Desktop' => 'Aplikasi Desktop',
                                'Platform Cloud' => 'Platform Cloud',
                            ])
                            ->required()
                            ->searchable(),
                    ])
                    ->columns(2),

                Fieldset::make('Title')
                    ->schema([
                        TextInput::make('title.en')
                            ->label('Title (English)')
                            ->required()
                            ->maxLength(500)
                            ->columnSpanFull(),

                        TextInput::make('title.id')
                            ->label('Title (Indonesian)')
                            ->required()
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ]),

                Fieldset::make('Scope')
                    ->schema([
                        Textarea::make('scope.en')
                            ->label('Scope (English)')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),

                        Textarea::make('scope.id')
                            ->label('Scope (Indonesian)')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),

                Fieldset::make('Outcome')
                    ->schema([
                        Textarea::make('outcome.en')
                            ->label('Outcome (English)')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),

                        Textarea::make('outcome.id')
                            ->label('Outcome (Indonesian)')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
