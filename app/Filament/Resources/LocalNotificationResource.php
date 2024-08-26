<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocalNotificationResource\Pages;
use App\Filament\Resources\LocalNotificationResource\RelationManagers;
use App\Models\LocalNotification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LocalNotificationResource extends Resource
{
    protected static ?string $model = LocalNotification::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';
    protected static ?string $navigationGroup = 'اعدادات التطبيق';

    protected static ?string $activeNavigationIcon = 'heroicon-s-bell';
    protected static ?string $navigationLabel = 'اشعارات محلية';
    protected static ?string $pluralLabel = 'الاشعارات';
    protected static ?string $modelLabel = 'اشعار';

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
                Forms\Components\Section::make('تفاصيل الاشعار')->schema([
                    Forms\Components\TextInput::make('title')
                        ->label("عنوان الاشعار")
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('content')
                        ->required()
                        ->label('محتوي الاشعار')
                    ,
                ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('اسم المستخدم')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان الاشعار')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('content')
                    ->label('محتوي الاشعار')
                    ->searchable(),
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
            'index' => Pages\ListLocalNotifications::route('/'),
            'create' => Pages\CreateLocalNotification::route('/create'),
            'edit' => Pages\EditLocalNotification::route('/{record}/edit'),
        ];
    }
}
