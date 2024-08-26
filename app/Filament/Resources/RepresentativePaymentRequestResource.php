<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RepresentativePaymentRequestResource\Pages;
use App\Filament\Resources\RepresentativePaymentRequestResource\RelationManagers;
use App\Models\RepresentativePaymentRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RepresentativePaymentRequestResource extends Resource
{
    protected static ?string $model = RepresentativePaymentRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $activeNavigationIcon = 'heroicon-s-banknotes';
    protected static ?string $navigationLabel = 'طلبات دفع للمندوب';
    protected static ?string $pluralLabel = 'الطلبات';
    protected static ?string $modelLabel = 'طلب';

    protected static ?string $navigationGroup = 'طلبات الدفع اليدوية';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->label('اسم المستخدم')
                    ->relationship('user', 'name'),
                Forms\Components\Textarea::make('address_text')
                    ->label('العنوان')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('address_map')
                    ->label('الاحداثيات')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date')
                    ->label('التاريخ')
                    ->required(),
                Forms\Components\TimePicker::make('time')
                    ->label('التوقيت')
                    ->format('H:i A')
                    ->withoutSeconds()
                    ->placeholder('اختيار الوقت')
                    ->required(),
                Forms\Components\TextInput::make('representative_fee')
                    ->label('رسوم الخدمة')
                    ->suffix('جنية')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('اسم المستخدم')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.phone')
                    ->label('رقم الهاتف')
                    ->sortable(),
                Tables\Columns\TextColumn::make('address_map')
                    ->label('الاحداثيات')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address_text')
                    ->label('العنوان')
                    ->searchable(),
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
            'index' => Pages\ListRepresentativePaymentRequests::route('/'),
            'create' => Pages\CreateRepresentativePaymentRequest::route('/create'),
            'edit' => Pages\EditRepresentativePaymentRequest::route('/{record}/edit'),
        ];
    }
}
