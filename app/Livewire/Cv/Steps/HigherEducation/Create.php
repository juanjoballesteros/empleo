<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps\HigherEducation;

use App\Models\Cv;
use App\Models\Department;
use Flux\Flux;
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

    #[Validate(['nullable', 'required_if:actual,true', 'image'])]
    public ?TemporaryUploadedFile $certification = null;

    public function store(): void
    {
        $this->validate();

        $higherEducation = $this->cv->higherEducations()->create($this->pull([
            'program',
            'institution',
            'type',
            'date_start',
            'actual',
            'date_end',
        ]));

        if ($this->certification instanceof TemporaryUploadedFile) {
            $higherEducation->addMedia($this->certification)
                ->preservingOriginal()
                ->toMediaCollection();
        }

        $this->cv->high = true;
        $this->cv->save();

        $this->dispatch('high.create');
        $this->reset(['certification']);

        LivewireAlert::title('Información Añadida')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
        Flux::modal('create')->close();
    }

    public function render(): View
    {
        return view('livewire.cv.steps.higher-education.create', [
            'departments' => Department::all(),
        ]);
    }
}
