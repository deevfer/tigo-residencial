<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SiteSettingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('site_name')
                    ->label('Sitio'),
                ImageEntry::make('favicon')
                    ->label('Favicon')
                    ->height(40)
                    ->placeholder('-'),
                TextEntry::make('meta_title')
                    ->label('Meta titulo'),
                TextEntry::make('canonical_url')
                    ->label('URL canonica')
                    ->placeholder('-'),
                IconEntry::make('zapier_enabled')
                    ->label('Zapier activo')
                    ->boolean(),
                TextEntry::make('zapier_webhook_url')
                    ->label('Webhook Zapier')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime(),
            ]);
    }
}
