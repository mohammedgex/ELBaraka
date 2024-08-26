<?php

namespace App\Filament\Resources\ReservationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingContactRelationManager extends RelationManager
{
    protected static string $relationship = 'bookingContact';

    protected static ?string $heading = 'هواتف السائقين'; // Navigation label
    protected static ?string $pluralLabel = 'أرقام التواصل'; // Plural label
    protected static ?string $modelLabel = 'رقم تواصل'; // Model label

    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->label('اختر العميل')
                    ->suffixIcon('heroicon-s-pencil-square')
                    ->relationship('user', 'name')
                ,
                    Forms\Components\TextInput::make('driver_phone')
                    ->label('رقم الهاتف')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('driver_phone')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                ->label('اسم العميل')
                ,
                Tables\Columns\TextColumn::make('driver_phone')
                ->label('رقم الهاتف')
                ,

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
