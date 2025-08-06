<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps;

use App\Models\City;
use App\Models\Cv;
use App\Models\Department;
use App\Models\HigherEducation;
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

final class HigherEducationInfo extends Component
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

    /** @var Collection<int, HigherEducation> */
    public Collection $higherEducations;

    /** @var Collection<int, Department> */
    public Collection $departments;

    /** @var Collection<int, City>|list<null> */
    public Collection|array $cities = [];

    public function mount(): void
    {
        $user = request()->user();
        assert($user instanceof User);

        assert($user->cv instanceof Cv);
        $this->cv = $user->cv;
    }

    public function store(): void
    {
        $this->validate();

        /** @var HigherEducation $higherEducation */
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

        $this->reset(['type', 'semester', 'date_semester', 'licensed', 'department_id', 'city_id', 'certification']);
    }

    public function delete(HigherEducation $higherEducation): void
    {
        $higherEducation->delete();

        LivewireAlert::title('Educación Superior Eliminada')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    #[On('navigate')]
    public function navigate(): void
    {
        $this->redirectRoute('cv.work-experience-info', navigate: true);

        LivewireAlert::title('Información De Educación Superior Guardada')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    // @codeCoverageIgnoreStart
    public function updateCities(): void
    {
        $department = Department::query()->findOrFail($this->department_id);
        $this->cities = $department->cities()->get();
    }

    // @codeCoverageIgnoreEnd
    #[On('refresh')]
    public function render(): View
    {
        $this->departments = Department::all();
        $this->higherEducations = $this->cv->higherEducations ?: collect();

        return view('livewire.cv.steps.higher-education-info');
    }
}
