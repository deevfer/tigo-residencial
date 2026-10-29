<?php

namespace App\Filament\Resources\LandingSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class LandingSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Configuracion landing')
                    ->persistTabInQueryString()
                    ->tabs([
                        Tab::make('Banner')
                            ->schema([
                                FileUpload::make('banner_image')
                                    ->label('Banner')
                                    ->disk('public')
                                    ->directory('site-settings')
                                    ->visibility('public')
                                    ->image()
                                    ->imageEditor(),
                                TextInput::make('banner_alt')
                                    ->label('Alt del banner')
                                    ->required()
                                    ->maxLength(220),
                                TextInput::make('banner_caption')
                                    ->label('Pie de foto del banner')
                                    ->maxLength(220)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Tab::make('Titular')
                            ->schema([
                                TextInput::make('headline_prefix')
                                    ->label('Titular: texto inicial')
                                    ->required(),
                                Textarea::make('headline_highlight')
                                    ->label('Titular destacado')
                                    ->rows(3)
                                    ->required(),
                                TextInput::make('headline_suffix')
                                    ->label('Titular: texto final')
                                    ->required(),
                            ])
                            ->columns(2),
                        Tab::make('Formulario')
                            ->schema([
                                TextInput::make('form_heading')
                                    ->label('Titulo del formulario')
                                    ->required()
                                    ->columnSpanFull(),
                                TextInput::make('name_label')
                                    ->label('Label nombre')
                                    ->required(),
                                TextInput::make('name_placeholder')
                                    ->label('Placeholder nombre')
                                    ->required(),
                                TextInput::make('phone_label')
                                    ->label('Label telefono')
                                    ->required(),
                                TextInput::make('phone_placeholder')
                                    ->label('Placeholder telefono')
                                    ->required(),
                            ])
                            ->columns(2),
                        Tab::make('CTAs')
                            ->schema([
                                TextInput::make('call_button_text')
                                    ->label('Texto boton llamada')
                                    ->required(),
                                TextInput::make('microcopy')
                                    ->label('Texto auxiliar')
                                    ->required()
                                    ->columnSpanFull(),
                                Toggle::make('whatsapp_enabled')
                                    ->label('Mostrar boton de WhatsApp')
                                    ->helperText('Permite activar u ocultar el CTA de WhatsApp en la landing.')
                                    ->default(true)
                                    ->columnSpanFull(),
                                TextInput::make('whatsapp_button_text')
                                    ->label('Texto boton WhatsApp')
                                    ->required(),
                                TextInput::make('whatsapp_url')
                                    ->label('URL WhatsApp')
                                    ->url()
                                    ->required(),
                                Textarea::make('success_message')
                                    ->label('Mensaje despues de enviar el formulario')
                                    ->helperText('Se muestra cuando el lead se guarda correctamente y no se redirige a WhatsApp.')
                                    ->rows(3)
                                    ->required()
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                                Textarea::make('duplicate_message')
                                    ->label('Mensaje para numero ya registrado')
                                    ->helperText('Se muestra cuando el telefono ya existe y no se crea un lead duplicado.')
                                    ->rows(3)
                                    ->required()
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
