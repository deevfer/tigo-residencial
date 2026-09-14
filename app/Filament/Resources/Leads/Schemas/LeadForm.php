<?php

namespace App\Filament\Resources\Leads\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre y apellido')
                    ->maxLength(120)
                    ->required(),
                TextInput::make('phone')
                    ->label('Telefono')
                    ->tel()
                    ->length(8)
                    ->numeric()
                    ->required(),
                Select::make('contact_preference')
                    ->label('Preferencia')
                    ->options([
                        'call' => 'Llamada',
                        'whatsapp' => 'WhatsApp',
                    ])
                    ->required()
                    ->default('call'),
                TextInput::make('source')
                    ->label('Origen')
                    ->required()
                    ->default('residencial'),
                Select::make('zapier_status')
                    ->label('Estado Zapier')
                    ->options([
                        'disabled' => 'Deshabilitado',
                        'pending' => 'Pendiente',
                        'sent' => 'Enviado',
                        'failed' => 'Fallido',
                    ])
                    ->default('disabled')
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('zapier_response_code')
                    ->label('Codigo Zapier')
                    ->numeric(),
                TextInput::make('ip_address')
                    ->label('IP'),
                Textarea::make('user_agent')
                    ->label('Navegador')
                    ->columnSpanFull(),
                Textarea::make('zapier_error')
                    ->label('Error Zapier')
                    ->columnSpanFull(),
                Textarea::make('zapier_response_body')
                    ->label('Respuesta Zapier')
                    ->columnSpanFull(),
            ]);
    }
}
