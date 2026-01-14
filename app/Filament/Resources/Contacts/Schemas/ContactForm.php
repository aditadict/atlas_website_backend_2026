<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('company')
                    ->maxLength(255),
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Select::make('service')
                    ->options([
                        'web_development' => 'Web Development',
                        'mobile_development' => 'Mobile Development',
                        'cloud_solutions' => 'Cloud Solutions',
                        'ai_ml' => 'AI & Machine Learning',
                        'consulting' => 'Consulting',
                        'other' => 'Other',
                    ])
                    ->searchable(),
                Textarea::make('message')
                    ->required()
                    ->columnSpanFull()
                    ->rows(5),
                Select::make('language')
                    ->options([
                        'en' => 'English',
                        'id' => 'Indonesian',
                    ])
                    ->required()
                    ->default('en'),
                Select::make('status')
                    ->options([
                        'new' => 'New',
                        'read' => 'Read',
                        'responded' => 'Responded',
                        'archived' => 'Archived',
                    ])
                    ->required()
                    ->default('new'),
            ]);
    }
}
