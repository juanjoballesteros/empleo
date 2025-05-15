<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps\HigherEducation;

use App\Models\City;
use App\Models\Department;
use App\Models\HigherEducation;
use Flux\Flux;
use Illuminate\Support\Collection;
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

    #[Validate(['nullable', 'image'])]
    public ?TemporaryUploadedFile $certification = null;

    /** @var Collection<int, Department> */
    public Collection $departments;

    /** @var Collection<int, City>|list<City> */
    public Collection|array $cities = [];

    #[On('edit')]
    public function edit(HigherEducation $higherEducation): void
    {
        $this->higherEducation = $higherEducation;
        $this->cities = $higherEducation->department->cities;
        $this->fill($higherEducation);
        $this->date_semester = $higherEducation->date_semester->format('Y-m-d');
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
            'type',
            'semester',
            'date_semester',
            'licensed',
            'program',
            'department_id',
            'city_id',
        ]));

        $this->dispatch('refresh');
        Flux::modal('edit')->close();
    }

    public function render(): View
    {
        $this->departments = Department::all();

        return view('livewire.cv.steps.higher-education.edit');
    }
}
