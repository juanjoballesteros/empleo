<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps\HigherEducation;

use App\Models\Department;
use App\Models\HigherEducation;
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

    public HigherEducation $higherEducation;

    #[Validate(['required', 'string', 'max:255'])]
    public string $program;

    #[Validate(['required', 'string', 'max:255'])]
    public string $institution;

    #[Validate(['required', 'string', 'max:255'])]
    public string $type;

    #[Validate(['required', 'date'])]
    public string $date_start;

    #[Validate(['required', 'bool'])]
    public bool $actual = false;

    #[Validate(['nullable', 'date', 'after:date_start'])]
    public ?string $date_end = null;

    #[Validate(['nullable', 'image'])]
    public ?TemporaryUploadedFile $certification = null;

    public ?string $certification_url = null;

    #[On('edit')]
    public function edit(HigherEducation $higherEducation): void
    {
        $this->higherEducation = $higherEducation;
        $this->fill($higherEducation);
        $this->date_start = $higherEducation->date_start->toDateString();
        $this->date_end = $higherEducation->date_end?->toDateString();
        $this->certification_url = $higherEducation->getFirstMediaUrl();
        $this->js('changeActual', $higherEducation->actual);
        Flux::modal('edit')->show();
    }

    public function update(): void
    {
        $this->validate();

        if ($this->certification instanceof TemporaryUploadedFile) {
            if (($certification = $this->higherEducation->getFirstMedia()) instanceof Media) {
                $certification->delete();
            }

            $this->higherEducation->addMedia($this->certification)
                ->preservingOriginal()
                ->toMediaCollection();
        }

        $this->higherEducation->update($this->pull([
            'program',
            'institution',
            'type',
            'date_start',
            'actual',
            'date_end',
        ]));

        $this->dispatch('high.edit');
        Flux::modal('edit')->close();
    }

    public function render(): View
    {
        return view('livewire.cv.steps.higher-education.edit', [
            'departments' => Department::all(),
        ]);
    }
}
