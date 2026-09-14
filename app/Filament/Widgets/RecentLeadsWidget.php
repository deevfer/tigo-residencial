<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Leads\LeadResource;
use App\Models\Lead;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentLeadsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    protected string $view = 'filament.widgets.recent-leads-table';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Leads recientes')
            ->query(Lead::query()->latest()->limit(5))
            ->paginated(false)
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre'),
                TextColumn::make('contact_preference')
                    ->label('Contacto')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'call' => 'Llamada',
                        'whatsapp' => 'WhatsApp',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'whatsapp' => 'success',
                        default => 'info',
                    }),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime(timezone: 'America/Guatemala', format: 'd/m H:i'),
            ])
            ->recordUrl(fn (Lead $record): string => LeadResource::getUrl('view', ['record' => $record]))
            ->emptyStateHeading('Aun no hay leads')
            ->emptyStateIcon('heroicon-o-users');
    }
}
