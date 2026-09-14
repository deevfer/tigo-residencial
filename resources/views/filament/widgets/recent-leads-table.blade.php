@php
    use Filament\Support\Facades\FilamentView;
    use Filament\Widgets\View\WidgetsRenderHook;
@endphp

<x-filament-widgets::widget class="fi-wi-table fi-wi-table-match-height">
    <style>
        .fi-wi-table-match-height {
            height: 100%;
        }

        .fi-wi-table-match-height > .fi-ta,
        .fi-wi-table-match-height > .fi-ta > .fi-ta-ctn {
            height: 100%;
        }
    </style>

    {{ FilamentView::renderHook(WidgetsRenderHook::TABLE_WIDGET_START, scopes: static::class) }}

    {{ $this->table ?? null }}

    {{ FilamentView::renderHook(WidgetsRenderHook::TABLE_WIDGET_END, scopes: static::class) }}
</x-filament-widgets::widget>
