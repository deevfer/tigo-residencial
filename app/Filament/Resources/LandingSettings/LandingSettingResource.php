<?php

namespace App\Filament\Resources\LandingSettings;

use App\Filament\Resources\LandingSettings\Pages\EditLandingSetting;
use App\Filament\Resources\LandingSettings\Pages\ListLandingSettings;
use App\Filament\Resources\LandingSettings\Schemas\LandingSettingForm;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;

class LandingSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $slug = 'landing-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'Configuracion landing';

    protected static ?string $modelLabel = 'configuracion landing';

    protected static ?string $pluralModelLabel = 'configuracion landing';

    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getNavigationUrl(): string
    {
        return static::getUrl('edit', [
            'record' => SiteSetting::current(),
        ]);
    }

    public static function form(Schema $schema): Schema
    {
        return LandingSettingForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLandingSettings::route('/'),
            'edit' => EditLandingSetting::route('/{record}/edit'),
        ];
    }
}
