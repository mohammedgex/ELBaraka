<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $activeNavigationIcon = 'heroicon-s-banknotes';
    protected static ?string $navigationLabel = 'عمليات الدفع';
    protected static ?string $pluralLabel = 'المدفوعات';
    protected static ?string $modelLabel = 'دفع';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('reservation_id')
                    ->label('الحجز')
                    ->required()
                    ->relationship('reservation', 'id'),
                Forms\Components\Select::make('user_id')
                    ->label('اسم المستخدم')
                    ->required()
                    ->relationship('user', 'name'),

                Forms\Components\Section::make('الكاش')
                    ->schema([
                        Forms\Components\TextInput::make('amount')
                            ->label('المبلغ')
                            ->numeric()

                            ->suffix('جنية')
                            ->required()
                        ,
                        Forms\Components\TextInput::make('remaining_amount')
                            ->label('المبلغ المتبقي')
                            ->suffix('جنية')
                            ->required()
                            ->numeric(),

                    ])->columns(2),
                Forms\Components\Select::make('payment_status')
                    ->label('حالة الدفع')
                    ->options([
                        'تم الدفع' => 'تم الدفع',
                        'لم يتم الدفع' => 'لم يتم الدفع',
                    ])
                    ->required(),
                Forms\Components\Select::make('payment_type')
                    ->label('نوع الدفع')
                    ->options([
                        'card' => 'بالكارت',
                        'manual' => 'يدوي',

                    ])
                    // ->colors([
                    //     'card' => 'heroicon-s-check',
                    //     'manual' => 'heroicon-s-check',
                    // ])
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reservation_id')
                    ->numeric()
                    ->label('الحجز')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('اسم المستخدم')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.phone')
                    ->label('هاتف المستخدم'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('المبلغ')
                    ->suffix(' جنية')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\SelectColumn::make('payment_status')
                    ->label('حالة الدفع')
                    ->options([
                        'تم الدفع' => 'تم الدفع',
                        'لم يتم الدفع' => 'لم يتم الدفع',
                    ])
                ,
                Tables\Columns\TextColumn::make('remaining_amount')
                    ->label('المتبقي')
                    ->suffix(' جنية')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\SelectColumn::make('payment_type')
                    ->label('نوع الدفع')
                    ->options([
                        'card' => 'بالكارت',
                        'manual' => 'يدوي',

                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
