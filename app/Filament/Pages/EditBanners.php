<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use App\Models\Banner;

class EditBanners extends Page implements HasForms
{
    use InteractsWithForms;

    public $banner;
    public $bannersImages = [];

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'اعدادات التطبيق';
    protected static ?string $navigationLabel = 'الصور الترويجية';

    protected static string $view = 'filament.pages.edit-banners';

    public function mount(): void
    {
        $this->banner = Banner::find(1);

        if ($this->banner) {
            // Initialize with existing images if record is found
            $this->bannersImages = $this->banner->images ?? [];
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('bannersImages')
                    ->label('الصور الترويجية')
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->imagePreviewHeight('250')
                    ->loadingIndicatorPosition('left')
                    ->removeUploadedFileButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left')
                    ->panelLayout('grid')
                    ->directory('banners')
                    ->enableReordering()
                    ->default($this->bannersImages),
            ]);
    }

    public function submit()
    {
        if (!$this->banner) {
            $this->banner = new Banner();
        }

        // Initialize an array to hold the new filenames
        $newImages = [];

        // Process each uploaded file
        foreach ($this->bannersImages as $file) {
            // Check if the file is an array and contains a 'path' key
            if (is_array($file) && isset($file['path'])) {
                // Extract the filename from the path
                $filename = basename($file['path']);
            } else {
                // Use the original filename if not an array
                $filename = basename($file);
            }

            // Verify the file extension
            // $extension = pathinfo($filename, PATHINFO_EXTENSION);
            // if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            //     continue; // Skip files with invalid extensions
            // }

            // Save the filename in the array
            $newImages[] = $filename;
        }

        // Update the banner record with the filenames
        $this->banner->update([
            'images' => $newImages,
        ]);

        Notification::make()
            ->title('تم تحديث الصور بنجاح!')
            ->success()
            ->send();
    }

}
