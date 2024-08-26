<?php

namespace App\Filament\Widgets;
use App\Filament\Resources\CompanyHqPaymentRequestResource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
class LatestAsk extends BaseWidget
{
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                CompanyHqPaymentRequestResource::getEloquentQuery()
            )
            ->heading('أحدث طلبات دفع عن طريق مندوب')
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('اسم المستخدم')
                ,
                Tables\Columns\TextColumn::make('user.phone')
                    ->label('رقم هاتف المستخدم')
                ,
                Tables\Columns\TextColumn::make('user.email')
                    ->label('البريد الالكتروني')
                ,
                Tables\Columns\TextColumn::make('user.passport_number')
                    ->label('رقم جواز السفر')
                ,
                Tables\Columns\TextColumn::make('user.country')
                    ->label('الدولة')
                ,
            ]);
    }
}
