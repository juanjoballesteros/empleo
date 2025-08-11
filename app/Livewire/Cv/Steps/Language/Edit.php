<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps\Language;

use App\Models\LanguageInfo;
use Flux\Flux;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class Edit extends Component
{
    use WithFileUploads;

    public LanguageInfo $languageInfo;

    #[Validate(['required', 'string', 'max:255'])]
    public string $name;

    #[Validate(['required', 'string', 'max:255'])]
    public string $write;

    #[Validate(['required', 'string', 'max:255'])]
    public string $speak;

    #[Validate(['required', 'string', 'max:255'])]
    public string $read;

    #[Validate(['nullable', 'image'])]
    public ?TemporaryUploadedFile $certificate = null;

    public ?string $certificate_url = null;

    #[On('edit')]
    public function edit(LanguageInfo $languageInfo): void
    {
        $this->languageInfo = $languageInfo;
        $this->fill($languageInfo);
        $this->certificate_url = $languageInfo->getFirstMediaUrl();
        Flux::modal('edit')->show();
    }

    public function update(): void
    {
        $this->validate();

        if ($this->certificate instanceof TemporaryUploadedFile) {
            if (($certificate = $this->languageInfo->getFirstMedia()) instanceof Media) {
                $certificate->delete();
            }

            $this->languageInfo->addMedia($this->certificate)
                ->preservingOriginal()
                ->toMediaCollection();
        }

        $this->languageInfo->update($this->pull([
            'name',
            'write',
            'speak',
            'read',
        ]));

        $this->dispatch('lang.edit');
        Flux::modal('edit')->close();
    }

    public function render(): View
    {
        return view('livewire.cv.steps.language.edit');
    }
}
