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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        foreach (['banner_image', 'banner_image_mobile'] as $imageField) {
            if (array_key_exists($imageField, $data) && blank($data[$imageField])) {
                unset($data[$imageField]);
            }
        }

        return $data;
    }
}
