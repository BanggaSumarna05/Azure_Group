<?php

namespace App\Filament\Resources\CareerApplications;

use App\Filament\Resources\CareerApplications\Pages\EditCareerApplication;
use App\Filament\Resources\CareerApplications\Pages\ListCareerApplications;
use App\Filament\Resources\CareerApplications\Pages\ViewCareerApplication;
use App\Models\CareerApplication;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CareerApplicationResource extends Resource
{
    protected static ?string $model = CareerApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|\UnitEnum|null $navigationGroup = 'Karir';

    protected static ?string $navigationLabel = 'Lamaran Masuk';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([

            Fieldset::make('Informasi Pelamar')
                ->schema([
                    TextInput::make('name')->label('Nama Lengkap')->disabled(),
                    TextInput::make('email')->label('Email')->disabled(),
                    TextInput::make('phone')->label('No. Telepon')->disabled(),
                    Select::make('career_id')
                        ->label('Posisi Dilamar')
                        ->relationship('career', 'title')
                        ->placeholder('General Application')
                        ->disabled(),
                ])
                ->columns(2),

            Fieldset::make('Cover Letter')
                ->schema([
                    Textarea::make('message')->label('')->rows(5)->disabled()->columnSpanFull(),
                ]),

            Fieldset::make('Status & Catatan Internal')
                ->schema([
                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'new'         => 'New',
                            'reviewed'    => 'Reviewed',
                            'shortlisted' => 'Shortlisted',
                            'rejected'    => 'Rejected',
                        ])
                        ->required(),
                    Textarea::make('notes')->label('Catatan Internal')->rows(4)->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y, H:i')->sortable(),
                TextColumn::make('name')->label('Pelamar')->searchable()->weight('bold'),
                TextColumn::make('email')->label('Email')->searchable()->copyable(),
                TextColumn::make('phone')->label('Telepon')->copyable(),
                TextColumn::make('career.title')->label('Posisi')->default('General')->badge()->color('gray'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new'         => 'info',
                        'reviewed'    => 'warning',
                        'shortlisted' => 'success',
                        'rejected'    => 'danger',
                        default       => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                TextColumn::make('cv_path')->label('CV')->formatStateUsing(fn () => 'PDF')->badge()->color('success'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'new'         => 'New',
                        'reviewed'    => 'Reviewed',
                        'shortlisted' => 'Shortlisted',
                        'rejected'    => 'Rejected',
                    ]),
                SelectFilter::make('career_id')
                    ->label('Posisi')
                    ->relationship('career', 'title')
                    ->placeholder('Semua Posisi'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('download_cv')
                    ->label('CV')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->color('gray')
                    ->url(fn (CareerApplication $record): string =>
                        route('admin.career-applications.cv', $record)
                    )
                    ->openUrlInNewTab(),
            ])
            ->defaultSort('created_at', 'desc')
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCareerApplications::route('/'),
            'view'  => ViewCareerApplication::route('/{record}'),
            'edit'  => EditCareerApplication::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
