<?php

declare(strict_types=1);

namespace App\Livewire\Cv\Steps;

use App\Models\City;
use App\Models\Cv;
use App\Models\Department;
use App\Models\User;
use App\Models\WorkExperience;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

final class WorkExperienceInfo extends Component
{
    use WithFileUploads;

    public Cv $cv;

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
    public string $department_id;

    #[Validate(['required', 'numeric'])]
    public string $city_id;

    #[Validate(['required', 'image'])]
    public ?TemporaryUploadedFile $certification = null;

    /** @var Collection<int, WorkExperience> */
    public Collection $workExperiences;

    /** @var Collection<int, Department> */
    public Collection $departments;

    /** @var Collection<int, City>|list<null> */
    public Collection|array $cities = [];

    public function mount(): void
    {
        $this->departments = Department::all();

        $user = request()->user();
        assert($user instanceof User);

        assert($user->cv instanceof Cv);
        $this->cv = $user->cv;
    }

    public function store(): void
    {
        $this->validate();

        /** @var WorkExperience $workExperience */
        $workExperience = $this->cv->workExperiences()->create($this->only([
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

        assert($this->certification instanceof UploadedFile);
        $workExperience->addMedia($this->certification)
            ->preservingOriginal()
            ->toMediaCollection();

        $this->reset([
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
            'certification']);

        LivewireAlert::title('Información añadida')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function delete(WorkExperience $workExperience): void
    {
        $workExperience->delete();

        LivewireAlert::title('Experiencia Laboral Eliminada')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    #[On('navigate')]
    public function navigate(): void
    {
        $this->redirectRoute('cv.create.language-info', navigate: true);

        LivewireAlert::title('Progreso Guardado')
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
        $this->workExperiences = $this->cv->workExperiences ?: collect();

        return view('livewire.cv.steps.work-experience-info');
    }
}
