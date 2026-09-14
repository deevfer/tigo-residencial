<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use App\Models\PageView;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SiteOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Visitas al sitio', number_format(PageView::count()))
                ->description(number_format(PageView::whereDate('created_at', today())->count()) . ' hoy')
                ->descriptionIcon('heroicon-m-eye')
                ->chart($this->trend(PageView::class))
                ->color('info'),

            Stat::make('Leads registrados', number_format(Lead::count()))
                ->description(number_format(Lead::whereDate('created_at', today())->count()) . ' hoy')
                ->descriptionIcon('heroicon-m-user-plus')
                ->chart($this->trend(Lead::class))
                ->color('success'),

            $this->conversionStat(),
        ];
    }

    private function conversionStat(): Stat
    {
        $visits = PageView::where('created_at', '>=', now()->subDays(30))->count();
        $leads = Lead::where('created_at', '>=', now()->subDays(30))->count();
        $rate = $visits > 0 ? round(($leads / $visits) * 100, 1) : 0;

        return Stat::make('Tasa de conversion', $rate . '%')
            ->description(number_format($leads) . ' leads / ' . number_format($visits) . ' visitas (30 dias)')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('warning');
    }

    /**
     * @return array<int>
     */
    private function trend(string $model): array
    {
        return collect(range(6, 0))
            ->map(fn (int $daysAgo) => $model::whereDate('created_at', now()->subDays($daysAgo))->count())
            ->all();
    }
}
