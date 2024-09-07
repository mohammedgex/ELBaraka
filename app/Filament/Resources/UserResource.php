<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Carbon\Carbon;
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $activeNavigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'المستخدمين';

    protected static ?string $pluralLabel = 'المستخدمين';
    protected static ?string $modelLabel = 'مستخدم';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereDate('created_at', Carbon::today())->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('اسم المستخدم')
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->maxLength(255)
                    ->label('رقم الهاتف')
                    ->required()
                    ->default(null),
                Forms\Components\DatePicker::make('birthdate')->label('تاريخ الميلاد')->required(),
                Forms\Components\TextInput::make('passport_number')
                    ->maxLength(255)
                    ->label('رقم جواز السفر')
                    ->required()
                    ->default(null),
                Forms\Components\TextInput::make('country')
                    ->maxLength(255)
                    ->label('اسم الدولة')
                    ->required()
                    ->default(null),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->label('الايميل')
                    ->required()
                    ->maxLength(255),
                // Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->label('كلمة المرور')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->label('تفعيل الحساب'),
                // Forms\Components\Textarea::make('two_factor_secret')
                //     ->columnSpanFull(),
                // Forms\Components\Textarea::make('two_factor_recovery_codes')
                //     ->columnSpanFull(),
                // Forms\Components\DateTimePicker::make('two_factor_confirmed_at'),
                // Forms\Components\TextInput::make('current_team_id')
                //     ->numeric()
                //     ->default(null),
                // Forms\Components\TextInput::make('profile_photo_path')
                //     ->maxLength(2048)
                //     ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم المستخدم')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('صورة المستخدم'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birthdate')
                    ->date()
                    ->label('تاريخ الميلاد')
                    ->sortable(),
                Tables\Columns\TextColumn::make('passport_number')
                    ->label('رقم جواز السفر')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->label('الدولة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('الايميل')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('تفعيل الحساب'),


                // Tables\Columns\TextColumn::make('email_verified_at')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('two_factor_confirmed_at')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('current_team_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('profile_photo_path')
                //     ->searchable(),


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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
