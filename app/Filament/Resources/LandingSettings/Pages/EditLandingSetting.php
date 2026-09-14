<?php

namespace App\Filament\Resources\LandingSettings\Pages;

use App\Filament\Resources\LandingSettings\LandingSettingResource;
use Filament\Resources\Pages\EditRecord;

class EditLandingSetting extends EditRecord
{
    protected static string $resource = LandingSettingResource::class;

    protected static ?string $title = 'Configuracion landing';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
