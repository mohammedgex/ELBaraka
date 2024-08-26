<?php

namespace App\Filament\Widgets;

use App\Models\Bus;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TodayStatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('اجمالي عدد وسائل النقل', Bus::count())
                ->chart([
                    7,
                    2,
                    10,
                    3,
                    15,
                    4,
                    17
                ]),
            Stat::make('اجمالي عدد المستخدمين', User::count())
                ->chart([
                    7,
                    2,
                    10,
                    3,
                    15,
                    4,
                    17
                ]),
            Stat::make('عدد المدفوعات الكلية', Payment::count())
                ->chart([
                    7,
                    2,
                    10,
                    3,
                    15,
                    4,
                    15
                ]),

            Stat::make('اجمالي عدد الحجوزات الكلية', Reservation::count())
                ->chart([
                    7,
                    2,
                    10,
                    3,
                    15,
                    4,
                    17
                ]),

        ];
    }
}
