<?php

namespace App\Filament\Resources;
use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\RelationManagers\BookingContactRelationManager;
use App\Models\Reservation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $activeNavigationIcon = 'heroicon-s-book-open';

    protected static ?string $navigationLabel = 'الحجوزات';

    protected static ?string $pluralLabel = 'الحجوزات';
    protected static ?string $modelLabel = 'حجز';

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
                    ->disabled()
                    ->label('اختر العميل')
                    ->suffixIcon('heroicon-s-pencil-square')
                    ->relationship('user', 'name')
                ,
                Forms\Components\Select::make('bus_id')
                    ->required()
                    ->disabled()
                    ->label('اختر وسيلة النقل')
                    ->suffixIcon('heroicon-s-squares-2x2')
                    ->relationship('bus', 'type'),
                Forms\Components\Select::make('bus_route_id')
                    ->required()
                    ->disabled()
                    ->label('اختر مسار وسيلة النقل')
                    ->relationship('route', 'name'),
                Forms\Components\TextInput::make('num_pilgrims')
                    ->required()
                    ->label('عدد الحقائب')
                    ->disabled()
                    ->numeric(),
                Forms\Components\TextInput::make('num_buses')
                    ->required()
                    ->label('عدد وسائل النقل')
                    ->disabled()
                    ->numeric(),
                Forms\Components\TextInput::make('umrah_company')
                    ->required()
                    ->label('اسم شركة العمرة')
                    ->disabled()
                    ->maxLength(255),
                Forms\Components\Repeater::make('arrivalDepartures')
                    ->relationship('arrivalDepartures')
                    ->label('مواعيد الوصول والمغادرة')
                    ->disabled()
                    ->schema([
                        Forms\Components\DatePicker::make('date')->required()->label('التاريخ')->native(false)->prefixIcon("heroicon-s-calendar-days"),
                        Forms\Components\TimePicker::make('time')->label('التوقيت')->format('H:i A')->withoutSeconds()->placeholder('اختيار الوقت'),
                        Forms\Components\TextInput::make('flight_number')->required()->label('رقم الرحلة'),
                        Forms\Components\TextInput::make('airline')->required()->label('الخطوط الجوية'),
                        Forms\Components\Select::make('type')->label('نوع الموعد')
                            ->options([
                                'وصول' => 'وصول',
                                'مغادرة' => 'مغادرة',
                            ])
                            ->required(),
                    ])
                    ->required()
                    ->columns(5)
                    ->columnSpan('full'),
                Forms\Components\TextInput::make('mecca_hotel_name')
                    ->label('اسم فندق مكة')
                    ->disabled()
                    ->required()
                    ->suffixIcon('heroicon-s-home-modern')
                    ->maxLength(255),
                Forms\Components\TextInput::make('medina_hotel_name')
                    ->label('اسم فندق المدينة')
                    ->disabled()
                    ->required()
                    ->suffixIcon('heroicon-s-home-modern')
                    ->maxLength(255),
                Forms\Components\Repeater::make('internalMovements')
                    ->relationship('internalMovements')
                    ->label('التحركات الداخلية')
                    ->disabled()
                    ->schema([
                        Forms\Components\DatePicker::make('movement_date')->required()->label('تاريخ التحرك')->native(false)->prefixIcon("heroicon-s-calendar-days"),
                        Forms\Components\TextInput::make('from_place')->required()->label('من'),
                        Forms\Components\TextInput::make('to_place')->required()->label('الي'),
                        Forms\Components\TimePicker::make('movement_time')->label('توقيت التحرك')->format('H:i A')->withoutSeconds()->placeholder('اختيار الوقت'),
                        Forms\Components\TimePicker::make('bus_arrival_time')->label('توقيت وصول الباص')->format('H:i A')->withoutSeconds()->placeholder('اختيار الوقت'),
                    ])
                    ->required()
                    ->columns(5)
                    ->columnSpan('full'),
                Forms\Components\Repeater::make('visits')
                    ->relationship('visits')
                    ->label('المزارات')
                    ->disabled()
                    ->schema([
                        Forms\Components\DatePicker::make('visit_date')->required()->label('تاريخ المزار')->native(false)->prefixIcon("heroicon-s-calendar-days"),
                        Forms\Components\TextInput::make('from_place')->required()->label('من'),
                        Forms\Components\TextInput::make('to_place')->required()->label('الي'),
                        Forms\Components\TimePicker::make('movement_time')->label('توقيت التحرك')->format('H:i A')->withoutSeconds()->placeholder('اختيار الوقت'),
                        Forms\Components\TimePicker::make('bus_arrival_time')->label('توقيت وصول الباص')->format('H:i A')->withoutSeconds()->placeholder('اختيار الوقت'),
                    ])
                    ->required()
                    ->columns(5)
                    ->columnSpan('full'),
                Forms\Components\ToggleButtons::make('reservation_status')
                    ->label('حالة الحجز')
                    ->default('جاري المعالجة')
                    ->options([
                        'جاري المعالجة' => 'جاري المعالجة',
                        'مقبول' => 'مقبول',
                        'مرفوض' => 'مرفوض'

                    ])
                    ->icons([
                        'جاري المعالجة' => 'heroicon-s-arrow-path-rounded-square',
                        'مقبول' => 'heroicon-s-check',
                        'مرفوض' => 'heroicon-s-x-mark',

                    ])
                    ->colors([
                        'جاري المعالجة' => 'info',
                        'مقبول' => 'success',
                        'مرفوض' => 'warning',
                    ])
                    ->columns(3)
                    ->required(),


                // x-mark -- cloud -- check
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('user.name')
                    ->label('اسم العميل')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.phone')
                    ->label('رقم هاتف العميل')
                    ->sortable(),

                Tables\Columns\TextColumn::make('bus.type')
                    ->numeric()
                    ->label('نوع وسيلة النقل')
                    ->sortable(),
                Tables\Columns\SelectColumn::make('reservation_status')
                    ->label('حالة حجز وسيلة النقل')
                    ->options([
                        'جاري المعالجة' => 'جاري المعالجة',
                        'مقبول' => 'مقبول',
                        'مرفوض' => 'مرفوض'

                    ])
                    ,
                Tables\Columns\TextColumn::make('busRoute.route.name')
                    ->numeric()
                    ->label('مسار النقل')
                    ->sortable(),
                Tables\Columns\TextColumn::make('num_pilgrims')
                    ->numeric()
                    ->label('عدد الحقائب')
                    ->sortable(),
                Tables\Columns\TextColumn::make('num_buses')
                    ->label('عدد وسائل النقل')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('umrah_company')
                    ->label('اسم شركة العمرة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mecca_hotel_name')
                    ->label('اسم فندق مكة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('medina_hotel_name')
                    ->label('اسم فندق المدينة')
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),

                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BookingContactRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
