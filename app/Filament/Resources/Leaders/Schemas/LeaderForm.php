<?php

namespace App\Filament\Resources\Leaders\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LeaderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                TextInput::make('position')->required(),
                Textarea::make('bio')->rows(4)->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('photo')->collection('photo')->image(),
                TextInput::make('linkedin_url')->url(),
                TextInput::make('sort_order')->numeric()->default(0),
                Toggle::make('is_active')->default(true),
            ]);
    }
}
