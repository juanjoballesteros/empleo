<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps\WorkExperience;

use App\Models\City;
use App\Models\Department;
use App\Models\WorkExperience;
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

    public WorkExperience $workExperience;

    #[Validate(['required', 'string', 'max:255'])]
    public string $name;

    #[Validate(['required', 'string', 'max:255'])]
    public string $type;

    #[Validate(['required', 'email', 'max:255'])]
    public string $email;

    #[Validate(['required', 'numeric', 'digits:10', 'starts_with:3'])]
    public string $phone_number;

    #[Validate(['required', 'date'])]
    public string $date_start;

    #[Validate(['required', 'string', 'max:255'])]
    public string $actual;

    #[Validate(['required', 'date'])]
    public string $date_end;

    #[Validate(['required', 'string', 'max:255'])]
    public string $cause;

    #[Validate(['required', 'string', 'max:255'])]
    public string $post;

    #[Validate(['required', 'string', 'max:255'])]
    public string $dependency;

    #[Validate(['required', 'string', 'max:255'])]
    public string $address;

    #[Validate(['required', 'numeric'])]
    public int $department_id;

    #[Validate(['required', 'numeric'])]
    public int $city_id;

    #[Validate(['nullable', 'image'])]
    public ?TemporaryUploadedFile $certification = null;

    /** @var Collection<int, Department> */
    public Collection $departments;

    /** @var Collection<int, City>|list<City> */
    public Collection|array $cities = [];

    #[On('edit')]
    public function edit(WorkExperience $workExperience): void
    {
        $this->workExperience = $workExperience;
        $this->cities = $workExperience->department->cities;
        $this->fill($workExperience);
        $this->date_start = $workExperience->date_start->format('Y-m-d');
        $this->date_end = $workExperience->date_end->format('Y-m-d');
        Flux::modal('edit')->show();
    }

    public function update(): void
    {
        $this->validate();

        if ($this->certification instanceof TemporaryUploadedFile) {
            if (($certification = $this->workExperience->getFirstMedia()) instanceof Media) {
                $certification->delete();
            }
            $this->workExperience->addMedia($this->certification)
                ->preservingOriginal()
                ->toMediaCollection();
        }

        $this->workExperience->update($this->pull([
            'name',
            'type',
            'email',
            'phone_number',
            'date_start',
            'actual',
            'date_end',
            'cause',
            'post',
            'dependency',
            'address',
            'department_id',
            'city_id',
        ]));

        $this->dispatch('refresh');
        Flux::modal('edit')->close();
    }

    public function render(): View
    {
        $this->departments = Department::all();

        return view('livewire.cv.steps.work-experience.edit');
    }
}
