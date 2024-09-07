<?php

namespace App\Filament\Widgets;
use App\Models\User;
use App\Models\Bus;
use App\Models\Reservation;
use App\Models\Payment;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('اجمالي المدفوعات', number_format(
                Payment::where('payment_status', 'تم الدفع')
                    ->sum('amount'),
                2,
                '.',
                ','
            ))
                ->icon('heroicon-o-currency-dollar')
                ->chart([
                    // You can adjust the chart data if needed
                    7,
                    2,
                    10,
                    3,
                    15,
                    4,
                    15
                ]),
            Stat::make('عدد المستخدمين اليوم', User::whereDate('created_at', Carbon::today())->count())
                ->chart([
                    7,
                    2,
                    10,
                    3,
                    15,
                    4,
                    15
                ]),

            Stat::make('عدد المدفوعات اليوم', Payment::whereDate('created_at', Carbon::today())->count())
                ->chart([
                    7,
                    2,
                    10,
                    3,
                    15,
                    4,
                    15
                ]),
            Stat::make('عدد الحجوزات اليوم', Reservation::whereDate('created_at', Carbon::today())->count())
                ->chart([
                    7,
                    2,
                    10,
                    3,
                    15,
                    4,
                    15
                ]),





        ];
    }
}
