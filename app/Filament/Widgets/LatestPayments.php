<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PaymentResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestPayments extends BaseWidget
{


    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PaymentResource::getEloquentQuery()
            )
            ->heading('اخر المدفوعات في التطبيق')
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('اسم المستخدم')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.phone')
                    ->label('هاتف المستخدم'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('المبلغ')
                    ->suffix(' جنية')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('حالة الدفع')
                    
                ,
                Tables\Columns\TextColumn::make('remaining_amount')
                    ->label('المتبقي')
                    ->suffix(' جنية')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('payment_type')
                    ->label('نوع الدفع')
                    ,


            ]);
    }

}
