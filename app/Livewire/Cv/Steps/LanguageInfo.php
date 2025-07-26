<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps;

use App\Models\Cv;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

final class LanguageInfo extends Component
{
    use WithFileUploads;

    public Cv $cv;

    #[Validate(['required', 'string', 'max:255'])]
    public string $name;

    #[Validate(['required', 'string', 'max:255'])]
    public string $write;

    #[Validate(['required', 'string', 'max:255'])]
    public string $speak;

    #[Validate(['required', 'string', 'max:255'])]
    public string $read;

    #[Validate(['required', 'image'])]
    public ?TemporaryUploadedFile $certificate = null;

    /** @var Collection<int, \App\Models\LanguageInfo> */
    public Collection $languagesInfos;

    public function mount(): void
    {
        $user = request()->user();
        assert($user instanceof User);
        $this->cv = $user->cv;
    }

    public function store(): void
    {
        $this->validate();

        /** @var \App\Models\LanguageInfo $languageInfo */
        $languageInfo = $this->cv->languageInfos()->create($this->only([
            'name',
            'write',
            'speak',
            'read',
        ]));

        assert($this->certificate instanceof UploadedFile);
        $languageInfo->addMedia($this->certificate)
            ->preservingOriginal()
            ->toMediaCollection();

        $this->reset(['name', 'write', 'speak', 'read', 'certificate']);

        LivewireAlert::title('Información añadida')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function delete(\App\Models\LanguageInfo $languageInfo): void
    {
        $languageInfo->delete();

        LivewireAlert::title('Información de Idioma Eliminada')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function navigate(): void
    {
        $this->redirectRoute('cv.pdf');
    }

    #[On('refresh')]
    public function render(): View
    {
        $this->languagesInfos = $this->cv->languageInfos ?: collect();

        return view('livewire.cv.steps.language-info');
    }
}
