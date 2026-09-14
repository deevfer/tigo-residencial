<?php

namespace App\Filament\Resources\LandingSettings\Pages;

use App\Filament\Resources\LandingSettings\LandingSettingResource;
use App\Models\SiteSetting;
use Filament\Resources\Pages\ListRecords;

class ListLandingSettings extends ListRecords
{
    protected static string $resource = LandingSettingResource::class;

    public function mount(): void
    {
        $this->redirect(LandingSettingResource::getUrl('edit', [
            'record' => SiteSetting::current(),
        ]));
    }
}
