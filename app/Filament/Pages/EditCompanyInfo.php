<?php

namespace App\Filament\Pages;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use App\Models\CompanyInfo;
use Filament\Forms\Components\TextInput;
class EditCompanyInfo extends Page implements HasForms
{
    use InteractsWithForms;

    public $companyInfo;

    // Define the properties
    public $address;
    public $location;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'بيانات التطبيق';
    protected static ?string $navigationGroup = 'اعدادات التطبيق';


    protected static string $view = 'filament.pages.edit-company-info';



    public function mount(): void
    {
        $this->companyInfo = CompanyInfo::find(1);
        $this->address = $this->companyInfo->address;
        $this->location = $this->companyInfo->location; // Load the record with ID 10
        $this->form->fill($this->companyInfo->toArray());
    }

    public function getTitle(): string
    {
        return 'تعديل بيانات التطبيق';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('address')
                    ->label('عنوان الشركة')
                    ->required()
                    ->default($this->address)
                ,
                TextInput::make('location')
                    ->label('احداثيات المكان')
                    ->required()
                    ->default($this->location)
                ,
            ])
        ;
    }

    public function submit()
    {
        $this->validate();
        $this->companyInfo->update([
            'address' => $this->address,
            'location' => $this->location,
        ]);
        Notification::make()
            ->title('تم تحديث بيانات الشركة بنجاح!')
            ->success()
            ->send()
        ;


    }
}
