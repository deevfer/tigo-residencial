<?php

namespace App\Filament\Resources\Leads\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Telefono')
                    ->searchable(),
                TextColumn::make('contact_preference')
                    ->label('Contacto')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'call' => 'Llamada',
                        'whatsapp' => 'WhatsApp',
                        default => $state,
                    })
                    ->searchable(),
                TextColumn::make('source')
                    ->label('Origen')
                    ->searchable(),
                TextColumn::make('zapier_status')
                    ->label('Zapier')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'disabled' => 'Deshabilitado',
                        'pending' => 'Pendiente',
                        'sent' => 'Enviado',
                        'failed' => 'Fallido',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('ip_address')
                    ->label('IP')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime(timezone: 'America/Guatemala')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime(timezone: 'America/Guatemala')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('contact_preference')
                    ->label('Preferencia')
                    ->options([
                        'call' => 'Llamada',
                        'whatsapp' => 'WhatsApp',
                    ]),
                SelectFilter::make('zapier_status')
                    ->label('Zapier')
                    ->options([
                        'disabled' => 'Deshabilitado',
                        'pending' => 'Pendiente',
                        'sent' => 'Enviado',
                        'failed' => 'Fallido',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
