<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Pet;
use App\Models\Vaccination;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $pending = Appointment::where('status', 'pending')->count();
        $today = Appointment::whereDate('date', today())->count();
        $pets = Pet::count();

        $vaccDue = Vaccination::whereNotNull('next_due_at')
            ->whereDate('next_due_at', '<=', now()->addDays(30))
            ->count();

        return [
            Stat::make('Onay Bekleyen Randevu', $pending)
                ->description('İşlem bekliyor')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pending > 0 ? 'warning' : 'success'),

            Stat::make('Bugünkü Randevular', $today)
                ->description('Bugün için planlı')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),

            Stat::make('Kayıtlı Dostlar', $pets)
                ->description('Toplam evcil hayvan')
                ->descriptionIcon('heroicon-m-heart')
                ->color('success'),

            Stat::make('Yaklaşan Aşılar', $vaccDue)
                ->description('30 gün içinde')
                ->descriptionIcon('heroicon-m-beaker')
                ->color($vaccDue > 0 ? 'danger' : 'success'),
        ];
    }
}
