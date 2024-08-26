<?php

namespace App\Filament\Resources;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\BusResource\Pages;
use App\Models\Bus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class BusResource extends Resource
{
    protected static ?string $model = Bus::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $activeNavigationIcon = 'heroicon-s-squares-2x2';

    protected static ?string $navigationLabel = 'وسائل النقل';
    protected static ?string $pluralLabel = 'وسائل النقل';
    protected static ?string $modelLabel = 'وسيلة نقل';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->label('ماركة وسيلة النقل')
                    ->suffixIcon('heroicon-s-pencil-square')
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->required()
                    ->label('فئة وسيلة النقل')
                    ->suffixIcon('heroicon-s-tag')
                    ->relationship('category', 'name')
                ,
                Forms\Components\FileUpload::make('images')
                    ->required()
                    ->multiple()
                    ->image()
                    ->label('صور وسيلة النقل')
                    ->imageEditor()
                    ->imagePreviewHeight('250')
                    ->loadingIndicatorPosition('left')
                    ->removeUploadedFileButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left')
                    ->panelLayout('grid')
                ,
                Forms\Components\ToggleButtons::make('features')
                    ->required()
                    ->label('مميزات وسلة النقل')
                    ->multiple()
                    ->options([
                        "شاشات" => "شاشات",
                        "إنترنت" => "إنترنت",
                        "نظام صوتي" => "نظام صوتي",
                        "تبريد / تسخين" => "تبريد / تسخين",
                        "نظام تهوية" => "نظام تهوية",
                        "منفذ شاحن USB / Type C" => "منفذ شاحن USB / Type C",
                        "بوفيه خدمة ذاتية" => "بوفيه خدمة ذاتية",
                        "كاميرات مراقبة" => "كاميرات مراقبة",
                        "دورة مياه" => "دورة مياه",
                        "إسعافات أولية" => "إسعافات أولية"

                    ])
                    ->icons([
                        "شاشات" => "heroicon-s-device-tablet",
                        "إنترنت" => "heroicon-s-wifi",
                        "نظام صوتي" => "heroicon-s-speaker-wave",
                        "تبريد / تسخين" => "heroicon-s-sun",
                        "نظام تهوية" => "heroicon-s-power",
                        "منفذ شاحن USB / Type C" => "heroicon-s-battery-100",
                        "بوفيه خدمة ذاتية" => "heroicon-s-cake",
                        "كاميرات مراقبة" => "heroicon-s-camera",
                        "دورة مياه" => "heroicon-s-hand-raised",
                        "إسعافات أولية" => "heroicon-s-table-cells"

                    ])
                    ->columns(5)
                    ->gridDirection('row')
                ,
                Forms\Components\TextInput::make('capacity')
                    ->required()
                    ->suffixIcon('heroicon-s-user-group')
                    ->label('سعة التحميل')
                    ->numeric(),
                Forms\Components\TextInput::make('luggage_capacity')
                    ->required()
                    ->label('عدد الحقائب')
                    ->suffixIcon('heroicon-s-shopping-bag')
                    ->numeric(),
                Forms\Components\TextInput::make('max_speed')
                    ->label('أقصي سرعة لوسيلة النقل')
                    ->suffixIcon('heroicon-s-bolt')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('is_available')
                    ->label('التوفر')
                    ->required(),
                Forms\Components\Section::make('اضافة المسارات')->schema([
                    Forms\Components\Repeater::make('busRoutes')
                    ->label('مسارات النقل')
                    ->relationship('busRoutes')
                    ->schema([
                        Forms\Components\Select::make('route_id')
                            ->relationship('route', 'name')
                            ->label('اسم المسار')
                            ->suffixIcon('heroicon-s-map-pin')
                            ->required(),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->label('السعر')
                            ->suffix('ريال')
                            ->required(),
                    ])
                    ->required()
                    ->columns(2),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('ماركة وسيلة الفئة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('اسم الفئة')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('images')
                    ->label('صور وسيلة النقل')
                ,
                Tables\Columns\TextColumn::make('capacity')
                    ->label('سعة التحميل')
                    ->suffix(' راكب')
                    ->sortable(),
                Tables\Columns\TextColumn::make('luggage_capacity')
                    ->label('سعة الحقائب')
                    ->suffix(' حقيبة')
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_speed')
                    ->label('اقصي سرعة')
                    ->suffix(' كيلومتر')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_available')
                    ->label('هل متوفر')
                    ->boolean(),
                Tables\Columns\TextColumn::make('تاريخ الانشاء')
                    ->dateTime()
                    ->sortable()
                    ->label('تاريخ الانشاء')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('تاريخ التحديث')
                    ->dateTime()
                    ->sortable()
                    ->label('تاريخ التحديث')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBuses::route('/'),
            'create' => Pages\CreateBus::route('/create'),
            'edit' => Pages\EditBus::route('/{record}/edit'),
        ];
    }
}
