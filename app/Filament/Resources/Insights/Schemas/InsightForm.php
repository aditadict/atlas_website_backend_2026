<?php

namespace App\Filament\Resources\Insights\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use RalphJSmit\Filament\SEO\SEO;

class InsightForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        // Main Content Section
                        Section::make('Article Content')
                            ->description('Main content of the insight article')
                            ->schema([
                                // Title Group
                                Group::make()
                                    ->schema([
                                        TextInput::make('title.en')
                                            ->label('Title (English)')
                                            ->required()
                                            ->maxLength(500),

                                        TextInput::make('title.id')
                                            ->label('Title (Indonesian)')
                                            ->required()
                                            ->maxLength(500),
                                    ])
                                    ->columns(2),

                                // Excerpt Group
                                Group::make()
                                    ->schema([
                                        Textarea::make('excerpt.en')
                                            ->label('Excerpt (English)')
                                            ->required()
                                            ->rows(3),

                                        Textarea::make('excerpt.id')
                                            ->label('Excerpt (Indonesian)')
                                            ->required()
                                            ->rows(3),
                                    ])
                                    ->columns(2),

                                // Content Tabs
                                RichEditor::make('content.en')
                                    ->label('Content (English)')
                                    ->required()
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('insights/attachments')
                                    ->toolbarButtons([
                                        'attachFiles',
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'codeBlock',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'table',
                                        'underline',
                                        'undo',
                                    ]),

                                RichEditor::make('content.id')
                                    ->label('Content (Indonesian)')
                                    ->required()
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('insights/attachments')
                                    ->toolbarButtons([
                                        'attachFiles',
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'codeBlock',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'table',
                                        'underline',
                                        'undo',
                                    ]),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                // Sidebar
                Group::make()
                    ->schema([
                        // Settings Section
                        Section::make('Settings')
                            ->schema([
                                TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->helperText('URL-friendly version of the title'),

                                Select::make('read_time')
                                    ->options([
                                        '3 min' => '3 minutes',
                                        '5 min' => '5 minutes',
                                        '7 min' => '7 minutes',
                                        '10 min' => '10 minutes',
                                        '15 min' => '15 minutes',
                                    ])
                                    ->required()
                                    ->default('5 min'),

                                Toggle::make('published')
                                    ->label('Published')
                                    ->helperText('Toggle to publish or unpublish the article')
                                    ->default(true),
                            ]),

                        // Category Section
                        Section::make('Category')
                            ->schema([
                                TextInput::make('category.en')
                                    ->label('English')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., Technology Trends'),

                                TextInput::make('category.id')
                                    ->label('Indonesian')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., Tren Teknologi'),
                            ]),

                        // Featured Image Section
                        Section::make('Featured Image')
                            ->schema([
                                FileUpload::make('featured_image')
                                    ->hiddenLabel()
                                    ->image()
                                    ->directory('insights')
                                    ->maxSize(2048)
                                    ->helperText('Upload a featured image (max 2MB)'),
                            ]),

                        // SEO Section - Collapsible
                        Section::make('SEO Settings')
                            ->description('Configure SEO metadata for search engines. Leave empty to use default values.')
                            ->schema([
                                SEO::make(['title', 'author', 'description', 'robots']),
                            ])
                            ->collapsible()
                            ->collapsed(),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }
}
