<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps\WorkExperience;

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
    public string $post;

    #[Validate(['required', 'date'])]
    public string $date_start;

    #[Validate(['required', 'bool'])]
    public bool $actual;

    #[Validate(['nullable', 'date', 'required_if:actual,false'])]
    public ?string $date_end = null;

    #[Validate(['required', 'email', 'max:255'])]
    public string $email;

    #[Validate(['required', 'numeric', 'digits:10', 'starts_with:3'])]
    public string $phone;

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

    public ?string $certification_url = null;

    #[On('edit')]
    public function edit(WorkExperience $workExperience): void
    {
        $this->workExperience = $workExperience;
        $this->fill($workExperience);
        $this->date_start = $workExperience->date_start->toDateString();
        $this->date_end = $workExperience->date_end?->toDateString() ?? null;
        $this->certification_url = $this->workExperience->getFirstMediaUrl();
        $this->js('changeActual', $workExperience->actual);
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

        if ($this->actual) {
            $this->date_end = null;
        }

        $this->workExperience->update($this->pull([
            'name',
            'post',
            'date_start',
            'actual',
            'date_end',
            'email',
            'phone',
            'address',
            'department_id',
            'city_id',
        ]));

        $this->dispatch('work.edit');
        Flux::modal('edit')->close();
    }

    public function render(): View
    {
        $this->departments = Department::all();

        return view('livewire.cv.steps.work-experience.edit');
    }
}
