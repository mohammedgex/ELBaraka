<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyHqPaymentRequestResource\Pages;
use App\Filament\Resources\CompanyHqPaymentRequestResource\RelationManagers;
use App\Models\CompanyHqPaymentRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyHqPaymentRequestResource extends Resource
{
    protected static ?string $model = CompanyHqPaymentRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $activeNavigationIcon = 'heroicon-s-credit-card';
    protected static ?string $navigationLabel = 'طلبات دفع بالمقر';
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
                    ->label('رقم هاتف المستخدم')
                    ->sortable(),
                    Tables\Columns\TextColumn::make('user.email')
                    ->label('البريد الالكتروني')
                    ->sortable(),
                    Tables\Columns\TextColumn::make('user.passport_number')
                    ->label('رقم جواز السفر')
                    ->sortable(),
                    Tables\Columns\TextColumn::make('user.country')
                    ->label('الدولة')
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
            'index' => Pages\ListCompanyHqPaymentRequests::route('/'),
            'create' => Pages\CreateCompanyHqPaymentRequest::route('/create'),
            'edit' => Pages\EditCompanyHqPaymentRequest::route('/{record}/edit'),
        ];
    }
}
