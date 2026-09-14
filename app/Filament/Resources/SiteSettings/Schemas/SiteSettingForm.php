<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Configuracion')
                    ->persistTabInQueryString()
                    ->tabs([
                        Tab::make('Sitio')
                            ->schema([
                                TextInput::make('site_name')
                                    ->label('Nombre del sitio')
                                    ->helperText('Se usa para el titulo, Open Graph y datos estructurados.')
                                    ->required()
                                    ->maxLength(120),
                                FileUpload::make('header_logo')
                                    ->label('Logo del header')
                                    ->disk('public')
                                    ->directory('site-settings')
                                    ->visibility('public')
                                    ->image()
                                    ->imageEditor(),
                                TextInput::make('header_logo_alt')
                                    ->label('Alt del logo')
                                    ->required()
                                    ->maxLength(160),
                                FileUpload::make('favicon')
                                    ->label('Favicon')
                                    ->disk('public')
                                    ->directory('site-settings')
                                    ->visibility('public')
                                    ->acceptedFileTypes([
                                        'image/x-icon',
                                        'image/vnd.microsoft.icon',
                                        'image/png',
                                        'image/svg+xml',
                                        'image/webp',
                                    ])
                                    ->helperText('Formatos .ico, .png, .svg o .webp. Se recomienda 512x512px.'),
                            ])
                            ->columns(2),
                        Tab::make('SEO')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Meta titulo')
                                    ->required()
                                    ->maxLength(70),
                                Textarea::make('meta_description')
                                    ->label('Meta descripcion')
                                    ->rows(3)
                                    ->maxLength(170)
                                    ->columnSpanFull(),
                                Textarea::make('meta_keywords')
                                    ->label('Keywords')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                TextInput::make('canonical_url')
                                    ->label('URL canonica')
                                    ->url()
                                    ->maxLength(255),
                                Toggle::make('robots_index')
                                    ->label('Permitir indexacion'),
                                Toggle::make('robots_follow')
                                    ->label('Permitir follow'),
                            ])
                            ->columns(2),
                        Tab::make('Social')
                            ->schema([
                                TextInput::make('og_title')
                                    ->label('OG titulo')
                                    ->maxLength(70),
                                Textarea::make('og_description')
                                    ->label('OG descripcion')
                                    ->rows(3)
                                    ->maxLength(170),
                                FileUpload::make('og_image')
                                    ->label('Imagen social')
                                    ->disk('public')
                                    ->directory('site-settings')
                                    ->visibility('public')
                                    ->image()
                                    ->imageEditor(),
                                Select::make('twitter_card')
                                    ->label('Twitter card')
                                    ->options([
                                        'summary_large_image' => 'summary_large_image',
                                        'summary' => 'summary',
                                    ])
                                    ->required(),
                            ])
                            ->columns(2),
                        Tab::make('Analytics y Ads')
                            ->schema([
                                TextInput::make('google_tag_id')
                                    ->label('Google Tag Manager ID')
                                    ->placeholder('GTM-XXXXXXX'),
                                TextInput::make('google_analytics_id')
                                    ->label('Google Analytics ID')
                                    ->placeholder('G-XXXXXXXXXX'),
                                TextInput::make('facebook_pixel_id')
                                    ->label('Facebook Pixel ID'),
                            ])
                            ->columns(2),
                        Tab::make('Verificaciones')
                            ->schema([
                                Textarea::make('head_scripts')
                                    ->label('Scripts personalizados en head')
                                    ->helperText('Para metas de verificacion, pixeles o scripts que deban ir antes de cerrar head.')
                                    ->rows(8)
                                    ->columnSpanFull(),
                                Textarea::make('body_start_scripts')
                                    ->label('Scripts personalizados al inicio del body')
                                    ->helperText('Para snippets que deban cargarse inmediatamente despues de abrir body.')
                                    ->rows(8)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('Zapier')
                            ->schema([
                                Toggle::make('zapier_enabled')
                                    ->label('Activar webhook de Zapier'),
                                TextInput::make('zapier_webhook_url')
                                    ->label('Webhook URL')
                                    ->url()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                TextInput::make('zapier_secret')
                                    ->label('Secret opcional')
                                    ->password()
                                    ->revealable()
                                    ->maxLength(255),
                            ])
                            ->columns(2),
                        Tab::make('reCAPTCHA')
                            ->schema([
                                Toggle::make('recaptcha_enabled')
                                    ->label('Activar Google reCAPTCHA')
                                    ->helperText('Al activarlo, la landing mostrara el checkbox de reCAPTCHA y validara el token antes de guardar leads.'),
                                TextInput::make('recaptcha_site_key')
                                    ->label('Site key')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                TextInput::make('recaptcha_secret_key')
                                    ->label('Secret key')
                                    ->password()
                                    ->revealable()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Tab::make('Footer')
                            ->schema([
                                TextInput::make('footer_line_1')
                                    ->label('Linea 1')
                                    ->required(),
                                TextInput::make('footer_line_2')
                                    ->label('Linea 2')
                                    ->required(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
