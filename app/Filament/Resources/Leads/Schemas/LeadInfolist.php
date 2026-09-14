<?php

namespace App\Filament\Resources\Leads\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LeadInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contacto')
                    ->icon('heroicon-o-user-circle')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nombre y apellido')
                            ->icon('heroicon-o-user')
                            ->weight('bold')
                            ->size('lg')
                            ->copyable(),
                        TextEntry::make('phone')
                            ->label('Telefono')
                            ->icon('heroicon-o-phone')
                            ->copyable()
                            ->url(fn (string $state): string => 'tel:'.$state),
                        TextEntry::make('contact_preference')
                            ->label('Preferencia de contacto')
                            ->badge()
                            ->icon(fn (string $state): string => match ($state) {
                                'whatsapp' => 'heroicon-o-chat-bubble-left-right',
                                default => 'heroicon-o-phone-arrow-up-right',
                            })
                            ->color(fn (string $state): string => match ($state) {
                                'whatsapp' => 'success',
                                default => 'info',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'call' => 'Llamada',
                                'whatsapp' => 'WhatsApp',
                                default => $state,
                            }),
                        TextEntry::make('source')
                            ->label('Origen')
                            ->badge()
                            ->color('gray')
                            ->icon('heroicon-o-globe-alt'),
                    ]),

                Section::make('Estado de Zapier')
                    ->icon('heroicon-o-bolt')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('zapier_status')
                            ->label('Estado')
                            ->badge()
                            ->icon(fn (string $state): string => match ($state) {
                                'sent' => 'heroicon-o-check-circle',
                                'failed' => 'heroicon-o-x-circle',
                                'pending' => 'heroicon-o-clock',
                                default => 'heroicon-o-minus-circle',
                            })
                            ->color(fn (string $state): string => match ($state) {
                                'sent' => 'success',
                                'failed' => 'danger',
                                'pending' => 'warning',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'disabled' => 'Deshabilitado',
                                'pending' => 'Pendiente',
                                'sent' => 'Enviado',
                                'failed' => 'Fallido',
                                default => $state,
                            }),
                        TextEntry::make('zapier_sent_at')
                            ->label('Enviado a Zapier')
                            ->icon('heroicon-o-clock')
                            ->dateTime(timezone: 'America/Guatemala')
                            ->placeholder('Aun no enviado'),
                        TextEntry::make('zapier_response_code')
                            ->label('Codigo de respuesta')
                            ->badge()
                            ->color(fn (?string $state): string => match (true) {
                                $state === null => 'gray',
                                (int) $state >= 200 && (int) $state < 300 => 'success',
                                default => 'danger',
                            })
                            ->visible(fn (?string $state): bool => filled($state)),
                        TextEntry::make('zapier_error')
                            ->label('Error')
                            ->icon('heroicon-o-exclamation-triangle')
                            ->color('danger')
                            ->columnSpanFull()
                            ->visible(fn (?string $state): bool => filled($state)),
                        TextEntry::make('zapier_response_body')
                            ->label('Respuesta')
                            ->columnSpanFull()
                            ->color('gray')
                            ->visible(fn (?string $state): bool => filled($state)),
                    ]),

                Section::make('Metadatos')
                    ->icon('heroicon-o-information-circle')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextEntry::make('ip_address')
                            ->label('Direccion IP')
                            ->icon('heroicon-o-map-pin')
                            ->copyable()
                            ->placeholder('-'),
                        Grid::make(2)
                            ->columnSpanFull()
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Creado')
                                    ->icon('heroicon-o-calendar')
                                    ->dateTime(timezone: 'America/Guatemala'),
                                TextEntry::make('updated_at')
                                    ->label('Actualizado')
                                    ->icon('heroicon-o-calendar')
                                    ->dateTime(timezone: 'America/Guatemala'),
                            ]),
                        TextEntry::make('user_agent')
                            ->label('Navegador')
                            ->icon('heroicon-o-device-phone-mobile')
                            ->color('gray')
                            ->columnSpanFull()
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
