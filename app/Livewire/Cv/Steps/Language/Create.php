<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps\Language;

use App\Models\Cv;
use Flux;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

final class Create extends Component
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

    public function store(): void
    {
        $this->validate();

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

        $this->cv->lang = true;
        $this->cv->save();

        $this->reset(['name', 'write', 'speak', 'read', 'certificate']);

        $this->dispatch('lang.create');
        Flux::modal('create')->close();
        LivewireAlert::title('Información añadida')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render(): View
    {
        return view('livewire.cv.steps.language.create');
    }
}
