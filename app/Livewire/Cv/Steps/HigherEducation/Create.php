<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps\HigherEducation;

use App\Models\Cv;
use App\Models\Department;
use Flux\Flux;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
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
    public string $type;

    #[Validate(['required', 'numeric'])]
    public string $semester;

    #[Validate(['required', 'date'])]
    public string $date_semester;

    #[Validate(['required', 'string', 'max:255'])]
    public string $licensed;

    #[Validate(['required', 'string', 'max:255'])]
    public string $program;

    #[Validate(['required', 'numeric'])]
    public string $department_id;

    #[Validate(['required', 'numeric'])]
    public string $city_id;

    #[Validate(['required', 'image'])]
    public ?TemporaryUploadedFile $certification = null;

    /** @var Collection<int, Department> */
    public Collection $departments;

    public function store(): void
    {
        $this->validate();

        $higherEducation = $this->cv->higherEducations()->create($this->only([
            'type',
            'semester',
            'date_semester',
            'licensed',
            'program',
            'department_id',
            'city_id',
        ]));

        assert($this->certification instanceof UploadedFile);
        $higherEducation->addMedia($this->certification)
            ->preservingOriginal()
            ->toMediaCollection();

        $this->cv->high = true;
        $this->cv->save();

        $this->dispatch('high.create');
        $this->reset(['type', 'semester', 'date_semester', 'licensed', 'department_id', 'city_id', 'certification']);

        LivewireAlert::title('Información Añadida')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
        Flux::modal('create')->close();
    }

    public function render(): View
    {
        $this->departments = Department::all();

        return view('livewire.cv.steps.higher-education.create');
    }
}
