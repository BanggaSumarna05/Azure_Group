<?php

namespace App\Filament\Resources\Portfolios\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PortfolioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')->required()->unique(ignoreRecord: true),
                TextInput::make('tagline'),
                TextInput::make('sector')->required(),
                RichEditor::make('description')->required()->columnSpanFull(),
                TextInput::make('website_url')->url(),
                SpatieMediaLibraryFileUpload::make('logo')->collection('logo')->image(),
                SpatieMediaLibraryFileUpload::make('cover')->collection('cover')->image(),
                TextInput::make('sort_order')->numeric()->default(0),
                Toggle::make('is_active')->default(true),
            ]);
    }
}
