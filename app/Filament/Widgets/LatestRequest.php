<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\RepresentativePaymentRequestResource;

use Filament\Widgets\TableWidget as BaseWidget;

class LatestRequest extends BaseWidget
{
    protected static ?int $sort = 3;
    public function table(Table $table): Table
    {
        return $table
        ->query(
            RepresentativePaymentRequestResource::getEloquentQuery()
        )
        ->heading('أحدث طلبات الدفع بمقر الشركة')
        ->defaultSort('created_at','desc')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('اسم المستخدم')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.phone')
                    ->label('رقم الهاتف')
                    ->sortable(),
                Tables\Columns\TextColumn::make('address_map')
                    ->label('الاحداثيات')
                    ,
                Tables\Columns\TextColumn::make('address_text')
                    ->label('العنوان')
                    ,
                Tables\Columns\TextColumn::make('date')
                    ->label('التاريخ')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time')->label('التوقيت'),
                Tables\Columns\TextColumn::make('representative_fee')
                    ->numeric()
                    ->label('رسوم الخدمة')
                    ->suffix(' جنية')
                    ->sortable(),
            ]);
    }
}
