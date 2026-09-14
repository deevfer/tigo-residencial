<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use App\Support\DeviceDetector;
use Filament\Widgets\ChartWidget;

class LeadsByDeviceWidget extends ChartWidget
{
    protected ?string $heading = 'Leads por dispositivo';

    protected ?string $maxHeight = '260px';

    protected static ?int $sort = 3;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $userAgents = Lead::pluck('user_agent');

        $mobile = $userAgents->filter(fn (?string $userAgent) => DeviceDetector::isMobile($userAgent))->count();
        $desktop = $userAgents->count() - $mobile;

        return [
            'datasets' => [[
                'data' => [$mobile, $desktop],
                'backgroundColor' => ['#2563eb', '#a855f7'],
                'borderWidth' => 0,
            ]],
            'labels' => ['Movil', 'Escritorio'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
